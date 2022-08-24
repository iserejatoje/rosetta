 <?php
 
 $catalogMgr = CatalogMgr::GetInstance();
 foreach($vars['products'] as $product) {
    $isRange = false;
    $areaRefs = $product->GetAreaRefs(App::$City->CatalogId);
    $category = $product->category;
    $price = 0;
    if($category->kind == CatalogMgr::CK_BOUQUET) {
        $type = $product->default_type;
        if($type)
            $price = $type->GetPrice();
        else
            $price = 0;
    } elseif($category->kind == CatalogMgr::CK_FIXED) {
        $price = $product->GetPrice();
    } elseif($category->kind == CatalogMgr::CK_ROSE) {
        $isRange = true;
        $range = $product->getPriceRange(App::$City->CatalogId);
        $price = $range['MinPrice'] . ' - ' . $range['MaxPrice'];
    } elseif($category->kind == CatalogMgr::CK_FOLDER) {
        $isRange = true;
        $range = $product->getPriceRange(App::$City->CatalogId);
        if($range['MinPrice'] == $range['MaxPrice']) {
            $price = $range['MinPrice'];
        } else {
            $price = $range['MinPrice'] . ' - ' . $range['MaxPrice'];
        }
    } elseif($category->kind == CatalogMgr::CK_MONO) {
        $isRange = true;
        $range = $product->getPriceRange(App::$City->CatalogId);
        $price = $range['MinPrice'] . ' - ' . $range['MaxPrice'];
    }

    $fullPrice = '';
    // если товар - не папка и установлена скидка, вычисляем скидочную цену и сохраняем полную для перечеркивания
    $discountPercent = (int) $product->getDiscountPercent(App::$City->CatalogId);
    if(!$isRange && $catalogMgr->hasDiscount($areaRefs) && $discountPercent > 0) {
        $fullPrice = '&nbsp;' . $price . '&nbsp;';
        $price = $catalogMgr->getDiscountPrice($price, $product, App::$City->CatalogId);
        // $discountPercent = CatalogMgr::getDiscountValue();
    // Для монобкуетов и роз вычисляем диапазон цен с учетом скидки
    } elseif($catalogMgr->hasDiscount($areaRefs) && $discountPercent > 0) {
    	if(isset($range['MinPrice']) && isset($range['MaxPrice'])) {
            $minPrice = $catalogMgr->calcDiscountPrice($range['MinPrice'], $discountPercent);
            $maxPrice = $catalogMgr->calcDiscountPrice($range['MaxPrice'], $discountPercent);
            $price = $minPrice .' - '. $maxPrice;
        }
    }
?>
    <a href="/catalog/<?=$category->nameid?>/<?=$product->id?>/" class="product-item theme-<?= CatalogMgr::$THEMES[$product->Theme]['class']?>">
        <? if($areaRefs['ExcludeDiscount'] && $discountPercent > 0) { ?><div class="product-item-sale">-<?= $discountPercent ?>%</div><? } 
            elseif($areaRefs['IsShare']) { ?><div class="product-item-discount">АКЦИЯ</div><? } 
            elseif($areaRefs['IsHit']) { ?><div class="product-item-discount hit">ХИТ</div><? } 
            elseif($areaRefs['IsNew']) { ?><div class="product-item-discount new">НОВИНКА</div><? } ?>
        <div class="product-item-img">
            <?php if(isset($vars['isFolder']) && $vars['isFolder']): ?>
                <img src="<?=$product->PhotoSmall['f']?>" class="img-responsive" width="<?=$product->PhotoSmall['w']?>" height="<?=$product->PhotoSmall['h']?>">
            <?php else: ?>
                <img data-original="<?=$product->PhotoSmall['f']?>" src="/resources/img/design/rosetta/img-placeholder.jpg" class="img-responsive lazy" width="<?=$product->PhotoSmall['w']?>" height="<?=$product->PhotoSmall['h']?>">
            <?php endif; ?>
        </div>
        <div class="product-item-info">
            <div class="product-item-name"><?=$product->name?></div>
            <div class="article">
                <?php if($product->article): ?>
                    арт. <?= $product->article?>
                <?php endif; ?>
            </div>
            <?php if($catalogMgr->hasDiscount($areaRefs)): ?>
                <div class="product-item-price">
                    <span class="product-item-fullprice"><?= $fullPrice ?></span>
                    <?= $price ?> 
                    <span class="product-item-unit">р.</span>
                </div>
            <?php else: ?>
                <div class="product-item-price <? if($areaRefs['IsShare']) { ?>is-share<? } ?>">
                    <?= $price ?> 
                    <span class=" <? if($areaRefs['IsShare']) { ?>is-share<? } ?> product-item-unit">р.</span>
                </div>
            <?php endif; ?>
            <div class="single-arrow single-arrow-hollow"></div>
            <?php /* <div class="rounded-arrow"></div> */ ?>
        </div>
    </a>
<? } ?>