<div class="template-page wedding-template theme-purple">

    <?
        $vars['banner']?    $banner = $vars['banner']->file['f'] :
                            $banner = '/resources/img/design/rosetta/wedding-bouquets/top-bg.jpg';

    ?>

    <div class="fullsize-header" style="background-image: url(<?= $banner ?>);">
        <div class="container">
            <div class="fullsize-header-desc">
                <h1>Свадебные букеты</h1>
            </div>
            <div class="fullsize-header-info">
                <? /* <h2>Ваш самый главный букет</h2>
                <p>
                    Это флористический аксессуар, дополняющий
                    свадебное платье.
                </p>

                <p>
                    Самая известная традиция, связанная с букетом
                    невесты, заключается в примете: в церемонии,
                    перед тем как жених и невеста покинут гостей,
                    невеста встает спиной к подружкам невесты
                    и бросает букет.
                </p>

                <p>
                    Считается, что та,что его поймает, первой выйдет
                    замуж.
                </p> */ ?>
                <?= $vars['header_block'] ?>
            </div>
        </div>
    </div>

    <div class="shadow-sep"></div>

    <form method="post" action="/catalog/" data-form="ajax-filter">
        <input type="hidden" name="action" value="ajax_load_all_wedding">
    </form>

    <div class="products-grid pinky-mod wedding-bouquets-grid">
        <div class="container">
            <div class="products-grid-container clearfix">
                <?=STPL::Fetch('modules/catalog/products/_wedding_list', $vars)?>
            </div>
        </div>
    </div>

    <? if($vars['last_page'] === false) { ?>
        <div class="center-wrapper">
            <button class="btn-load-more">показать все</button>
        </div>
    <? } ?>

</div>

<div class="container">
    <div class="block-for-seo">
        <h1>Свадебные букеты невесты в Кемерово — заказ цветов в салоне «Розетта»</h1>
        <p>
        <strong>Свадебные букеты невесты</strong> — это целый раздел в творчестве опытного флориста. Специалист по флористике, являющийся дизайнером по цветам, уделяет 
        особое место данной тематике в своей деятельности. Это та область, в которой можно реализовать свой талант, как дизайнера-флориста. Любой <strong>заказ 
        цветов</strong> начинается с интереса и планируемого торжества, поэтому в первую очередь стоит найти подходящий <strong>салон цветов</strong> в Кемерово, в котором создают 
        <strong>букеты невесты</strong> исключительно на заказ. Сегодня каждый второй <strong>салон цветов</strong> в Кемерово может предложить <strong>свадебные букеты</strong> готового типа, однако 
        важно понимать разницу между определениями <strong>"свадебные букеты"</strong> и "букет невесты", в первом случае можно говорить о букете, который дарится 
        гостями, во втором — неотъемлемая часть образа невесты. 
        </p>
        <p>
        Традиционно свадебные букеты заказываются заранее, чтобы продумать каждую деталь и дополнить образ тематическим букетом. Букет невесты зачастую 
        создается из классических цветов, таких как розы и гортензии, а также из особенных: пионовидная роза, лютики и нарциссы! Современный букет невесты 
        отличается небольшим размером, изящностью исполнения и удобным оформлением нижней части композиции. 
        </p>
    </div>
    <div class="block-for-seo">
        <h2>«Rosetta» — заказ цветов и оригинальные свадебные букеты</h2>
        <p>
        <strong>Заказ цветов</strong> в Кемерово с доставкой на дом безусловно комфортный сервис, однако не стоит забывать, что свадебные букеты это нечто особенное, 
        требующее особого внимания, поэтому каждая деталь обсуждается с профессиональным флористом, например, состав свадебного букета, цвет, 
        оформление, лента и даже плотность цветов в самом букете. 
        </p>
        <p>
        Почти каждый городской салон цветов в ХХХ создает свои варианты свадебных букетов, однако в данном вопросе стоит доверять букетной мастерской с 
        репутацией, имеющей достойный опыт в создании свадебных букетов, готовой поручиться за результат. Флористы ХХХ имеют необходимый опыт и фотокаталог 
        с подтвержденными работами в области свадебной флористики. Можно быть уверенным, что заказ цветов, тем более свадебной тематики, будет исполнен 
        по высочайшим стандартам европейской флористики.
        </p>
    </div>
</div>

<?/*
<div class="popups">
    <div id="popup-make-order" class="popup popup-item">
        <div class="close-btn"></div>
        <div class="popup-body">
            <div class="popup-notice">
                Оставьте заявку на заказ свадебного букета<br>
                и наши специалисты свяжутся с вами.
            </div>
            <div class="popup-form">
                <form method="post" action="/catalog/">
                    <input type="hidden" name="action" value="ajax_send_bouquet_offer">
                    <input type="hidden" name="id" value="">
                    <div class="form-group-grid clearfix">
                        <div class="form-group group-part-left group-2-3">
                            <input type="text" class="form-control form-control-rect-simple" placeholder="Ваше имя" name="username" autocomplete="off">
                        </div>
                        <div class="form-group group-part-right group-1-3">
                            <input type="text" class="form-control form-control-rect-simple" placeholder="Дата свадьбы" name="wedding_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group-grid clearfix">
                        <div class="form-group group-half">
                            <input type="text" class="form-control form-control-rect-simple phone-mask" placeholder="+ 7 909 6" name="phone" autocomplete="off">
                        </div>
                        <div class="form-group group-half">
                            <input type="text" class="form-control form-control-rect-simple" placeholder="Ваш  e-mail" name="email" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control form-control-rect-simple" placeholder="Ваши пожелания" name="wishes" autocomplete="off"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn-white-wide hover-red pull-right popup-send">отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
*/?>