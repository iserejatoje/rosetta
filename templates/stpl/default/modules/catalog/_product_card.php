<?
      $photos = $vars['product']->photos;
?>

<div class="product-card-close"></div>
<div class="col n8 sm-n12 product-img">
      <div class="product-img-wrp">
            <div class="img-previews">
            <? $i = 0; ?>
            <? foreach($photos as $photo) {
                ++$i;
            ?>
                  <div class="img-preview<?if($i==1){?> active<?}?>">
                        <img src="<?=$photo->PhotoSmall['f']?>" alt="<?=UString::ChangeQuotes($photo->AltText)?>" title="<?=UString::ChangeQuotes($photo->Title)?>" class="img-responsive">
                  </div>
            <? } ?>
            </div>
            <div class="img-slider">
            <? $i = 0; ?>
            <? foreach($photos as $photo) {
                ++$i;
            ?>
                  <div class="img-slider-item<?if($i==1){?> active<?}?>">
                        <img src="<?=$photo->PhotoLarge['f']?>" alt="<?=UString::ChangeQuotes($photo->AltText)?>" title="<?=UString::ChangeQuotes($photo->Title)?>" class="img-responsive">
                  </div>
            <? } ?>
            </div>
      </div>
</div>
<div class="col n4 sm-n12 product-info">
      <div class="product-info-wrp">
            <div class="product-type"><?=$vars['type']->Title?></div>
            <div class="product-name"><?=$vars['product']->Name?></div>
            <div class="product-description">
                  <?=$vars['product']->Text?>
            </div>
            <div class="product-controls clearfix">
                  <div class="product-parameters">
                        <div class="product-weight"><?=$vars['product']->Weight?>г</div>
                        <div class="product-cost"><?=number_format($vars['product']->Price, 0, "", "")?> Р</div>
                  </div>
                  <div class="product-add">
                        <div class="product-add-count">
                              <div class="count-dec">-</div>
                              <div class="current-count">1</div>
                              <div class="count-inc">+</div>
                        </div>
                        <div class="btn-desire" data-id="<?=$vars['product']->ID?>">хочу</div>
                  </div>
            </div>
      </div>
</div>