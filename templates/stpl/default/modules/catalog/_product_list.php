 <? foreach($vars['products'] as $product) {
    $areaRefs = $product->GetAreaRefs(App::$City->CatalogId);
    $category = $product->category;
    $price = 0;
    if($category->kind == CatalogMgr::CK_BOUQUET) {
        $type = $product->default_type;
        $price = $type->GetPrice();
    } elseif($category->kind == CatalogMgr::CK_MONO || $category->kind == CatalogMgr::CK_FIXED) {
        $price = $product->GetPrice();
    }
    ?>
    <a href="/catalog/<?=$category->nameid?>/<?=$product->id?>/" class="product-item">
        <? if($areaRefs['IsHit']) { ?><div class="product-item-hit">хит</div><? } ?>
        <div class="rounded-arrow">
            <div class="single-arrow"></div>
        </div>
        <div class="product-item-img">
            <img src="<?=$product->PhotoSmall['f']?>" class="img-responsive">
        </div>
        <div class="product-item-info">
            <div class="product-item-name"><?=$product->name?></div>
            <div class="product-item-price"><?=$price?> <span class="product-item-unit">р.</span></div>
            <div class="product-item-cart"></div>
        </div>
    </a>
<? } ?>