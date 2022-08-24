<div class="container">
    <h1 class="page-title">ОТЗЫВЫ</h1>

    <div class="page-qa theme-pink">
        <div class="feedback-img-form">
            <div class="feedback-img-form-body clearfix">
                <div class="feedback-controls">
                    <div class="feedback-img-form-label">Оставить отзыв</div>
                    <?=$vars['form']?>
                </div>
                <div class="feedback-img" style="background-image: url(/resources/img/design/rosetta/reviews/form-img.jpg);">

                </div>
            </div>
        </div>

        <div class="reviews-block">
            <form method="post" action="/reviews/" data-form="ajax-filter">
                <input type="hidden" name="action" value="ajax_load_all_reviews">
            </form>

            <div class="reviews-grid clearfix" id="reviews-list">
                <?=$vars['list']?>
            </div>

            <div class="show-all-button">               
                <button class="btn-pink load-more-handl">показать все отзывы</button>
                <a href="/corporate_customers/" class="btn-blue">отзывы корпоративных клиентов</a>
            </div>
        </div>
    </div>
</div>