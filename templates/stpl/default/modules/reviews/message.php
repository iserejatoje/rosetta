<?
	global $OBJECTS;

	if ( ($err = UserError::GetErrorByIndex('global')) != '' ) {?>
		<div class="notification-block"><b>
		<?=$err?>
		</b></div>
	<? } ?>

	<br/><br/><br/><br/><br/><br/>
	<a href="/reviews/" class="reviews-list">Вернуться к списку отзывов</a>