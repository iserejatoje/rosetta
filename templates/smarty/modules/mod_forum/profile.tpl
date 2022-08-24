<table width="500" align="center" cellpadding="4" cellspacing="2">
<tr><td width="150">{if isset($info.avatar)}<img src="{$info.avatar}">{/if}</td><td width="350">&nbsp;</td></tr>
<tr><td>{foreach from=$info.message_stars item=ls}<img src="/_img/modules/forum/rating/chel.gif">{/foreach}<br><b>{$info.message_rating}</b></td><td>&nbsp;</td></tr>
<tr><td><b>&nbsp;</b></td><td>&nbsp;</td></tr>
<tr class="frow_second"><td align="right" class="fheader_text">Кол-во сообщений</td><td>{$info.messages}</td></tr>
<tr><td align="right" class="fheader_text">ФИО</td><td>{$info.fio}</td></tr>
<tr class="frow_second"><td align="right" class="fheader_text">E-Mail</td><td><a href="mailto:{$info.emailshow}">{$info.emailshow}</a></td></tr>
<tr><td align="right" class="fheader_text">ICQ</td><td>{$info.icq}</td></tr>
<tr class="frow_second"><td align="right" class="fheader_text">Сайт</td><td>{$info.url}</td></tr>
<tr><td align="right" class="fheader_text">Место проживания</td><td>{$info.address}</td></tr>
<tr class="frow_second"><td align="right" class="fheader_text">Подпись</td><td>{$info.signature}</td></tr>
{*<tr><td align="right" class="fheader_text">Рейтинг</td><td>{$info.user_rating}</td></tr>*}
<tr><td align="right" class="fheader_text">Нарушения</td><td>{$info.offence}</td></tr>
</table>