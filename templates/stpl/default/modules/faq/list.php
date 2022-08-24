<? foreach($vars['questions'] as $item) { ?> 
    <div class="qa-item" data-control="toggle-container">
        <div class="qa-item-body">
            <div class="qa-item-unfold-button" data-control="toggle">
                <div class="qa-item-unfold-label"><?=$item->Question?></div>
                <div class="rounded-arrow">
                    <div class="single-arrow"></div>
                </div>
                <div class="close-btn"></div>
            </div>
            <div class="qa-item-unfold-text">
                <?=$item->Answer?>
            </div>
        </div>
    </div>
<? } ?>
