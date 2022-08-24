<a href="tel:<?=$vars['phone']?>" class="phone with-border" data-ya-target="click_phone">
    <img src="/resources/img/design/rosetta/phone-mobile.png" class="img-responsive phone-img xs-hidden" alt="rosetta">
    <span class="xs-visible"><?=$vars['phone']?></span>
</a>

<style>
    @media screen and (max-width: 768px) {
        header .phone-img {
            display: none !important;
        }
        header .phone {
            width: auto !important;
        }
    }
</style>