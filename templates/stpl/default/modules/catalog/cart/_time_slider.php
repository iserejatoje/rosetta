<div class="time-slider-container field-time-delivery-from ajax-required">
    <input type="hidden" class="begin-time" name="time-delivery-from" id="time-delivery-from" value="">
    <input type="hidden" class="end-time" name="time-delivery-to" id="time-delivery-to" value="">
    <input type="hidden" class="delivery-min-range" name="delivery-min-range" value="<?= $vars['minStep']?>">
    <div class="time-slider" id="delivery-time-slider" data-range="<?=$vars['from']?>,<?=$vars['to']?>"></div>
    <p class="help-block help-block-error" style="margin-top: 50px"></p>

    <?if(is_null($vars['errors']['delivery_date'])) { ?>
	    <div class="payment-limit">
	    	Для своевременного получения заказа Вам необходимо совершить оплату до 
	    	<span class="payment-time"><?= $vars['payment_time']['time']?></span> 
	    	(GMT +7:00)
	    	<span class="payment-date"><?= $vars['payment_time']['date']?></span>
	    </div>
	<? } ?>
</div>