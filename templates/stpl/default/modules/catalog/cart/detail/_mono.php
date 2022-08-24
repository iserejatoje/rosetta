<?
    $composition = $vars['composition'];
    $item = null;
    foreach($composition as $element) {
        if($element['IsEditable']) {
            $item = $element;
            break;
        }
    }

?>

<div class="card-info-count with-wave">
    <div class="card-info-count-label">Укажите количество цветов:</div>
    <div class="count-switcher">
        <input type="text" name="flower_count" value="<?=intval($item['Count'])?>" readonly data-min="<?=$vars['min']?>" data-inc="<?=$vars['step']?>" data-max="51" autocomplete="off">
        <div class="count-switcher-btn count-switcher-down">
            <div class="count-switcher-btn-sign"></div>
        </div>
        <div class="count-switcher-btn count-switcher-up">
            <div class="count-switcher-btn-sign"></div>
        </div>
    </div>
</div>
