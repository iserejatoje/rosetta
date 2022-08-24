<?
	LibFactory::GetStatic('datetime_my');
	LibFactory::GetStatic('ustring');
?>
<span style="color:#f8592b;font-size:18px;font-weight:bold;">Новость <span style="color:#1eadec">дня</span></span><br/><br/>
<? foreach($vars['list'] as $item) { ?>	
	<small><?=(date('d', $item['date'])." ".Datetime_my::$month2[date('n', $item['date'])]." ".date('Y', $item['date']))?></small><br/>

	<? if ($item['thumb'] !== null) { ?>
	<img src="<?=$item['thumb']['File']?>" width="<?=$item['thumb']['Width']?>" height="<?=$item['thumb']['Height']?>" alt="<?=$item['title']?>" style="float:left;padding: 8px;"/>
	<? } ?>
	<?=UString::Truncate($item['announce'], 380)?><br clear="both"/>
	<div style="text-align:right;padding-right: 7px;"><a href="<?=$item['url']['absolute']?>" class="cyan-link">подробнее</a></div>
<? } ?>