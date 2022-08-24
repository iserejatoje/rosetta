<div class="cart-cards" data-flower-id="<?=$vars['key']?>">
    <span class="cart-product-remove" title="Удалить открытку" style="top: 20px; right: 20px !important; z-index: 10;"></span>
    <div class="cart-card-text">
        <div class="cart-card-text-body">
            <div class="cart-card-label">Добавить открытку <a href="/resources/img/design/rosetta/cart/card-single.jpg" data-lightbox="card" class="cart-card-label-eye pull-right"><img src="/resources/img/design/rosetta/card-eye.png" alt="rosetta" class="img-responsive"></a></div>
            <div class="cart-card-types" data-control="radiolist">
                <input class="selected-postcard-id" type="hidden" name="card_id[<?=$vars['key']?>][]" value="">
                <input type="hidden" class="order_card_id" name="order_card_id[<?=$vars['key']?>]" value="<?=$vars['productid']?>">
                <?php foreach($vars['cards'] as $card) { ?>
                    <div class="cart-card-type clearfix" data-control="radiobutton" data-cancel="true" data-id="<?=$card->id?>" data-action="ajax_set_card">
                        <div class="cart-card-item-button"></div>
                        <div class="cart-card-type-text"><?=$card->name?></div>
                        <div class="cart-card-type-price"><?=$card->price?> <span class="unit">руб.</span></div>
                    </div>
                <?php } ?>
            </div>
            <div class="cart-card-text-control">
                <textarea placeholder="Текст пожелания" name="card_text[<?=$vars['key']?>][]"></textarea>
            </div>
        </div>
    </div>
    <div class="cart-card-item card-single"></div>
</div>