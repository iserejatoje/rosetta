<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
{php}
	App::$Title->AddStyle('/resources/styles/design/takemix/styles.css');
	App::$Title->Add('link', array('rel' => 'icon', 'href' => '/resources/img/design/takemix/favicon.png', 'type' => 'image/x-icon'));
	{/php}
{$TITLE->Head}
</head>
<body>
<div style="padding: 10px;">
{foreach from=$BLOCKS.main item=block}{$block}<br/>{/foreach}

</body>
</html>