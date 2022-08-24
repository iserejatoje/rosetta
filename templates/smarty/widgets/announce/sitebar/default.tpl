{if in_array($CURRENT_ENV.regid,array(2,16,34,59,61,63,72,74))}
{if $USER->ID == 1}
{literal}
<style>
.sitebar .fixed iframe.container
{
    display:block;
    position: absolute;
    z-index: -1;
    filter: mask();
    width: 100%;
    height: 30px;
} 
</style>
{/literal}
{/if}
<noindex>
<div class="sitebar">
<div class="fixed">
{if $USER->ID == 1}
<!--[if lte IE 6.5]><iframe class="container"></iframe><![endif]-->
{/if}
	<table cellspacing="0" cellpadding="2" class="container" height="30">
		<tr valign="middle">
			{if !$res.isTitle || $smarty.get.theme==123}
				
				<td align="center" width="85">
					<a target="_blank" rel="nofollow" href="{$res.titleUrl}?frompanel=1"><img border="0" src="/_img/design/200608_title/logo_title/logo.{$CURRENT_ENV.regid}.gif" /></a>
				</td>
				{if $CURRENT_ENV.regid == 74}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://autochel.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://autochel.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://74.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://74.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://domchel.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://domchel.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://mychel.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://mychel.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td> 
{*				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.kurss.src='/_img/widgets/sitebar/kurs.gif'" onmouseover="document.kurss.src='/_img/widgets/sitebar/kurs1.gif'" href="/service/go/?url={'http://chelfin.ru/?frompanel=1'|escape:'url'}"><img height="23" border="0" width="21" name="kurss" src="/_img/widgets/sitebar/kurs.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.kurss.src='/_img/widgets/sitebar/kurs.gif'" onmouseover="document.kurss.src='/_img/widgets/sitebar/kurs1.gif'" class="td2" href="/service/go/?url={'http://chelfin.ru/?frompanel=1'|escape:'url'}">Кредиты</a></td>
						</tr>
					</table>
				</td>*}
				{elseif $CURRENT_ENV.regid == 72}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://72avto.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://72avto.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://72.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://72.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://72doma.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://72doma.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://72afisha.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://72afisha.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td>	
				{elseif $CURRENT_ENV.regid == 59}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://avto59.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://avto59.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://59.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://59.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://kvartira59.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://kvartira59.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://afisha59.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://afisha59.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td>			
				{elseif $CURRENT_ENV.regid == 2}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://102km.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://102km.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://ufa1.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://ufa1.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://102metra.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://102metra.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://102vechera.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://102vechera.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td>
				{elseif $CURRENT_ENV.regid == 16}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://116auto.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://116auto.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://116.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://116.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://116metrov.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://116metrov.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://116vecherov.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://116vecherov.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td>			
				{elseif $CURRENT_ENV.regid == 61}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://161auto.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://161auto.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://161.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://161.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://161metr.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://161metr.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://161vecher.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://161vecher.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td>			
				{elseif $CURRENT_ENV.regid == 34}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://34auto.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://34auto.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://v1.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://v1.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://34metra.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://34metra.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://34vechera.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://34vechera.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td>			
				{elseif $CURRENT_ENV.regid == 63}
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" href="/service/go/?url={'http://doroga63.ru/car/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="autoo" src="/_img/widgets/sitebar/auto.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.autoo.src='/_img/widgets/sitebar/auto.gif'" onmouseover="document.autoo.src='/_img/widgets/sitebar/auto1.gif'" class="td2" href="/service/go/?url={'http://doroga63.ru/car/?frompanel=1'|escape:'url'}">Авто</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" href="/service/go/?url={'http://63.ru/job/?frompanel=1'|escape:'url'}"><img height="22" border="0" width="23" name="jobb" src="/_img/widgets/sitebar/job.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.jobb.src='/_img/widgets/sitebar/job.gif'" onmouseover="document.jobb.src='/_img/widgets/sitebar/job1.gif'" class="td2" href="/service/go/?url={'http://63.ru/job/?frompanel=1'|escape:'url'}">Работа</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" href="/service/go/?url={'http://dom63.ru/realty/?frompanel=1'|escape:'url'}"><img height="24" border="0" width="23" name="nedvv" src="/_img/widgets/sitebar/nedv.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.nedvv.src='/_img/widgets/sitebar/nedv.gif'" onmouseover="document.nedvv.src='/_img/widgets/sitebar/nedv1.gif'" class="td2" href="/service/go/?url={'http://dom63.ru/realty/?frompanel=1'|escape:'url'}">Недвижимость</a></td>
						</tr>
					</table>
				</td>
				<td align="center" class="themes">
					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="25"><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" href="/service/go/?url={'http://freetime63.ru/afisha/?frompanel=1'|escape:'url'}"><img height="20" border="0" width="24" name="afishaa" src="/_img/widgets/sitebar/afisha.gif"/></a></td>
							<td><a target="_blank" rel="nofollow" onmouseout="document.afishaa.src='/_img/widgets/sitebar/afisha.gif'" onmouseover="document.afishaa.src='/_img/widgets/sitebar/afisha1.gif'" class="td2" href="/service/go/?url={'http://freetime63.ru/afisha/?frompanel=1'|escape:'url'}">Афиша</a></td>
						</tr>
					</table>
				</td>	
				{/if}
				<td align="right" nowrap="nowrap">
					<a target="_blank" rel="nofollow" class="imp" href="/service/go/?url={"`$res.titleUrl`/weather/?frompanel=1"|escape:'url'}">Погода</a>
					{if $res.Weather.T !== null}<span class="bTXT">{if $res.Weather.T > 0}+{/if}{$res.Weather.T}</span>{/if}
				</td>
				<td>{if $res.Weather.T !== null}<img height="22" width="22" class="png" src="/_img/modules/weather/ico/small/{$res.Weather.HourType}/{$res.Weather.Precip}.png" alt="{$res.Weather.PrecipText}" title="{$res.Weather.PrecipText}"/>{/if}</td>
				<td align="center" nowrap="nowrap">
					{if $res.mainNews}<span class="hot">Главное:</span> <a target="_blank" rel="nofollow" href="/service/go/?url={"`$res.mainNews->url.absolute`?frompanel=1"|escape:'url'}"><b>{$res.mainNews->Title|truncate:35}</b></a>{/if}
				</td>

				{else}
				<td width="15"></td>
				<td nowrap="nowrap">{if $res.mainNews}<span class="hot">Главное:</span> <a target="_blank" rel="nofollow" href="/service/go/?url={"`$res.mainNews->url.absolute`?frompanel=1"|escape:'url'}"><b>{$res.mainNews->Title|truncate:70}</b></a>{/if}</td>
				<td align="right" width="100" nowrap="nowrap">
					<a target="_blank" rel="nofollow" class="imp" href="/service/go/?url={"`$res.titleUrl`/weather/?frompanel=1"|escape:'url'}">Погода</a>
					{if $res.Weather.T !== null}<span class="bTXT">{if $res.Weather.T > 0}+{/if}{$res.Weather.T}</span>{/if}
				</td>
				<td width="25px">{if $res.Weather.T !== null}<img height="22" width="22" class="png" src="/_img/modules/weather/ico/small/{$res.Weather.HourType}/{$res.Weather.Precip}.png" alt="{$res.Weather.PrecipText}" title="{$res.Weather.PrecipText}"/>{/if}</td>
				<td align="right" width="230">
					{*include file="`$config.templates.words`" word="`$res.word`" query="`$res.query`" query_field="query"*}
					<form action="/search/search.php" method="get" target="_blank"/>
					<input type="hidden" value="rlv" name="sortby" />
					<input type="hidden" value="3" name="where" />
					<input type="hidden" value="0" name="wordid" />
					<table cellspacing="0" cellpadding="0" width="210">
						<tr>
							<td><input type="text" style="width: 100%;" name="query" id="query_sitebar"/></td>
							<td align="right" width="65px"><input type="submit" value="Найти"/></td>
						</tr>
					</table>
					</form>
				</td>
			
			{/if}
			
			<td align="right" width="90">
				{literal}
				<script type="text/javascript" language="javascript">
					<!--

						 $(document).ready(function() {
							var sb_timer = 0;
							var hide = function() {
								clearTimeout(sb_timer);
								$('#sitebar_menu').slideUp(200);
							}

							$('#sitebar_hmenu').bind('click', function() {
								clearTimeout(sb_timer);
								$('#sitebar_menu').slideToggle(200);
								
								$(document).bind('click.sitebar', function() {
									hide();
									$(document).unbind('click.sitebar');
								});
								
								return false;
							})
							.bind('mouseover', function() {
								clearTimeout(sb_timer);
							})
							.bind('mouseout', function() {
								sb_timer = setTimeout(hide, 2000);
							});

							$('#sitebar_menu').bind('mouseover', function() {
								clearTimeout(sb_timer);
							})
							.bind('mouseout', function() {
								sb_timer = setTimeout(hide, 2000);
							});
							
							var word = '{/literal}{$res.word.Word}{literal}';
							if ($("#query_sitebar").size()) {
								var form = $($("#query_sitebar").attr('form'));
								var el = $("#query_sitebar");
								
								if (!word)
									el.focus();
								else {
									el.css('color', '#CCCCCC').val(word);
									var change = function() {
										if (word && el.attr('_clear') !== true)
											el.val('');

										el.attr('_clear', true);
										el.css('color', '');
									}

									el.one(($.browser.opera ? "keypress" : "keydown")+' click', change);
									//el.one('click', change);
									form.one('submit', function() {
										if (word && el.attr('_clear') !== true)
											this.wordid.value = {/literal}{if $res.word.WordID > 0}{$res.word.WordID}{else}0{/if}{literal};
									});
								}
							}
						});

					//-->
				</script>
				{/literal}
				<div class="hot">
					<a target="_blank" rel="nofollow" id="sitebar_hmenu" href="#">Все проекты</a>
					<div class="menu" id="sitebar_menu"><div>
						<div class="top"></div>
					{if $CURRENT_ENV.regid == 74}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">ТВ</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://chelyabinsk.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="74.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://chel.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Бизнес</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://autochel.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://autochel.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://vipautochel.ru/?frompanel=1'|escape:'url'}" class="panel-td2">VIP-автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://chelfin.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://domchel.ru/realty/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://2074.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Hi-tech</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://mychel.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://cheldoctor.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://cheldiplom.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Образование</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://mgorsk.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Магнитогорск</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://chelfin.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/map/?frompanel=1'|escape:'url'}" class="panel-td2">Карта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://mychel.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://mychel.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/radio/?frompanel=1'|escape:'url'}" class="panel-td2">Радио</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://74.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
					{elseif $CURRENT_ENV.regid == 72}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">Видео</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/newsline/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="72.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72avto.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72avto.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72dengi.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72doma.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72afisha.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72doctor.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72diploma.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Образование</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://86.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Ханты-Мансийск АО</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://89.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Ямало-Ненецкий АО</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72dengi.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72afisha.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72afisha.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://72.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
						{elseif $CURRENT_ENV.regid == 59}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">Видео</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/newsline/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="59.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://avto59.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://avto59.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://dengi59.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://kvartira59.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://afisha59.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://doctor59.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://dengi59.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://afisha59.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://afisha59.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://59.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
						{elseif $CURRENT_ENV.regid == 2}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">Видео</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/newsline/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="ufa1.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102km.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102km.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102banka.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102metra.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102vechera.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102doctora.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102diploma.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Образование</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102banka.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102vechera.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://102vechera.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://ufa1.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
						{elseif $CURRENT_ENV.regid == 16}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">Видео</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/newsline/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="116.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116auto.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116auto.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116dengi.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116metrov.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116vecherov.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116doctor.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116dengi.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116vecherov.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116vecherov.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://116.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
						{elseif $CURRENT_ENV.regid == 61}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">Видео</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/newsline/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="161.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161auto.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161auto.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161bank.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://vip.161auto.ru/?frompanel=1'|escape:'url'}" class="panel-td2">VIP-автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161metr.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161vecher.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161doctor.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161bank.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161vecher.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161vecher.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://161.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
						{elseif $CURRENT_ENV.regid == 34}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">Видео</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/newsline/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="v1.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34auto.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34auto.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34banka.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34metra.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34vechera.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34doctora.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34banka.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34vechera.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://34vechera.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://v1.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
						{elseif $CURRENT_ENV.regid == 63}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/video/?frompanel=1'|escape:'url'}" class="panel-td2">Видео</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/newsline/?frompanel=1'|escape:'url'}" class="panel-td2">Новости</a></div>
						{if $CURRENT_ENV.site.domain=="63.ru"}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/job/?frompanel=1'|escape:'url'}" class="panel-td2">Работа</a></div>
						{/if}
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://doroga63.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Автомобили</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://doroga63.ru/poputchik/?frompanel=1'|escape:'url'}" class="panel-td2">Попутчик</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://dengi63.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Финансы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://dom63.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Недвижимость</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/baraholka/?frompanel=1'|escape:'url'}" class="panel-td2">Барахолка</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/buronahodok/?frompanel=1'|escape:'url'}" class="panel-td2">Бюро находок</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://freetime63.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Афиша</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://doctor63.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Медицина</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://dengi63.ru/exchange/?frompanel=1'|escape:'url'}" class="panel-td2">Курсы валют</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/forum/active.php?frompanel=1'|escape:'url'}" class="panel-td2">Форумы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/mail/?frompanel=1'|escape:'url'}" class="panel-td2">Почта</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/blog/?frompanel=1'|escape:'url'}" class="panel-td2">Дневники</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://freetime63.ru/horoscope/?frompanel=1'|escape:'url'}" class="panel-td2">Гороскопы</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://freetime63.ru/love/?frompanel=1'|escape:'url'}" class="panel-td2">Знакомства</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://tolyatty.ru/?frompanel=1'|escape:'url'}" class="panel-td2">Тольятти</a></div>
						<div class="item"><a target="_blank" rel="nofollow" href="/service/go/?url={'http://63.ru/schedule/?frompanel=1'|escape:'url'}" class="panel-td2">Расписания</a></div>
						{/if}</div>
						<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
					</div>
				</div>
			</td>
			<td width="15"></td>
		</tr>
	</table>
</div></div></noindex>
{/if}
