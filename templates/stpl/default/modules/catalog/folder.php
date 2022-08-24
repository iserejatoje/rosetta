<?php if(isset($vars['noAvailable']) && $vars['noAvailable']): ?>
    <div class="show-all-button">
        <h1>Товара нет в наличии</h1>
        <a href="/" class="btn-pink-noaction">вернуться в каталог</a>
    </div>
    <?php return; ?>
<?php endif; ?>
<div class="products-grid products-grid-folder">
    <div class="container">
        <h1 class="page-title">выберите букет с желаемым количеством цветов.</h1>
        <div class="clearfix">
            <?= STPL::Fetch('modules/catalog/products/_product_list', [
                'products' => $vars['children'],
                'isFolder' => true,
            ]) ?>
        </div>
        <div class="show-all-button">
            <a href="/" class="btn-pink-noaction">вернуться в каталог</a>
        </div>
    </div>
</div>