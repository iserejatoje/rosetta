<?php App::$Title->AddScript('/resources/scripts/design/takemix/slider_ext.js'); ?>
<ul>
    <li id="drunk-viking" style="position: relative;">
        <img src="/resources/img/design/takemix/banners/3.jpg" class="img-responsive" alt="banner">
        <div class="animation" style="position:absolute; left: 0; top: 0; width: 100%; height: 100%;">

        </div>
    </li>
    <? foreach($vars['banners'] as $item) { ?>
    <li>
        <? if($item->Url) { ?>
            <a href="<?=$item->Url?>"><img src="<?=$item->file['f']?>" class="img-responsive" alt="banner"></a>
        <? } else { ?>
            <img src="<?=$item->file['f']?>" class="img-responsive" alt="banner">
        <? } ?>
    </li>
    <? } ?>
</ul>
<div class="control jcarousel-control-prev">
    <svg id="control-left" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <defs></defs>
    </svg>
</div>
<div class="control jcarousel-control-next">
    <svg id="control-right" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <defs></defs>
    </svg>
</div>
<div class="jcarousel-pagination"></div>