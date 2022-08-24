<html>
<head>
	<title>{$TITLE->Title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

	<link rel="stylesheet" type="text/css" href="/_styles/design/200608_title/common/styles.css" />

{if count($TITLE->Scripts)>0}
	{foreach from=$TITLE->Scripts item=l}
	<script type="{if $l.type}{$l.type}{else}{/if}" language="javascript" src="{$l.src}"></script>
	{/foreach}
{/if}
{if count($TITLE->Styles)>0}
	{foreach from=$TITLE->Styles item=l}
	<link rel="stylesheet" type="text/css" href="{$l.src}" />
	{/foreach}
{/if}
</head>
<body>