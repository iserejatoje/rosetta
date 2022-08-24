<? if($vars['this']->GetMultiline()): ?>
<textarea name="<?=$vars['this']->GetID()?>_text" style="<?=$vars['this']->GetStyle()?>" class="ctrl_<?=$vars['this']->GetName()?>">
<?=htmlspecialchars($vars['this']->GetTitle());?>
</textarea>
<? else: ?>
<input class="ctrl_<?=$vars['this']->GetName()?>" type="text" name="<?=$vars['this']->GetID()?>_text" style="<?=$vars['this']->GetStyle()?>" value="<?=$vars['this']->GetTitle();?>"<?if($vars['this']->GetLimit() > 0): ?> maxlength="<?=$vars['this']->GetLimit();?>"<?endif;?>>
<? endif; ?>