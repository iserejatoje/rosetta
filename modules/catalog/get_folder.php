<?php

$product = $this->catalogMgr->GetProduct($this->_params['productid']);

if($product === null)
    Response::Status(404, RS_SENDPAGE | RS_EXIT);

$refs = $product->getAreaRefs(App::$City->CatalogId);
if(!$refs['IsAvailable']) {
    return STPL::Fetch('modules/catalog/folder', [
        'children' => $children,
        'noAvailable' => true,
    ]);
}

$filter = [
    'flags' => [
        'objects' => true,
        'ParentId' => $product->ProductId,
        'IsVisible' => 1,
        'IsAvailable' => 1,
    ],
    'dbg' => 0,
    // 'calc' => true,
    'field' => ['ord', 'productid'], //'TypeID',
    'dir' => ['ASC', 'DESC'],  //'DESC',
];

$children = $this->catalogMgr->GetProducts($filter);

if(!$children)
    Response::Status(404, RS_SENDPAGE | RS_EXIT);

App::$Title->Title = strip_tags(UString::ChangeQuotes($product->SeoTitle)) ?: $product->Name;
App::$Title->Description = strip_tags(UString::ChangeQuotes($product->SeoDescription));
App::$Title->Keywords = strip_tags(UString::ChangeQuotes($product->SeoKeywords));

return STPL::Fetch('modules/catalog/folder', [
    'children' => $children,
]);