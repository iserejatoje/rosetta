<? foreach ($vars['products'] as $key => $product) {
        $areaRefs = $product->GetAreaRefs(App::$City->CatalogId);
        $category = $product->category;
        $type = $product->GetDefaultType(App::$City->CatalogId);
    ?>
    <div class="product-item">
        <? if($areaRefs['IsShare']) { ?><div class="product-item-discount">АКЦИЯ</div><? } 
            elseif($areaRefs['IsHit']) { ?><div class="product-item-discount hit">ХИТ</div><? } 
            elseif($areaRefs['IsNew']) { ?><div class="product-item-discount new">НОВИНКА</div><? } ?>
        
        <a class="product-item-img" href="/catalog/<?=$category->nameid?>/<?=$product->id?>/">
            <img <?= ($key > 13 ? 'loading="lazy"' : '');?> decoding="async" src="<?=$product->PhotoSmall['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($product->name)?>" title="<?=UString::ChangeQuotes($product->name)?>">
        </a>
        <div class="product-item-info">
            <div class="product-item-name"><?=$product->name?></div>
            <div class="article">арт. <?= $product->article?></div>
            <?php if($type): ?>
                <div class="product-item-price"><?=$type->GetPrice()?> <span class="product-item-unit">р.</span></div>
            <?php endif; ?>
            <button class="btn-pinky btn-make-order" data-id="<?=$product->id?>">заказать</button>
        </div>
    </div>
<? } ?>