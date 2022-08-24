<div class="time-slider-container field-time-pickup-from ajax-required">
    <input type="hidden" class="begin-time" name="time-pickup-from" id="time-pickup-from" value="">
    <input type="hidden" class="end-time" name="time-pickup-to" id="time-pickup-to" value="">
    <div class="time-slider" id="pickup-time-slider" data-range="<?=$vars['from']?>,<?=$vars['to']?>"></div>
    <p class="help-block help-block-error" style="margin-top: 50px"></p>
    
    <?if(is_null($vars['errors']['pickup_date'])) { ?>
	    <div class="payment-limit">
	    	Для своевременного получения заказа Вам необходимо совершить оплату до 
            <span class="payment-time"><?= $vars['payment_time']['time']?></span> 
            (GMT +7:00)
            <span class="payment-date"><?= $vars['payment_time']['date']?></span>
	    </div>
	<? } ?>
    <? /*
    <input type="hidden" class="begin-time" value="" name="pickup_delivery_from">
    <input type="hidden" class="end-time" value="" name="pickup_delivery_to">
    <div class="time-slider" data-range="<?=$vars['from']?>,<?=$vars['to']?>"></div>
    */?>
</div>