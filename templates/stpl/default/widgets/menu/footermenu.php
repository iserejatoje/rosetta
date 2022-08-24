<div class="footer-col xs-hidden">
    <div class="footer-col-title">
        Карта сайта:
    </div>

    <? if(is_array($vars['groups'][1]) && count($vars['groups'][1]) > 0) { ?>
        <ul class="footer-links">
            <? foreach($vars['groups'][1] as $item) { ?>
                <li><a href="<?=$item->link?>"><?=$item->name?></a></li> 
            <? } ?>
        </ul>
    <? } ?>

    <? if(is_array($vars['groups'][2]) && count($vars['groups'][2]) > 0) { ?>
        <ul class="footer-links">
            <? foreach($vars['groups'][2] as $item) { ?>
                <li><a href="<?=$item->link?>"><?=$item->name?></a></li>
            <? } ?>
        </ul>
    <? } ?>
</div>

<div class="footer-col xs-hidden">

    <div class="footer-col-title">
        &nbsp;
    </div>

    <? if(is_array($vars['groups'][3]) && count($vars['groups'][3]) > 0) { ?>
        <ul class="footer-links">
            <? foreach($vars['groups'][3] as $item) { ?>
                <li><a href="<?=$item->link?>"><?=$item->name?></a></li>
            <? } ?>
        </ul>
    <? } ?>

    <? if(is_array($vars['groups'][4]) && count($vars['groups'][4]) > 0) { ?>
        <ul class="footer-links">
            <? foreach($vars['groups'][4] as $item) { ?>
                <li><a href="<?=$item->link?>"><?=$item->name?></a></li>
            <? } ?>
        </ul>
    <? } ?>

    <ul class="footer-links">
        <li><a href="/reward">Наше мастерство</a></li>
    </ul>
</div>