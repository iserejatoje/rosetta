{$page.mail_uncrypt_script}

{capture name="rname"}ВАКАНСИИ - {$page.firm.form} {$page.firm.fname|escape}{/capture}

{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
<br /><br />
{$page.details}
<div style="clear:both;">
{$page.vacancy_list}

<br/><br/><br/>