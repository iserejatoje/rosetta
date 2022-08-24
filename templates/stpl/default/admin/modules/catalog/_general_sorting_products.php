<?php foreach($vars['products'] as $product): ?>
    <?php
    $title = '';
    $areaRefs = $product->GetAreaRefs($vars['section_id']);
    $visibility = $product->GetVisibility($vars['section_id']);
    ?>

    <div class="item col_-1-4 item-1-4" data-productid="<?=$product->ID?>">
        <div class="product-item" style="height: <?=$height?>px;<?if($visibility == false) {?>opacity: 0.5<?}?>">
            <div class="num"><?= $areaRefs['Ord'] ?></div>
            <div class="name"><?= $product->Name ?></div>
            <div class="lbl"><?= $title ?></div>
            <div class="size"><?= $product->PhotoSmall['w']?>x<?=$product->PhotoSmall['h'] ?>px</div>
                <img src="<?= $product->PhotoSmall['f'] ?>" style="width: 150px">
            <?php /*<input type="hidden" name="Ord[<?= $product->ID ?>]" value="<?= $areaRefs['Ord'] ?>" id="prod-sort-<?= $product->ID ?>"/>*/?>
            <input type="hidden" name="order[]" value="<?= $product->ID?>"/>
        </div>
    </div>
<?php endforeach; ?>