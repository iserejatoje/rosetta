<script type="text/javascript" language="javascript" src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;lang=ru_RU" charset="utf-8"></script>

<div class="shadow-sep"></div>

<div class="container">
    <h1 class="page-title">КОНТАКТНАЯ ИНФОРМАЦИЯ</h1>

    <div class="page-contacts">
        <div class="contacts-grid">
            <div class="tabs-container">
                <div class="incline-tabs">
                    <?
                    $i = 0;
                    foreach(CitiesMgr::$TYPES as $k => $type) {
                        ++$i;
                        ?>
                        <div class="incline-tabs-tab tab-item<?if($i== 1){?> is-active<?}?>" data-content="<?=$type['class']?>">
                            <div class="incline-tabs-tab-text">
                                <?=$type['name']?>
                            </div>
                            <?/*
                            <div class="rounded-arrow">
                                <div class="single-arrow"></div>
                            </div>
                            */?>
                            <div class="incline-tabs-sep"></div>
                        </div>
                    <? } ?>
                </div>

                <?

                foreach(CitiesMgr::$TYPES as $k => $type) {

                ?>
                    <div class="tab-content tab-<?=$type['class']?><?if($k==CitiesMgr::CT_WORKSHOP){?> is-visible<?}?>">
                        <? $j = 0;
                            foreach($vars['types'][$k] as $store) {
                            $photos = $store->photos;
                            ++$j;
                        ?>
                            <div class="incline-tabs-content-item <?if($j==1 && $k==CitiesMgr::CT_WHOLESALE && count($vars['types'][$k])==1){?> is-toggled<?}?>" data-control="toggle-container">
                                <div class="incline-tabs-content-item-button" data-control="toggle">
                                    <div class="incline-tabs-content-item-button-text">
                                        <?=$store->Address?>
                                    </div>
                                    <div class="single-arrow"></div>
                                </div>
                                <div class="incline-tabs-content-item-more">
                                    <div class="incline-tabs-content-item-more-body clearfix">
                                        <div class="incline-tabs-content-item-desc">
                                            <div class="incline-tabs-content-item-title">
                                                <?=$store->Address?>
                                                <div class="close-btn" data-control="toggle"></div>
                                            </div>
                                            <div class="incline-tabs-content-item-attr-wrapper">
                                                <div class="incline-tabs-content-item-attr item-attr-worktime">
                                                    <?=$store->Workmode?>
                                                </div>
                                                <? /*
                                                <div class="incline-tabs-content-item-attr-additional">без обеда и выходных</div>
                                                */ ?>
                                            </div>
                                            <div class="incline-tabs-content-item-attr-wrapper">
                                                <div class="incline-tabs-content-item-attr item-attr-phone">
                                                    <?=$store->PhoneCode?> <?=$store->Phone?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="map-container" data-lon="<?=$store->Longitude?>" data-lat="<?=$store->Latitude?>">

                                        </div>
                                    </div>

                                    <? if(is_array($photos) && count($photos) > 0) { ?>
                                        <div class="photos-grid" data-control="toggle-container">
                                            <div class="photos-grid-header clearfix">
                                                <div class="photos-grid-header-img clerfix">
                                                    <?
                                                    $f = 0;
                                                    foreach($photos as $photo) {
                                                        ++$f;
                                                        if($f > 5)
                                                            break;
                                                        ?>
                                                        <a href="<?=$photo->Photo['f']?>" data-lightbox="gallery-small-<?=$store->ID?>" class="photos-grid-header-img-item">
                                                            <img src="<?=$photo->PhotoSmall['f']?>" alt="<?=UString::ChangeQuotes($photo->name)?>" class="img-responsive">
                                                        </a>
                                                    <? } ?>
                                                </div>
                                                <div class="photos-grid-header-button" data-control="toggle">
                                                    <div class="photos-grid-header-button-label">
                                                        <?=count($photos)?> фото
                                                        <div class="rounded-arrow">
                                                            <div class="single-arrow"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="photos-grid-body clearfix">
                                                <? foreach($photos as $photo) { ?>
                                                    <a href="<?=$photo->Photo['f']?>" data-lightbox="gallery" class="photos-grid-body-item">
                                                        <img src="<?=$photo->PhotoBig['f']?>" alt="<?=UString::ChangeQuotes($photo->name)?>" class="img-responsive">
                                                    </a>
                                                <? } ?>
                                            </div>
                                        </div>
                                    <? } ?>

                                </div>
                            </div>
                        <? } ?>

                    </div>
                <? } ?>


            </div>


        </div>
    </div>
</div>