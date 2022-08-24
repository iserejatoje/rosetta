 <? foreach($vars['products'] as $product) {
    $areaRefs = $product->GetAreaRefs(App::$City->CatalogId);
    $category = $product->category;
    $price = 0;
    if($category->kind == CatalogMgr::CK_BOUQUET) {
        $type = $product->default_type;
        if($type)
            $price = $type->GetPrice();
        else
            $price = 0;
    } elseif($category->kind == CatalogMgr::CK_MONO || $category->kind == CatalogMgr::CK_FIXED) {
        $price = $product->GetPrice();
    } elseif($category->kind == CatalogMgr::CK_ROSE) {
        $price = $product->GetPrice();
    }
    ?>
    <a href="/catalog/<?=$category->nameid?>/<?=$product->id?>/" class="product-item theme-<?= CatalogMgr::$THEMES[$product->Theme]['class']?>">
        <? if($areaRefs['IsShare']) { ?><div class="product-item-discount">АКЦИЯ</div><? } 
            elseif($areaRefs['IsHit']) { ?><div class="product-item-discount hit">ХИТ</div><? } 
            elseif($areaRefs['IsNew']) { ?><div class="product-item-discount new">НОВИНКА</div><? } ?>
        <div class="product-item-img">
            <img data-original="<?=$product->PhotoSmall['f']?>" src="/resources/img/design/rosetta/img-placeholder.jpg" class="img-responsive lazy" width="<?=$product->PhotoSmall['w']?>" height="<?=$product->PhotoSmall['h']?>">
        </div>
        <div class="product-item-info">
            <div class="product-item-name"><?=$product->name?></div>
            <div class="article">арт. <?= $product->article?></div>
            <div class="product-item-price <? if($areaRefs['IsShare']) { ?>is-share<? } ?>"><?=$price?> 
                <span class=" <? if($areaRefs['IsShare']) { ?>is-share<? } ?> product-item-unit">р.</span>
            </div>
            <div class="rounded-arrow">
                <div class="single-arrow"></div>
            </div>
        </div>
    </a>
<? } ?>