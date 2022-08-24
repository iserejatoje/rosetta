<?
session_start();


$types = array(
	0 => 'types',
	1 => 'product_type_edit',
	2 => 'product_type_new',
	3 => 'edit_composition',
);


	$category = $vars['product']->category;
	$types = $vars['product']->GetTypes($vars['section_id']);

	$default_type = $vars['product']->GetDefaultType($vars['section_id']);

?>

<br>

<ol class="breadcrumb">
	<li>
		<a href="section_id=<?=$vars['section_id']?>&action=catalog">Каталог</a>
	</li>

	<li class="active">
		<a href="?section_id=<?=$vars['section_id']?>&action=products&type_id=<?=$vars['form']['TypeID']?>&parent_id=<?=$vars['form']['ParentId']?>"><?=$vars['sections'][$vars['form']['TypeID']]['name'] ?></a>
	</li>
</ol>

<ul class="nav nav-tabs">
	<li role="presentation"<? if ($vars['action'] == 'edit_product') { ?> class="active"<? } ?>>
		<a href="?section_id=<?=$vars['section_id']?>&action=edit_product&type_id=<?=$vars['form']['TypeID']?>&id=<?=$vars['product']->id?>">Редактировать товар</a>
	</li>

	<? if(!in_array($category->kind, [CatalogMgr::CK_ROSE, CatalogMgr::CK_MONO, CatalogMgr::CK_FIXED, CatalogMgr::CK_FOLDER])) { ?>
		<li role="presentation" <?if(in_array($vars['action'], $types)) { ?> class="active"<? } ?>>
			<a href="?section_id=<?=$vars['section_id']?>&action=types&type_id=<?=$vars['form']['TypeID']?>&id=<?=$vars['product']->id?>">Редактировать типы</a>
		</li>
	<? } ?>

	<? if((App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users')) ||  App::$User->IsInRole('u_bouquet_editor')) { ?>
        <? if($category->kind == CatalogMgr::CK_ROSE) { ?>
            <li role="presentation"<? if ($vars['action'] == 'product_lens') { ?> class="active"<? } ?>>
                <a href="?section_id=<?=$vars['section_id']?>&action=product_lens&productid=<?=$vars['product']->id?>">Ростовка</a>
            </li>
        <? } ?>

        <? if(in_array($category->kind, [CatalogMgr::CK_FIXED, CatalogMgr::CK_MONO, CatalogMgr::CK_ROSE])) { ?>
            <li role="presentation"<? if ($vars['action'] == 'edit_composition') { ?> class="active"<? } ?>>
                <a href="?section_id=<?=$vars['section_id']?>&action=edit_composition&type_id=<?=$vars['form']['TypeID']?>&id=<?=$vars['product']->id?>&tid=<?=$default_type->id?>">Редактировать состав</a>
            </li>
        <? } ?>

        <li role="presentation"<? if ($vars['action'] == 'edit_filters') { ?> class="active"<? } ?>>
            <a href="?section_id=<?=$vars['section_id']?>&action=edit_filters&type_id=<?=$vars['form']['TypeID']?>&id=<?=$vars['product']->id?>">Редактировать фильтры</a>
        </li>
        <? /* <li role="presentation"<? if ($vars['action'] == 'edit_composition') { ?> class="active"<? } ?>><a href="?section_id=<?=$vars['section_id']?>&action=edit_composition&type_id=<?=$vars['form']['TypeID']?>&id=<?=$vars['form']['ProductID']?>">Редактировать состав</a></li> */ ?>
        <li role="presentation"<? if ($vars['action'] == 'photos' || $vars['action'] == 'new_photo' || $vars['action'] == 'edit_photo') { ?> class="active"<? } ?>>
            <a href="?section_id=<?=$vars['section_id']?>&action=photos&type_id=<?=$vars['form']['TypeID']?>&id=<?=$vars['product']->id?>">Редактировать галерею</a>
        </li>
	<? } ?>
</ul><br>
<? $message = $_SESSION['user_message']['message'] ?>
<? if (!empty($message)) { ?>
	<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<strong>Успешно!</strong> <?= $message ?></div>
	<? unset($_SESSION['user_message']); ?>
<? } ?>