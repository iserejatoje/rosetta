<script type="text/javascript">
    $(document).ready(function(){
        tinymce.init({
            selector: "textarea",
            language: "ru",
            theme: "modern",
            width: 1000,
            height: 400,
            plugins: [
                "advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media youtube | forecolor backcolor  | print preview code",
            image_advtab: true,
            indentOnInit: true,

            relative_urls: false,
            external_filemanager_path: "/resources/static/filemanager/",
            filemanager_title:"Responsive Filemanager",
            external_plugins: {
                "filemanager" : "/resources/static/filemanager/plugin.min.js"
            }
        });
    });
</script>



<form name="new_object_form" method="post" enctype="multipart/form-data">

    <input type="hidden" name="action" value="save_header_text" />
    <input type="hidden" name="block_id" value="<?=$vars['block_id']?>" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />


    <textarea class="form-control" name="text"><?=UString::ChangeQuotes($vars['text'])?></textarea>


    <button type="submit" class="btn btn-success btn-large">Сохранить</button>
            
</form>