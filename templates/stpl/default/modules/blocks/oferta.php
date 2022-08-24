<?
    $blocks = $vars['blocks'];
?>

<div class="shadow-sep"></div>

    <div class="container">
        <h1 class="page-title">ПУБЛИЧНЫЙ ДОГОВОР – ОФЕРТА</h1>

        <div class="page-offer">
            <div class="offer-grid">

                <div class="offer-section offer-section-striped">
                    <div class="block-body-wrapper">
                        <div class="offer-section-title offer-section-title-default">
                            Российская Федерация<br>
                            г. Кемерово, <?=date("Y", time())?> г.
                        </div>
                        <div class="offer-section-notice-ok">
                            СОВЕРШАЯ ПОКУПКУ В ИНТЕРНЕТ-МАГАЗИНЕ, КЛИЕНТ (ПОКУПАТЕЛЬ) СОГЛАШАЕТСЯ СО ВСЕМИ НИЖЕПЕРЕЧИСЛЕННЫМИ
                            УСЛОВИЯМИ
                        </div>
                    </div>
                </div>

                <?=$blocks['OFERTA_BLOCK']->text?>

            </div>
        </div>
    </div>

</div>