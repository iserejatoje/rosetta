
{capture name="rname"}Задать вопрос компании {$page.firm.type} {$page.firm.fname}{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>

{$page.list_question}
{$page.form_question}


