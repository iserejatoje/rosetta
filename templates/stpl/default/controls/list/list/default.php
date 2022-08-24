<? if($vars['private']['pager'] !== null) :?><div align="right"><?=$vars['private']['pager']->Render()?></div><? endif; ?>
<table width="100%">
<? if($vars['private']['header'] !== null) :?><?=$vars['private']['header']->Render()?><? endif; ?>
<? $count = 0;foreach($vars['private']['items'] as $index => $item) { ?>
<? $vars['this']->Display(array('this' => $vars['this'], 'private' => array('columns' => $vars['private']['columns'], 'item' => $item, 'index' => $index, 'count' => $count)), 'row') ?>
<? $count++; } // foreach($vars['private']['items'] as $index => $item) ?>
</table>