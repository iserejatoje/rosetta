<? if(is_array($vars['list']) && count($vars['list']) > 0) { ?>
    <? foreach($vars['list'] as $group) {
        $photos = $group->photos;
        $count = is_array($photos) ? count($photos) : 0;
        $icnt = $count >= 4 ? 4 : $count;
        ?>
        <div class="photo-block">
            <div class="photo-block-head">
                <div class="photo-block-img-name">
                    <div class="photo-block-img-text">
                        <?=$group->name?>
                    </div>
                </div>
                <div class="photo-block-img">
                    <img src="<?=$group->thumb['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($group->name)?>">
                </div>

                <div class="photo-block-info">
                    <div class="close-btn" data-control="gallery-close"></div>
                    <div class="photo-block-info-body">
                        <div class="photo-block-info-title">
                            <?=$group->name?>
                        </div>
                        <div class="photo-block-info-count"><?=count($photos)?> фото</div>
                        <div class="photo-block-info-desc">
                            <?=$group->text?>
                        </div>
                    </div>
                </div>

                <? if($count > 0) { ?>
                    <div class="photo-block-gallery-preview clearfix">
                        <div class="photo-block-gallery-preview-thumbs clearfix">
                            <? for($i = 0; $i < $icnt; $i++) { ?>
                                <a href="<?=$photos[$i]->photo['f']?>" data-lightbox="gallery-small-<?=$group->id?>" class="photo-block-gallery-preview-item">
                                    <img src="<?=$photos[$i]->photosmall['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($photos[$i]->name)?>">
                                </a>
                            <? } ?>
                        </div>

                        <? if($count > 4) { ?>
                            <div class="photo-block-gallery-preview-btn" data-control="gallery-open">
                                еще <?=($count-$icnt)?> фото
                                <div class="rounded-arrow">
                                    <div class="single-arrow"></div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                <? } ?>
            </div>

            <? if($count > 4) { ?>
                <div class="photo-block-gallery clearfix">
                    <? foreach($photos as $photo) { ?>
                        <a href="<?=$photo->photo['f']?>" data-lightbox="gallery" class="photo-block-gallery-img">
                            <img src="<?=$photo->photobig['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($photo->name)?>">
                        </a>
                    <? } ?>
                    <div class="photo-block-gallery-control" data-control="gallery-close">
                        <div class="photo-block-gallery-control-btn">
                            закрыть галерею
                            <div class="close-btn"></div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    <? } ?>
<? } else { ?>
    <div style="width: 100%; text-align:center;margin: 40px 0;font-size:24px;">Ничего не найдено</div>
<? } ?>