<?
    $block = $vars['blocks'];
?>

<!--  -->
<div class="shadow-sep"></div>

<div class="container">
    <h1 class="page-title">ОПЛАТА</h1>

    <div class="page-payments">
       <div class="payments">

            <div class="block-with-image">
                <div class="block-with-image-body">
                    <div class="block-with-image-left">
                        <div class="block-with-image-content">
                            <?=$block['PAYMENTS_QUESTIONS']->text?>
                        </div>
                    </div>

                    <div class="block-with-image-right" style="background-image: url(/resources/img/design/rosetta/payments/questions.jpg);">

                    </div>
                </div>
            </div>

            <div class="paragraph-block">
                <div class="paragraph-block-body">
                    <?=$block['PAYMENTS_SERVICE_PAYANYWAY']->text?>
                </div>
            </div>

            <div class="payments-banks clearfix">
                <div class="payment-block payment-block-half">
                    <div class="payment-block-body">
                        <?=$block['PAYMENTS_BANK_CARDS']->text?>
                    </div>
                </div>

                <div class="payment-block payment-block-half">
                    <div class="payment-block-body">
                        <?=$block['PAYMENTS_BANK_SYSTEMS']->text?>
                    </div>
                </div>
            </div>

            <div class="payments-emoney">
                <?=$block['PAYMENTS_E_MONEY']->text?>
            </div>

            <div class="payments-mobile">
                <div class="payments-mobile-body">
                    <?=$block['PAYMENTS_MOBILE']->text?>
                </div>
            </div>

       </div>
    </div>
</div>
<!--  -->