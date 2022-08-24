<script type="text/javascript" src="/_scripts/themes/frameworks/jquery/treeview/single_select.0.1b.js "></script>
<script> 
	var p = new TV_SingleSelect('<?=$vars['this']->GetUrl();?>',
	{
		max_elements: 0,
		single: true,
		action: '<?=$vars['this']->GetAction();?>',
		hold: {
			list: '<?=$vars['this']->GetID()?>_id'
		}
	});
	p.get_sections(0); 
</script>