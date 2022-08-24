<? if(is_array($vars['shares']) && sizeof($vars['shares'])) { ?>
	<div class="row">

        <div class="row">
            <div class="col n4 md-n12">
                <div class="page-title">
                    <div class="page-title-label">
                        акции
                        <div class="stroke-line"></div>
                        <div class="stroke-line"></div>
                    </div>
                </div>
            </div>
        </div>

		<? foreach($vars['shares'] as $share) { ?>
	        <div class="action-item col n12">
	            <div class="action-item-bg row" style="background: <?=$share->BgColor?>;">
	                <div class="action-item-img col n6 sm-n12">
	                    <img src="<?=$share->Thumb['f']?>" class="img-responsive">
	                </div>
	                <div class="action-item-desc col n6 sm-n12 clearfix">
	                    <div class="action-item-desc-wrp">
	                        <div class="action-title">
	                            <?=$share->Title?>
	                            <div class="stroke-line"></div>
	                            <div class="stroke-line"></div>
	                        </div>

							<? if($share->Text) { ?>
	                        <a href="javascript:;" class="action-item-more">
	                            Подробнее
	                        </a>
	                        <? } ?>
	                    </div>
	                </div>
	            </div>
	            <? if($share->Text) { ?>
	            	<div class="action-desc">
	            		<?=$share->Text?>
                    </div>
                <? } ?>
	        </div>
	    <? } ?>

    </div>
<? } else { ?>
	<div class="no-shares" style="margin: 20px 40px"><strong>На данный момент нет действующих акций</strong></div>
<? } ?>
