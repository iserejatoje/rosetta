<?
	$types = $vars['types'];
	$product = $vars['product'];
	$default_type = $product->default_type;
?>
<?/* <div class="card-info-components">
    <div class="card-info-components-title">состав букета:</div>
    <div class="card-info-components-text">
        <?=$product->CompositionText?>
    </div>
</div> */?>

<div class="card-info-sizes clearfix" data-control="radiolist">
    <input type="hidden" name="size" value="<?=$default_type->id?>">
    <? foreach($types as $type) { ?>
    	<div class="card-info-size <?=CatalogMgr::$b_size[$type->name]?><?if($type->id == $default_type->id){?> is-active<?}?>" data-control="radiobutton" data-id="<?=$type->id?>">
            <div class="card-info-size-label"><?=$type->name?></div>
        </div>
    <? } ?>
</div>