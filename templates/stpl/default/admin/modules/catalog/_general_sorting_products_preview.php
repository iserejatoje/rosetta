<?php foreach($vars['products'] as $product): ?>
    <?php $areaRefs = $product->GetAreaRefs($vars['section_id']); ?>
    <div class="item col_-1-4 item-1-4" data-productid="<?=$product->ID?>" style="width:25%">
        <div class="product-item">
            <div class="num"><?=$areaRefs['Ord']?></div>
            <div class="name"><?=$product->Name?></div>
            <div class="lbl">&nbsp;</div>
            <div class="size"><?=$product->PhotoSmall['w']?>x<?=$product->PhotoSmall['h']?>px</div>
                <img src="<?=$product->PhotoSmall['f']?>" style="max-width: 100%; height: auto;">
            <input type="hidden" name="Ord[<?=$product->ID?>]" value="<?=$product->areaRefs['Ord']?>" id="prod-sort-<?=$product->ID?>"/>
        </div>
    </div>
<?php endforeach; ?>