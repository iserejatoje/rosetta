<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<table class="form">
		<tr>
			<td class="header-column">Ай-ай, ошибка</td>
			<td class="data-column">
				<span class="error"><?=$err?></span><br/>
			</td>
		</tr>
	</table>
<? } else {

?>

<style>
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	h1 { font-size: 1.2em; margin: .6em 0; }

	.acl-field {
		padding-top: 4px;
		padding-bottom: 4px;
		border-bottom: dotted 1px #898989;
	}
</style>

<script>
	$(function() {
	});

</script>



<form name="article_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="SeoID" value="<?=$vars['form']['SeoID']?>" />

	<table class="form">
		<tr>
			<td class="header-column">SEO Title</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoTitle" value="<?=UString::ChangeQuotes($vars['form']['SeoTitle'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Keywords</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoKeywords" value="<?=UString::ChangeQuotes($vars['form']['SeoKeywords'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Description</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoDescription" value="<?=UString::ChangeQuotes($vars['form']['SeoDescription'])?>"><br/>
			</td>
		</tr>



	<tr>
			<td class="header-column important">SEO Текст для продвижения</td>
			<td class="data-column">

				<textarea class="ckeditor" name="SeoText"><?=$vars['form']['SeoText']?></textarea><br/>
			</td>
		</tr>
	<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td colspan="2" align="center">
				<br/>
				<input type="submit" value="Сохранить"/>
			</td>
		</tr>
	</table>
</form>
<br/><br/>
<? } ?>