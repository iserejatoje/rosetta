<? if (!empty($vars['records']) || App::$User->ID == $vars['UserID']): ?>
<div class="block_anon" style="padding-bottom: 8px;">
	<div class="title title_rt">
		<div class="left"><a href="/user/<?=$vars['UserID']?>/blogs/">Записи в блоге <?=($vars['count']>0?"(".$vars['count'].")":"")?></a></div>
	</div>
	<div class="content">
		<? if (!empty($vars['records'])): ?>
		<ul class="list">
			<? foreach($vars['records'] as $record): ?>
			<li>
				<a href="/user/<?=$vars['UserID']?>/blogs/post/<?=$record->ID?>.php"><b><?=UString::Truncate($record->Title, 45)?></b></a><br/>
				<div style="padding-left: 10px;">
					<?=Datetime_my::SimplyDate($record->Created)?>:
					<?=UString::Truncate(strip_tags($record->TextHTML), 30)?>
					<a href="/user/<?=$vars['UserID']?>/blogs/post/<?=$record->ID?>.php">читать</a>
				</div>
			</li>
			<? endforeach; ?>
		</ul>
		<? endif; ?>
	</div>
	<div class="actions_panel">
		<div class="actions_rs">
			<a href="/blog/new.php">Новые записи</a>
		</div>
		<? if (App::$User->ID == $vars['UserID']): ?>
		<div class="actions_rs">
			<a href="/user/<?=$vars['UserID']?>/blogs/add.php">Написать в блог</a>&nbsp;&nbsp;&nbsp;
		</div>
		<? endif; ?>
	</div>

	<br clear="both"/>
</div>
<? endif; ?>