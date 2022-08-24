<style>
	.field-block {
		margin: 3px;
	}

    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .table.form > tbody > tr > td {
        text-shadow: none;
    }
</style>

<script>

	var api = null;
	$(function() {
		$(".input-number-field").keypress(function(e){
			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
				return false;
		});

		$(".input-float-field").keypress(function(e){

			if( e.which!=8 && e.which!=0 && e.which != 46 && (e.which<48 || e.which>57))
				return false;
		});

	});

	//  ====================================

	function addField(fieldname)
	{
		var list = $('#'+fieldname+'-list');
		var html = $('#'+fieldname+'-etalon').html();

		html = html.replace(/etalon\-/g, "");
		list.append(html);
	}

	function removeField(obj)
	{
		$(obj).closest('.field-block').remove();
	}

</script>

<form method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="form table table-sriped">

		<tr>
			<td class="header-column">Почта для уведомления о заказах</td>
			<td class="data-column">

				<div id="emails-etalon" style="display:none">
				  	<div class="field-block col-sm-12">
						<div class="col-sm-4">
							<input class="form-control" name="etalon-Emails[]" value="<?=$email?>">
						</div>
						<div class="col-sm-4">
							<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить e-mail</button>
						</div>
					</div>
				</div>
				<!--  -->
				<button type="button" class="btn btn-info btn-xs" onclick="addField('emails')"><span class="glyphicon glyphicon-plus"></span> Добавить e-mail</button>
				<div id="emails-list" style="margin: 10px 0 0 0">
					<? foreach($vars['config']['order_emails'] as $email) { ?>
						<div class="field-block col-sm-12">
							<div class="col-sm-4">
								<input class="form-control" name="Emails[]" value="<?=$email?>">
							</div>

							<div class="col-sm-2">
								<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить e-mail</button>
							</div>
						</div>
					<? } ?>
				</div>

			</td>
		</tr>

		<tr>
			<td class="header-column">Почта для уведомления о новых отзывах</td>
			<td class="data-column">

				<div id="reviewemails-etalon" style="display:none">
				  	<div class="field-block col-sm-12">
						<div class="col-sm-4">
							<input class="form-control" name="etalon-ReviewEmails[]" value="<?=$email?>">
						</div>
						<div class="col-sm-4">
							<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить e-mail</button>
						</div>
					</div>
				</div>
				<!--  -->
				<button type="button" class="btn btn-info btn-xs" onclick="addField('reviewemails')"><span class="glyphicon glyphicon-plus"></span> Добавить e-mail</button>
				<div id="reviewemails-list" style="margin: 10px 0 0 0">
					<? foreach($vars['config']['review_emails'] as $email) { ?>
						<div class="field-block col-sm-12">
							<div class="col-sm-4">
								<input class="form-control" name="ReviewEmails[]" value="<?=$email?>">
							</div>

							<div class="col-sm-2">
								<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить e-mail</button>
							</div>
						</div>
					<? } ?>
				</div>

			</td>
		</tr>

		<tr>
			<td class="header-column">Режим рыботы</td>
			<td class="data-column">

				<!--  -->
				<div id="emails-list" style="margin: 10px 0 0 0">
                    <? if (($err = UserError::GetErrorByIndex('Workmode_InvalidRange')) != '' ) { ?>
                        <span class="error"><?=$err?></span><br/>
                    <? } ?>

                    <? if (($err = UserError::GetErrorByIndex('WorkmodeFrom_format')) != '' ) { ?>
                        <span class="error"><?=$err?></span><br/>
                    <? } ?>
                    <? if (($err = UserError::GetErrorByIndex('WorkmodeTo_format')) != '' ) { ?>
                        <span class="error"><?=$err?></span><br/>
                    <? } ?>
					<? foreach($vars['config']['workmode'] as $k => $mode) { ?>
						<div class="field-block col-sm-12">
							<div class="col-sm-1">
			    				<b><?=$vars['week'][$k]?>:</b>
			    			</div>

			    			<div class="col-sm-2">
			    				<input class="form-control" name="From[]" value="<?=$mode['from']?>">
			    			</div>

			    			<div class="col-sm-2">
			    				<input class="form-control" name="To[]" value="<?=$mode['to']?>">
			    			</div>
<?/*
			    			<div class="col-sm-2">
			    				<input class="form-control" type="checkbox" name="Disable[<?=$k?>]" value="1" <?if($mode['disable']){?> checked="checked"<?}?>>
			    			</div>
*/?>
    					</div>
						<? } ?>
				</div>

			</td>
		</tr>

		<tr>
			<td class="header-column">В эти дни не принимать заказ<br/><small>Дату писать в формате ДД.ММ</small></td>
			<td>
				<div id="days-etalon" style="display:none">
				  	<div class="field-block col-sm-12">
						<div class="col-sm-2">
							<input class="form-control" name="etalon-Days[]" value="">
						</div>
						<div class="col-sm-2">
							<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить день</button>
						</div>
					</div>
				</div>
				<!--  -->
				<button type="button" class="btn btn-info btn-xs" onclick="addField('days')"><span class="glyphicon glyphicon-plus"></span> Добавить день</button>
				<div id="days-list" style="margin: 10px 0 0 0">
					<? foreach($vars['config']['days'] as $day) { ?>
						<div class="field-block col-sm-12">
			    			<div class="col-sm-2">
			    				<input class="form-control" name="Days[]" value="<?=$day?>">
			    			</div>

			    			<div class="col-sm-2">
			    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить день</button>
			    			</div>
    					</div>
					<? } ?>
				</div>
			</td>
		</tr>

        <tr><td class="separator" colspan="2"></td></tr>
        <tr>
            <td class="header-column">Параметры роз<br/><small></small></td>
            <td class="data-column">
                <div style="margin: 10px 0 0 0">
                    <div class="field-block col-sm-12">
                        <div class="col-sm-2">
                            Минимум:
                            <input class="form-control" name="rose_min" value="<?=$vars['config']['rose_params']['min']?>">
                        </div>

