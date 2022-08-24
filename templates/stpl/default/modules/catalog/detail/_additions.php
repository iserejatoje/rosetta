<?php foreach($vars['additions'] as $addition) {
    ?>
    <?php $theme = CatalogMgr::$THEMES[$addition->theme]['class']?>
    <div class="additions-item-col">

        <?php
            in_array($addition->id, $vars['carts_additions'])?
                $is_added = 'is-added': $is_added = '';
        ?>

        <div class="additions-item additions-item-container <?= $is_added ?>" data-id="<?=$addition->id?>" data-theme="<?= $theme ?>">
            <div class="additions-active-wrapper">
                <div class="additions-item-img">
                    <img src="<?=$addition->PhotoSmall['f']?>" class="img-responsive" alt="rosetta">
                </div>
                <div class="additions-item-desc">
                    <div class="additions-item-desc-text">
                        <?=$addition->name?>
                        <div class="additions-item-article">
                            арт. <?=$addition->article?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="additions-item-info">
                <div class="additions-item-price"><?=$addition->price?> <span class="additions-item-unit">р.</span></div>
                <div class="additions-item-cart-icon" data-control="add-adds"></div>
            </div>
        </div>
    </div>
<? } ?>