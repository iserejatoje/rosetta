<?
    session_start();
?>

<br>
<ol class="breadcrumb">
    <li>
        <a href="section_id=<?=$vars['section_id']?>&action=groups">Галереи</a>
    </li>
</ol>

<ul class="nav nav-tabs">
    <li role="presentation"<? if ($vars['action'] == 'edit_group') { ?> class="active"<? } ?>>
        <a href="?section_id=<?=$vars['section_id']?>&action=edit_group&id=<?=$vars['group']->id?>">Редактировать галерею</a>
    </li>

    <li role="presentation"<? if ($vars['action'] == 'edit_filters') { ?> class="active"<? } ?>>
        <a href="?section_id=<?=$vars['section_id']?>&action=edit_filters&id=<?=$vars['group']->id?>&serviceid=<?=$vars['serviceid']?>">Редактировать фильтры</a>
    </li>

    <li role="presentation"<? if ($vars['action'] == 'group_photos' || $vars['action'] == 'new_photo' || $vars['action'] == 'edit_photo') { ?> class="active"<? } ?>>
        <a href="?section_id=<?=$vars['section_id']?>&action=group_photos&groupid=<?=$vars['group']->id?>">Редактировать фотографии</a>
    </li>
</ul><br>

<? $message = $_SESSION['user_message']['message'] ?>
<? if (!empty($message)) { ?>
    <div class="alert alert-success" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <strong>Успешно!</strong> <?= $message ?></div>
    <? unset($_SESSION['user_message']); ?>
<? } ?>