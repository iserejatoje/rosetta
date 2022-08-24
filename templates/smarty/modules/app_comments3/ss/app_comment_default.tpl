{$page.page}

{$page.form}

{if $page.showCommentFormAuthOnly === true && !$USER->IsAuth()}
<div class="js-comment">
	<div class="js-comment-info">
		Для того чтобы оставить Комментарий необходимо <a href="/passport/register.php?url={php} echo App::$Request->Server['REQUEST_URI']->Url();{/php}">Зарегистрироваться</a> 
		или <a href="/passport/login.php?url={php} echo App::$Request->Server['REQUEST_URI']->Url(){/php}">Авторизоваться</a>
	</div>
</div>
{/if}