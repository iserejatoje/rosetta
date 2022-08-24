
<?
    $fieldTypes = $vars['fieldTypes'];
    $fields = $vars['form']['Fields'];
    $data = $vars['form']['Data'];
?>

<div class="container">
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
<input type="hidden" name="type_id" value="<?=$vars['form']['TypeID']?>">
<input type="hidden" name="action" value="<?= $vars['action'] ?>" />

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Настройка параметров раздела</h3>
    </div>

    <div class="panel-body">

<?
foreach($fields as $field)
{
    $value = !empty($data[$field['name']]) ? $data[$field['name']] : null;
    if ($field['type'] === 'string') {
        $result .= '<div class="form-group"><label>'. $field['title'] .'</label><input type="text" name="Fields['.$field['name'].']" value="'.$value.'" class="form-control">'.'</div>';
    }
    elseif ($field['type'] === 'text') {
        $result .= '<div class="form-group"><label>'. $field['title'] .'</label><textarea rows="5" class="form-control" name="Fields['.$field['name'].']">'.$value.'</textarea></div>';
    }
    elseif ($field['type'] === 'boolean') {
        if ($value != 0)
            $checked = ' checked';
        else
            $checked = '';
        $value = 1;
        $result .= '<div class="checkbox"><label><input type="checkbox" value="'.$value.'" name="Fields['.$field['name'].']"'.$checked.'>'. $field['title'] .'</label></div>';
    }
    elseif ($field['type'] === 'select') {
        $options = ['' => '-- Выберите опцию --'];
        foreach($field['options'] as $option){
            $options[$option] = $option;
        }
        $result .= '<div class="form-group"><label>'. $field['title'] .'</label><select name="Fields['.$field['name'].']" class="form-control" >';
        foreach ($options as $option) {
            if ($value == $option)
                $selected = ' selected';
            else
                $selected = '';
            $result .= '<option value="'.$option.'"'.$selected.'>'.$option.'</option>';
        }
        $result .= '</select></div>';
    }
    elseif ($field['type'] === 'checkbox') {
        $options = '';
        foreach($field['options'] as $option){
            if ($value && in_array($option, $value))
                $checked = ' checked';
            else
                $checked = '';
            $options .= '<br><label><input type="checkbox" value="'.$option.'" name="Fields['.$field['name'].'][]"'.$checked.'>'. $option .'</label>';
        }
        $result .= '<div class="checkbox well well-sm"><b>'. $field['title'] .'</b>'. $options .'</div>';
    }
}

echo $result;

?>
    </div>

</div>

<center><button type="submit" class="btn btn-success" name="save" value="1">Сохранить</button></center>
</form>