<div class="row">

    <div class="row">
        <div class="col n4 md-n12">
            <div class="page-title">
                <div class="page-title-label">
                    Вакансии
                    <div class="stroke-line"></div>
                    <div class="stroke-line"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="vacancy-grid row">
        <div class="col n12">

            <? foreach($vars['list'] as $item) { ?>
                <div class="vacancy-item block-orange">
                    <div class="row">
                        <div class="col-orange">
                            <div class="orange-rect">

                                <? foreach(explode(",", $item->Position) as $position) { ?>
                                    <div class="sep-block"><?=str_replace(" ", "<br>", trim($position))?></div>
                                <? } ?>
                            </div>
                        </div>
                        <div class="col-white">
                            <?=$item->Text?>
                        </div>
                    </div>
                </div>
            <? } ?>

        </div>
    </div>

</div>