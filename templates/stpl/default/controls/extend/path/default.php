<? foreach($vars['private']['items'] as $i) { ?>
<? if(!empty($i['url'])): ?>
<a href="<?=$i['url']?>"><?=$i['title']?></a> / 
<? else: ?>
<?=$i['title']?>
<? endif; ?>
<? } ?>