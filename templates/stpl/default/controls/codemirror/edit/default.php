<textarea id="<?=$vars['this']->GetID()?>" name="<?=$vars['this']->GetID()?>_text" style="<?=$vars['this']->GetStyle()?>" class="ctrl_<?=$vars['this']->GetName()?>">
<?=htmlspecialchars($vars['this']->GetTitle());?>
</textarea>
<script type="text/javascript"> 
  var editor = CodeMirror.fromTextArea('<?=$vars['this']->GetID()?>', {
    height: "<?=$vars['this']->GetHeight();?>",
    parserfile: "parsexml.js",
    stylesheet: ["/resources/styles/themes/editors/codemirror/xmlcolors.css", "/resources/styles/themes/editors/codemirror/default.css"],
    path: "/resources/scripts/themes/editors/codemirror/",
    continuousScanning: 500,
    lineNumbers: true,
    textWrapping: false,
	readOnly: <?=$vars['this']->GetReadOnly()?'true':'false';?>
  });
</script>