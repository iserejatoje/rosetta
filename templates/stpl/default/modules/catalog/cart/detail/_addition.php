<div class="popup-card-img">
    <img src="<?=$vars['addition']->PhotoBig['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($vars['addition']->name)?>">
</div>

<div class="popup-card-info additions-item-container" data-id="<?=$vars['addition']->id?>">
    <div class="popup-card-info-title">
        <?=$vars['addition']->name?>
        <div class="additions-item-article">
            арт. <?=$vars['addition']->article?>
        </div>
    </div>
    <div class="popup-card-info-text">
        <?=$vars['addition']->description?>
    </div>
    <div class="popup-card-info-buy clearfix">
        <div class="popup-card-info-price"><?=$vars['addition']->price?> <span class="unit">р.</span></div>
        <button type="button" class="additions-item-cart-icon" data-control="add-adds"></button>
    </div>
</div>