<?/*
                        <div class="col-sm-2">
                            Шаг:
                            <input class="form-control" name="rose_step" value="<?=$vars['config']['rose_params']['step']?>">
                        </div>
*/?>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td class="header-column">Параметры монобукетов<br/><small></small></td>
            <td class="data-column">
                <div style="margin: 10px 0 0 0">
                    <div class="field-block col-sm-12">
                        <div class="col-sm-2">
                            Минимум:
                            <input class="form-control" name="mono_min" value="<?=$vars['config']['mono_params']['min']?>">
                        </div>
<?/*
                        <div class="col-sm-2">
                            Шаг:
                            <input class="form-control" name="mono_step" value="<?=$vars['config']['mono_params']['step']?>">
                        </div>
*/?>
                    </div>
                </div>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>
        <tr>
            <td class="header-column">Текст сообщения<br/><small>Для уведомления, когда нельзя сделать заказ</small></td>
            <td class="data-column">
                <!--  -->
                <div id="emails-list" style="margin: 10px 0 0 0">
                    <div class="field-block col-sm-12">
                        <div class="col-sm-4">
                            <input class="form-control" name="notice_title" value="<?=$vars['config']['noorder_text']['title']?>">
                        </div>
                        <div class="col-sm-8">
                            <input class="form-control" name="notice_message" value="<?=$vars['config']['noorder_text']['message']?>">
                        </div>
					</div>
				</div>

			</td>
		</tr>

		<tr>
			<td class="header-column">Текст сообщения в корзине<br/><small>Для уведомления, когда нельзя сделать заказ</small></td>
			<td class="data-column">
				<!--  -->
				<div id="emails-list" style="margin: 10px 0 0 0">
					<div class="field-block col-sm-12">
		    			<div class="col-sm-4">
		    				<input class="form-control" name="cart_notice_title" value="<?=$vars['config']['cart_noorder_text']['title']?>">
		    			</div>

		    			<div class="col-sm-8">
		    				<input class="form-control" name="cart_notice_message" value="<?=$vars['config']['cart_noorder_text']['message']?>">
		    			</div>
					</div>
				</div>

			</td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column">Период времени, в котром можно оформить доставку</td>
			<td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('Delivery_InvalidRange')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>
				<div class="field-block col-sm-12">
                    <? if (($err = UserError::GetErrorByIndex('DeliveryFrom_format')) != '' ) { ?>
                        <span class="error"><?=$err?></span><br/>
                    <? } ?>
					<div class="col-sm-2">от</div>
					<div class="col-sm-8">
						<input class="form-control" name="delivery_from" value="<?=$vars['config']['time_delivery']['from']?>">
					</div>
				</div>

				<div class="field-block col-sm-12">
                    <? if (($err = UserError::GetErrorByIndex('DeliveryTo_format')) != '' ) { ?>
                        <span class="error"><?=$err?></span><br/>
                    <? } ?>
					<div class="col-sm-2">до</div>
					<div class="col-sm-8">
						<input class="form-control" name="delivery_to" value="<?=$vars['config']['time_delivery']['to']?>">
					</div>
				</div>

				<div class="field-block col-sm-12">
					<div class="col-sm-2">время формирования заказа</div>
					<div class="col-sm-8">
						<input class="form-control" name="formation" value="<?=$vars['config']['time_delivery']['formation']?>">
					</div>
				</div>

				<div class="field-block col-sm-12">
					<div class="col-sm-2">сообщение для доставки<br/><small>Оповещение о времени на создание букета</small></div>
					<div class="col-sm-10">
						<input class="form-control" name="time_message_delivery" value="<?=$vars['config']['time_message']['delivery']?>">
					</div>
				</div>

				<div class="field-block col-sm-12">
					<div class="col-sm-2">сообщение для самовывоза<br/><small>Оповещение о времени на создание букета</small></div>
					<div class="col-sm-10">
						<input class="form-control" name="time_message_pickup" value="<?=$vars['config']['time_message']['pickup']?>">
					</div>
				</div>
			</td>
		</tr>


		<tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Уведомления</td>
            <td class="data-column">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="notice_email" value="1" <?if($vars['config']['notice']['email']){?>checked="checked"<?}?> > Email
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="notice_sms" value="1" <?if($vars['config']['notice']['sms']){?>checked="checked"<?}?> > SMS
                    </label>
                </div>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>
        <tr>
            <td class="header-column">SMS</td>
            <td class="data-column">
                <div class="checkbox">
                    <label>
                        login <input type="text" name="sms_login" class="form-control" value="<?=$vars['config']['sms']['login']?>" >
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        password <input type="password" name="sms_password" class="form-control" value="<?=$vars['config']['sms']['password']?>"  >
                    </label>
                </div>
            </td>
        </tr>
        <tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column">Скидочные карты</td>
			<td class="data-column">
				<div class="field-block col-sm-12">
					<div class="col-sm-1">Код</div>
					<div class="col-sm-1">%</div>
				</div>
				<? foreach($vars['config']['discount_code'] as $code => $discount) { ?>
					<div class="field-block col-sm-12">
						<div class="col-sm-1"><?=$code?></div>
						<div class="col-sm-1">
							<input class="form-control" name="discount_code[<?=$code?>]" value="<?=$discount?>">
						</div>
					</div>
				<? } ?>
			</td>
		</tr>

		<tr>
            <td class="header-column">Сумма заказа для получения скидочной карты</td>
            <td class="data-column">
                <input class="form-control" name="discount_price" value="<?=$vars['config']['discount_price']?>">
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
			<td class="header-column">Период заказа (дней)</td>
			<td class="data-column">
				<input type="number" class="form-control" name="days_period" value="<?= $vars['config']['days_period'] ?>">
			</td>
		</tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Показать опцию "Позвонить получателю для уточнения времени"</td>
            <td class="data-column">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="correction_call" value="1" <?php if($vars['config']['correction_call']){?>checked="checked"<?}?> >
                    </label>
                </div>
            </td>
        </tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>
	</table>
</form>
