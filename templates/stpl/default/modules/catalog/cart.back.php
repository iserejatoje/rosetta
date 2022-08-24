<?
	$cart = $vars['cart'];
	$cart_items = $vars['cart']['items'];

	$b_size = [
			'Мини' => 'size-mini',
			'Миди' => 'size-midi',
			'Макси' => 'size-maxi',
			'мини' => 'size-mini',
			'миди' => 'size-midi',
			'макси' => 'size-maxi',
	];
?>

<div class="container">
	<h1 class="page-title">КОРЗИНА</h1>

	<div class="cart theme-purple">
    <form method="post" action="/catalog/" data-type="ajax-form" class="cart-form">
		<div class="cart-products">

			<?	foreach($cart_items as $key => $item) {
                $k = unserialize($key);
				$category = $item['product']->category;
				?>
				<div class="cart-products-item">
					<div class="cart-product-img">
						<img src="<?=$item['product']->PhotoCart['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($item['product']->Name)?>">
					</div>
					<div class="cart-product-info">
						<div class="cart-product-info-cols clearfix">
							<div class="cart-product-props-col">
								<div class="cart-product-name">
									<?=$item['product']->name?>
								</div>
								<? if($category->kind == CatalogMgr::CK_BOUQUET) { ?>
									<div class="cart-product-size <?=$b_size[$cart_items[$key]['type']['name']]?>">размер <?=$cart_items[$key]['type']['name']?></div>
								<? } elseif($category->kind == CatalogMgr::CK_ROSE) { ?>
									<div><?=$cart_items[$key]['params']['roses_count']?> шт., <?=$cart_items[$key]['params']['length']?> см.</div>
								<? } elseif($category->kind == CatalogMgr::CK_MONO) { ?>
									<div><?=$cart_items[$key]['params']['flower_count']?> шт.</div>
								<? } ?>
							</div>
							<div class="cart-product-count-col">
								<div class="count-switcher count-switcher-small">
									<input type="text" name="count" value="<?=$cart_items[$key]['count']?>" readonly="" autocomplete="off">
									<div class="count-switcher-btn count-switcher-down" data-action="ajax_dec_product_count">
										<div class="count-switcher-btn-sign"></div>
									</div>
									<div class="count-switcher-btn count-switcher-up" data-action="ajax_inc_product_count">
										<div class="count-switcher-btn-sign"></div>
									</div>
								</div>
							</div>
							<div class="cart-product-price-col">
								<div class="cart-product-price">
									<?=$cart_items[$key]['price']?> <span class="unit">р.</span>
									<span class="cart-product-remove is-active" data-action="ajax_remove_from_cart" data-ajax="true" data-control="checkbox">
										<input type="hidden" value="1" name="product_delete[51]">
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<? // cart product adds ?>
				<? foreach($cart_items[$key]['additions'] as $addid => $addition) { ?>
					<div class="cart-products-item item-add">
						<div class="cart-product-img">
							<img src="<?=$addition['object']->PhotoCart['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($addition['object']->name)?>">
						</div>
						<div class="cart-product-info">
							<div class="cart-product-info-cols clearfix">
								<div class="cart-product-props-col">
									<div class="cart-product-name">
										<?=$addition->name?>
									</div>
								</div>
								<div class="cart-product-count-col">
									<div class="count-switcher count-switcher-small">
										<input type="text" name="count" value="<?=$addition['count']?>" readonly="">
										<div class="count-switcher-btn count-switcher-down">
											<div class="count-switcher-btn-sign"></div>
										</div>
										<div class="count-switcher-btn count-switcher-up">
											<div class="count-switcher-btn-sign"></div>
										</div>
									</div>
								</div>
								<div class="cart-product-price-col">
									<div class="cart-product-price">
										<?=$addition['object']->price?> <span class="unit">р.</span>
										<span class="cart-product-remove" data-control="checkbox" data-ajax="true" data-action="ajax_add_remove_from_cart">
                                            <input type="hidden" name="product_delete[52]" value="0">
                                        </span>
									</div>
								</div>
							</div>
						</div>
					</div>
				<? } ?>
			<? } ?>
		</div>
		<div class="cart-cards clearfix">
			<div class="cart-card-text">
				<div class="cart-card-text-body">
					<div class="cart-card-label">Добавить открытку</div>
					<div class="cart-card-types" data-control="radiolist">
						<input type="hidden" value="0" name="card_type">
						<? foreach($vars['cards'] as $card) { ?>
							<div class="cart-card-type clearfix" data-control="radiobutton" data-cancel="true" data-id="<?=$card->id?>">
								<div class="cart-card-item-button"></div>
								<div class="cart-card-type-text"><?=$card->name?></div>
								<div class="cart-card-type-price"><?=$card->price?> <span class="unit">руб.</span></div>
							</div>
						<? } ?>
					</div>
					<div class="cart-card-text-control">
						<textarea placeholder="Текст пожелания" name="card_text"></textarea>
					</div>
				</div>
			</div>
			<div class="cart-card-item card-single"></div>
		</div>

		<div class="alert alert-theme-influence">
			<div class="alert-body">
				<div class="alert-icon">
					<spam class="alert-icon-text">!</spam>
				</div>
				<div class="alert-title">Уважаемые клиенты!</div>
				<div class="alert-message">
					Если доставка букета, полностью идентичного изображённому, в указанный день невозможна, наши флористы обязательно свяжутся с Вами для согласования замены цветов. Если ответ от Вас по каким-либо причинам не последовал, мы оставляем за собой право изменить состав или цвет букета на своё усмотрение. Флорист составит похожую композицию, равную по цене выбранного Вами варианта. Мы приложем все усилия для сохранения формы, размера и общей цветовой гаммы избранного Вами букета.
				</div>
				<div class="alert-checkbox">
					<div class="checkbox-check" data-control="checkbox">
						<input type="hidden" value="0">
						<div class="checkbox-check-button"></div>
						с информацией ознакомлен
					</div>
				</div>
			</div>
		</div>

		<div class="delivery-options">
			<div class="delivery-options-title">Выберите предпочтительный способ доставки:</div>
			<div class="delivery-options-tabs clearfix" data-control="radiolist">
				<input type="hidden" value="1">
				<div class="delivery-options-tab is-active" data-content="courier-delivery" data-control="radiobutton" data-id="1">
					<div class="delivery-options-tab-body">
						Курьерская доставка
						<div class="double-arrow">
							<div class="double-arrow-part arrow-right"></div>
							<div class="double-arrow-part arrow-left"></div>
						</div>
					</div>
				</div>
				<div class="delivery-options-tab" data-content="local-pickup" data-control="radiobutton" data-id="2">
					<div class="delivery-options-tab-body">
						Самовывоз
						<div class="double-arrow">
							<div class="double-arrow-part arrow-right"></div>
							<div class="double-arrow-part arrow-left"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="delivery-options-tab-content tab-courier-delivery is-visible">
				<div class="delivery-options-dark-wrapper">
					<div class="form-group group-general">
						<div class="form-group-label-with-arrow">
							Введите дату доставки:
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
							<div class="alert alert-float">
								<div class="alert-body">
									<div class="alert-icon">
										<spam class="alert-icon-text">!</spam>
									</div>
									<div class="alert-message">
										16 октября доставка осуществляться не будет. <br>
										Вы можете забрать букет самостоятельно <br>
										в любом из пунктов самовывоза.
									</div>
								</div>
							</div>
						</div>
						<div class="form-control-input">
							<input id="dp1448540150751" class="form-control-general fixed-short datepicker hasDatepicker" data-action="ajax_change_date_delivery" data-ajax="true" value="<?=$vars['today']?>">
						</div>
					</div>
					<div class="form-group group-general">
						<div class="form-group-label-with-arrow">
							Время доставки:
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
						</div>
						<div class="checkbox-list" data-control="radiolist">
							<input type="hidden" value="1">
							<div class="checkbox is-active" data-control="radiobutton" data-trigger-onactivate="showAdditional" data-trigger-oninactivate="hideAdditional" data-id="1">
								<div class="checkbox-body">
									<div class="checkbox-icon"></div>
									<div class="checkbox-label">Позвонить получателю для уточнения времени и адреса</div>
								</div>
							</div>
							<div class="checkbox-subitem">
								<div class="checkbox checkbox-round is-active is-hidden" data-control="checkbox" data-id="1">
									<input type="hidden" value="1">
									<div class="checkbox-body">
										<div class="checkbox-icon"></div>
										<div class="checkbox-label">не сообщать, что это цветы</div>
									</div>
								</div>
							</div>
							<div class="checkbox" data-control="radiobutton" data-trigger-onactivate="showAdditional" data-trigger-oninactivate="hideAdditional" data-id="2">
								<div class="checkbox-body">
									<div class="checkbox-icon"></div>
									<div class="checkbox-label">Доставить без звонка в указаный промежуток времени</div>
								</div>
							</div>
							<div class="checkbox-subitem is-hidden">
								<div class="time-slider-delivery-wrapper">
									<div class="time-slider-container">
										<input type="hidden" class="begin-time" value="">
										<input type="hidden" class="end-time" value="">
										<div class="time-slider" data-range="<?=$vars['time_delivery']['from']['sec']?>,<?=$vars['time_delivery']['to']['sec']?>">

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="order-info clearfix">
					<div class="order-info-dest">
						<div class="form-group form-group-underline form-group-underline-with-label">
							<div class="underline-form-label">Куда</div>

							<select class="form-control" data-type="underline">
								<option value="0" selected>(выберите район)</option>
								<? foreach($vars['districts'] as $district) { ?>
									<option value="<?=$district->id?>"><?=$district->Name?></option>
								<? } ?>
							</select>
						</div>
						<div class="form-group form-group-underline">
							<input type="text" class="form-control form-control-underline" placeholder="(адрес. максимально полно)">
						</div>
						<div class="form-group form-group-underline form-group-underline-with-label">
							<div class="underline-form-label">Кому</div>
							<input type="text" class="form-control form-control-underline" placeholder="">
						</div>
						<div class="form-group form-group-underline">
							<input type="text" class="form-control form-control-underline" placeholder="(номер телефона)">
						</div>
					</div>
					<div class="order-info-src">
						<div class="form-group form-group-underline form-group-underline-with-label label-long">
							<div class="underline-form-label">От кого</div>
							<input type="text" class="form-control form-control-underline" placeholder="(ваше имя)">
						</div>
						<div class="form-group form-group-underline">
							<input type="text" class="form-control form-control-underline" placeholder="(ваш e-mail)">
						</div>
						<div class="form-group form-group-underline">
							<input type="text" class="form-control form-control-underline" placeholder="(ваш номер телефона)">
						</div>
						<div class="delivery-cost clearfix">
							<div class="delivery-cost-label">Стоимость доставки:</div>
							<div class="delivery-cost-envelop">
								<div class="delivery-cost-envelop-rects clearfix">
									<div class="delivery-cost-envelop-rect empty"></div>
									<div class="delivery-cost-envelop-rect"></div>
									<div class="delivery-cost-envelop-rect"></div>
									<div class="delivery-cost-envelop-rect"></div>
									<div class="delivery-cost-envelop-rect"></div>
									<div class="delivery-cost-envelop-rect"></div>
									<div class="delivery-cost-envelop-rect"></div>
								</div>
								<div class="delivery-cost-sum">150<span class="unit">РУБ</span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="delivery-options-tab-content tab-local-pickup">
				<div class="delivery-options-dark-wrapper">
					<div class="form-group group-general">
						<div class="form-group-label-with-arrow">
							Введите дату самовывоза:
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
						</div>
						<div class="form-control-input">
							<input class="form-control-general fixed-short datepicker" value="24.08.2015">
						</div>
					</div>
					<div class="form-group group-general">
						<div class="form-group-label-with-arrow">
							Укажите время , в которое Вы приедете:
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
						</div>
						<div class="time-slider-pickup-wrapper">
							<div class="time-slider-container">
								<input type="hidden" class="begin-time" value="">
								<input type="hidden" class="end-time" value="">
								<div class="time-slider" data-range="32400,72000">

								</div>
							</div>
						</div>
					</div>
					<div class="form-group group-general">
						<div class="form-group-label-with-arrow">
							Выберите салон, из которого Вы заберете заказ:
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
						</div>
						<div class="rect-forms-wrapper">
							<select class="form-control" data-type="rectangular" >
								<? foreach($vars['stores'] as $store) { ?>
									<option value="<?=$store->ID?>"><?=$store->Address?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="form-group group-general">
						<div class="form-group-label-with-arrow">
							Ваши контакты:
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
						</div>
					</div>
					<div class="rect-forms-wrapper">
						<div class="form-group with-rect-input">
							<input type="text" class="form-control form-control-rectangular" placeholder="Имя">
						</div>
						<div class="form-group with-rect-input">
							<input type="text" class="form-control form-control-rectangular" placeholder="+ 7 909 6">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="pay-methods">
			<div class="section-label">Выберите способ оплаты:</div>
			<div class="pay-methods-body" data-control="radiolist">
				<input type="hidden" value="0">


				<div class="pay-method-item">
					<div class="pay-method-button pay-method-button-control">
						<div class="pay-method-button-checkbox" data-control="radiobutton" data-id="1">
							<div class="checkbox-icon"></div>
							Банковской картой на сайте <span class="text-muted">(VISA, MasterCard)</span>
						</div>
					</div>
				</div>

				<? foreach($vars['payment_types'] as $k => $item) { ?>
					<div class="pay-method-item <?=$item['class']?>" data-control="unfold-container">
						<div class="pay-method-button pay-method-button-control" data-control="unfold-button">
							<div class="pay-method-button-checkbox">
								<div class="double-arrow">
									<div class="double-arrow-part arrow-right"></div>
									<div class="double-arrow-part arrow-left"></div>
								</div>
								<?=$item['name']?>
								<div class="pay-method-notice">Выберите платежную систему</div>
							</div>
						</div>

						<div class="pay-method-content clearfix">
							<? foreach($item['list'] as $code => $type) { ?>
								<div class="pay-method-provider provider-<?=$type['class']?>" data-control="radiobutton" data-id="<?=$code?>">
									<div class="provider-checkbox-icon"></div>
									<div class="provider-icon"></div>
									<? if($type['haslabel']) { ?>
										<?=$type['name']?>
									<? } ?>
								</div>
							<? } ?>
						</div>
					</div>
				<? } ?>
<? /*
				<div class="pay-method-item pay-emoney-method" data-control="unfold-container">
					<div class="pay-method-button pay-method-button-control" data-control="unfold-button">
						<div class="pay-method-button-checkbox">
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
							Электронными деньгами
							<div class="pay-method-notice">Выберите платежную систему</div>
						</div>
					</div>

					<div class="pay-method-content clearfix">
						<div class="pay-method-provider provider-yandex" data-control="radiobutton" data-id="2">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Яндекс деньги
						</div>
						<div class="pay-method-provider provider-qiwi" data-control="radiobutton" data-id="3">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							QiWi кошелёк
						</div>
						<div class="pay-method-provider provider-webmoney" data-control="radiobutton" data-id="4">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							WebMoney
						</div>
						<div class="pay-method-provider provider-moneta" data-control="radiobutton" data-id="5">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>

						</div>
						<div class="pay-method-provider provider-alipay" data-control="radiobutton" data-id="6">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>

						</div>
					</div>

				</div>

				<div class="pay-method-item pay-bank-method" data-control="unfold-container">
					<div class="pay-method-button pay-method-button-control" data-control="unfold-button">
						<div class="pay-method-button-checkbox">
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
							Через банковскую систему
							<div class="pay-method-notice">Выберите банковскую систему</div>
						</div>
					</div>

					<div class="pay-method-content clearfix">
						<div class="pay-method-provider provider-sber" data-control="radiobutton" data-id="2">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Сбербанк<br>онлайн
						</div>
						<div class="pay-method-provider provider-qbank" data-control="radiobutton" data-id="3">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Qbank<br>
							Связной банк
						</div>
						<div class="pay-method-provider provider-rus-standard" data-control="radiobutton" data-id="4">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Русский<br>
							Стандарт
						</div>
						<div class="pay-method-provider provider-prom-bank" data-control="radiobutton" data-id="5">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Промсвязь<br>
							банк
						</div>
						<div class="pay-method-provider provider-alpha" data-control="radiobutton" data-id="6">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Альфа-<br>
							Клик
						</div>
						<div class="pay-method-provider provider-faktura" data-control="radiobutton" data-id="6">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>

						</div>
						<div class="pay-method-provider provider-pochta" data-control="radiobutton" data-id="6">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Почта<br>России
						</div>
						<div class="pay-method-provider provider-contact" data-control="radiobutton" data-id="6">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>

						</div>
					</div>

				</div>

				<div class="pay-method-item pay-mobile-method" data-control="unfold-container">
					<div class="pay-method-button pay-method-button-control" data-control="unfold-button">
						<div class="pay-method-button-checkbox">
							<div class="double-arrow">
								<div class="double-arrow-part arrow-right"></div>
								<div class="double-arrow-part arrow-left"></div>
							</div>
							SMS оплата
							<div class="pay-method-notice">Выберите Вашего оператора</div>
						</div>
					</div>

					<div class="pay-method-content clearfix">
						<div class="pay-method-provider provider-beeline" data-control="radiobutton" data-id="2">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Beeline
						</div>
						<div class="pay-method-provider provider-mts" data-control="radiobutton" data-id="3">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>

						</div>
						<div class="pay-method-provider provider-megafon" data-control="radiobutton" data-id="4">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>
							Мегафон
						</div>
						<div class="pay-method-provider provider-tele2" data-control="radiobutton" data-id="5">
							<div class="provider-checkbox-icon"></div>
							<div class="provider-icon"></div>

						</div>
					</div>

				</div>
*/?>
				<!-- <div class="pay-method-item">
                    <div class="pay-method-button pay-method-button-control">
                        <div class="pay-method-button-checkbox" data-control="radiobutton" data-id="1">
                            <div class="checkbox-icon"></div>
                            Наличными в салоне
                        </div>
                    </div>
                </div>

                <div class="pay-method-item">
                    <div class="pay-method-button pay-method-button-control">
                        <div class="pay-method-button-checkbox" data-control="radiobutton" data-id="1">
                            <div class="checkbox-icon"></div>
                            Банковской картой в салоне
                        </div>
                    </div>
                </div> -->

			</div>
		</div>

		<div class="order-checkout">
			<div class="section-label">Проверьте Ваш заказ:</div>
			<div class="order-checkout-grid">

				<div class="order-checkout-item">
					<div class="item-num">1.</div>
					<div class="item-col size-1 item-img">
						<img src="/resources/img/design/rosetta/cart/product-checkout.png">
					</div>
					<div class="item-col size-5 item-desc">
						<div class="item-name">Какое-то красивое название букета</div>
						<div class="item-property">размер: макси</div>
					</div>
					<div class="item-col size-2 item-count">
						1 шт.
					</div>
					<div class="item-col size-2 item-cost">
						12 500 р.
					</div>
				</div>

				<div class="order-checkout-item">
					<div class="item-num">2.</div>
					<div class="item-col size-1 item-img">
						<img src="/resources/img/design/rosetta/cart/product-checkout.png">
					</div>
					<div class="item-col size-5 item-desc">
						<div class="item-name">Мишка плюшевый с сердцем</div>
					</div>
					<div class="item-col size-2 item-count">
						1 шт.
					</div>
					<div class="item-col size-2 item-cost">
						1 200 р.
					</div>
				</div>

				<div class="order-checkout-item">
					<div class="item-num">3.</div>
					<div class="item-col size-1 item-img">
						<img src="/resources/img/design/rosetta/cart/product-checkout.png">
					</div>
					<div class="item-col size-5 item-desc">
						<div class="item-name">Мишка плюшевый с сердцем</div>
					</div>
					<div class="item-col size-2 item-count">

					</div>
					<div class="item-col size-2 item-cost">
						200 р.
					</div>
				</div>

				<div class="order-checkout-item">
					<div class="item-num">4.</div>
					<div class="item-col size-1 item-img">

					</div>
					<div class="item-col size-5 item-desc">
						<div class="item-name">Доставка  (Ленинский район)</div>
					</div>
					<div class="item-col size-2 item-count">

					</div>
					<div class="item-col size-2 item-cost">
						200 р.
					</div>
				</div>

			</div>
			<div class="order-checkout-total clearfix">
				<div class="order-checkout-total-label">Итого:</div>
				<div class="order-checkout-total-sum"><span class="text-pink">14 100</span> р.</div>
			</div>
		</div>

		<div class="payment-button">
			<button class="btn-pink">перейти на сервис оплаты</button>
		</div>
    </form>
	</div>
</div>



