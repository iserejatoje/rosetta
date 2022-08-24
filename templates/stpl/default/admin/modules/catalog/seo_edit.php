<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
	.form-control {
		display: inline-block;
	}
</style>

<? if (($err = UserError::GetErrorByIndex('global')) != '' ) 
{?>
	<h3><?=$err?></h3><br/>
<? } 
else 
{ ?>

<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="type_id" value="<?=$vars['form']['TypeID']?>" />

	<table class="form table table-sriped">
		<tr>
			<td class="header-column">SEO Текст</td>
			<td width="100%" colspan="2">
				<textarea name="SeoText" class="mceEditor input_100" style="height:400px; width: 100%;"><?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoText']))?></textarea>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Title</td>
			<td class="data-column">
				<input class="form-control" name="SeoTitle" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoTitle']))?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Description</td>
			<td class="data-column">
				<input class="form-control" name="SeoDescription" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoDescription']))?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Keywords</td>
			<td class="data-column">
				<input class="form-control" name="SeoKeywords" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoKeywords']))?>"><br/>
			</td>
		</tr>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>
	</table>
</form>

<? } ?>