
<div class="container">
<div class="panel panel-default ">
	<div class="panel-heading">
		<h3 class="panel-title">Выберите каталог из которого необходимо скопировать параметры</h3>
	</div>

	<div class="panel-body">
		<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="copy" />
			<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<div class="checkbox"><label><input type="checkbox" value="1" name="IsRewrite">Перезаписать текущие данные</label></div>
				</div>
			</div>

			<div class="form-group">
				<label for="city-catalogid" class="col-sm-2 control-label">Список доступных каталогов</label>
				<div class="col-sm-10">
					<select class="form-control" name="cid">
						<option value="0">- Выберите каталог -</option>
						<? foreach ($vars['catalogs'] as $catalog) { ?>
							<option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?> (<?= $catalog['domain'] ?>)</option>
						<? } ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success btn-sm">Скопировать</button>
				</div>
			</div>

		</form>

	</div>

</div>

<div class="panel panel-default ">
    <div class="panel-heading">
        <h3 class="panel-title">Выберите каталог из которого необходимо скопировать типы</h3>
    </div>

    <div class="panel-body">
        <form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="copy_types" />
            <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="checkbox"><label><input type="checkbox" value="1" name="IsClear">Удалить текущие данные</label></div>
                </div>
            </div>

            <div class="form-group">
                <label for="city-catalogid" class="col-sm-2 control-label">Список доступных каталогов</label>
                <div class="col-sm-10">
                    <select class="form-control" name="cid">
                        <option value="0">- Выберите каталог -</option>
                        <? foreach ($vars['catalogs'] as $catalog) { ?>
                            <option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?> (<?= $catalog['domain'] ?>)</option>
                        <? } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success btn-sm">Скопировать</button>
                </div>
            </div>

        </form>

    </div>

</div>

<?php /*
<div class="panel panel-default ">
	<div class="panel-heading">
		<h3 class="panel-title">Выберите каталог из которого необходимо скопировать оформление</h3>
	</div>

	<div class="panel-body">
		<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="copy_decor" />
			<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<div class="checkbox"><label><input type="checkbox" value="1" name="IsClear">Удалить текущие данные</label></div>
				</div>
			</div>

			<div class="form-group">
				<label for="city-catalogid" class="col-sm-2 control-label">Список доступных каталогов</label>
				<div class="col-sm-10">
					<select class="form-control" name="cid">
						<option value="0">- Выберите каталог -</option>
						<? foreach ($vars['catalogs'] as $catalog) { ?>
							<option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?> (<?= $catalog['domain'] ?>)</option>
						<? } ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success btn-sm">Скопировать</button>
				</div>
			</div>

		</form>

	</div>

</div>
*/?>


<div class="panel panel-default ">
	<div class="panel-heading">
		<h3 class="panel-title">Выберите каталог из которого необходимо скопировать состав</h3>
	</div>

	<div class="panel-body">
		<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="copy_composition" />
			<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

			<?/*<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<div class="checkbox"><label><input type="checkbox" value="1" name="IsClear">Удалить текущие данные</label></div>
				</div>
			</div>*/?>
			<div class="alert alert-warning" role="alert">
				<strong>Внимание!</strong>
				Все текущие данные для этого раздела будут перезапсаны!
			</div>

			<div class="form-group">
				<label for="city-catalogid" class="col-sm-2 control-label">Список доступных каталогов</label>
				<div class="col-sm-10">
					<select class="form-control" name="cid">
						<option value="0">- Выберите каталог -</option>
						<? foreach ($vars['catalogs'] as $catalog) { ?>
							<option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?> (<?= $catalog['domain'] ?>)</option>
						<? } ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success btn-sm">Скопировать</button>
				</div>
			</div>

		</form>

	</div>
</div>

<div class="panel panel-default ">
    <div class="panel-heading">
        <h3 class="panel-title">Выберите каталог из которого необходимо скопировать допы</h3>
    </div>

    <div class="panel-body">
        <form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="copy_addition" />
            <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="checkbox"><label><input type="checkbox" value="1" name="IsClear">Удалить текущие данные</label></div>
                </div>
            </div>

            <div class="form-group">
                <label for="city-catalogid" class="col-sm-2 control-label">Список доступных каталогов</label>
                <div class="col-sm-10">
                    <select class="form-control" name="cid">
                        <option value="0">- Выберите каталог -</option>
                        <? foreach ($vars['catalogs'] as $catalog) { ?>
                            <option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?> (<?= $catalog['domain'] ?>)</option>
                        <? } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success btn-sm">Скопировать</button>
                </div>
            </div>

        </form>

    </div>
</div>

<div class="panel panel-default ">
    <div class="panel-heading">
        <h3 class="panel-title">Выберите каталог из которого необходимо скопировать состав</h3>
    </div>

    <div class="panel-body">
        <form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="copy_composition" />
            <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

            <?/*<div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="checkbox"><label><input type="checkbox" value="1" name="IsClear">Удалить текущие данные</label></div>
                </div>
            </div>*/?>
            <div class="alert alert-warning" role="alert">
                <strong>Внимание!</strong>
                Все текущие данные для этого раздела будут перезапсаны!
            </div>

            <div class="form-group">
                <label for="city-catalogid" class="col-sm-2 control-label">Список доступных каталогов</label>
                <div class="col-sm-10">
                    <select class="form-control" name="cid">
                        <option value="0">- Выберите каталог -</option>
                        <? foreach ($vars['catalogs'] as $catalog) { ?>
                            <option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?> (<?= $catalog['domain'] ?>)</option>
                        <? } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success btn-sm">Скопировать</button>
                </div>
            </div>

        </form>

    </div>
</div>

<div class="panel panel-default ">
    <div class="panel-heading">
        <h3 class="panel-title">Перекешировать цены каталога</h3>
    </div>

    <div class="panel-body">
        <form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="recache_prices" />
            <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="checkbox"><label><input type="checkbox" value="1" name="IsClear">Удалить текущие данные</label></div>
                </div>
            </div>

            <div class="form-group">
                <label for="city-catalogid" class="col-sm-2 control-label">Список доступных каталогов</label>
                <div class="col-sm-10">
                    <select class="form-control" name="cid">
                        <option value="0">- Выберите каталог -</option>
                        <? foreach ($vars['catalogs'] as $catalog) { ?>
                            <option value="<?= $catalog['id'] ?>"><?= $catalog['name'] ?> (<?= $catalog['domain'] ?>)</option>
                        <? } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success btn-sm">Закешировать</button>
                </div>
            </div>

        </form>

    </div>

</div>

</div>