<?php

$opinions = $vars['opinions'];
$rewardFirst = ['title' => '', 'text' => ''];

$first = current($vars['rewards']);
if($first) {
	$rewardsFirst = [
		'title' => $first->title,
		'text' => $first->text,
	];
}

?>

<div class="shadow-sep"></div>

<div class="container">
    <h1 class="page-title">Наши дипломы и сертификаты</h1>

    <div class="page-mastery">
    	<form method="post" action="/reward/" data-form="ajax-filter">
    		<input type="hidden" name="action" value="ajax_load_all_opinions">
		</form>
		<?php /*
		<form method="post" action="/mastery/" data-form="ajax-filter">
            <input type="hidden" name="action" value="ajax_load_all_reviews">
        </form>
        */?>

        <div class="media-grid" data-widget="media-grid">
            <div class="media-grid__images">
                <div class="media-grid__arrows">
                    <div class="media-grid__arrow media-grid__arrow_left">
                        <svg width="16" height="26" viewBox="0 0 16 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3871 1L2 13L14.3871 25" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="media-grid__arrow media-grid__arrow_right">
                        <svg width="15" height="26" viewBox="0 0 15 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L13.3871 13L1 25" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="media-grid__container">
                    <div class="media-grid__scroll">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                            	<?php foreach($vars['rewards'] as $reward) {
                            		$sert_text = $reward->text ? $reward->text : '&nbsp;';
                        		?>
	                                <div class="swiper-slide">
	                                    <div class="media-grid__slide" data-gallery-media data-title="<?= UString::ChangeQuotes($reward->title)?>" data-text="<?= UString::ChangeQuotes($sert_text)?>" data-img="<?= $reward->image['f']?>" data-author="<?= UString::ChangeQuotes($reward->worker->name)?>" data-note="<?= UString::ChangeQuotes($reward->worker->position)?>" data-avatar="<?= $reward->worker->thumb['f']?>">
	                                        <img class="img-responsive" src="<?= $reward->thumb['f']?>" alt="<?= UString::ChangeQuotes($reward->title)?>">
	                                    </div>
	                                </div>
                         		<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media-grid__panel">
                <div class="media-grid__container">
                    <div class="media-grid__panel-flex">
                        <div class="media-grid__text">
                            <div class="media-grid__text-title">
                                <?= $rewardsFirst['title']?>
                            </div>
                            <div class="media-grid__text-desc">
                                <?= $rewardsFirst['text']?>
                            </div>
                        </div>
                        <div class="media-grid__btn">
                            <button type="button" class="btn-media">Больше дипломов и сертификатов</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($opinions) { ?>
	        <h2 class="page-title page-title_second">Отзывы маэстро</h2>
	        <div class="meida-reviews">
	            <div class="media-reviews__container" id="reviews-list">

	            	<?php foreach($opinions as $opinion) { ?>
	            		<div class="media-reviews__item">
	                        <div class="media-reviews__img">
	                            <div class="media-reviews__img-wrapper">
	                                <img class="img-responsive" src="/build/dist/resources/img/design/rosetta/mastery/photo.png" alt="">
	                            </div>
	                        </div>
	                        <div class="media-reviews__body">
	                            <div class="media-reviews__fold-container">
	                                <div class="media-reviews__name">
	                                    <?= $opinion->name?>
	                                </div>
	                                <div class="media-reviews__note">
	                                    <?= $opinion->position?>
	                                </div>
	                                <div class="media-reviews__text">
	                                    <span class="start-quote">
	                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
	                                            <path d="M4.27933 7.72624C4.67877 5.26236 5.47765 2.22053 6.27654 0L3.97207 0.212929C2.80447 2.09886 1.48324 5.23194 0.653631 8L4.27933 7.72624ZM9.65642 7.72624C10.0251 5.26236 10.824 2.22053 11.6536 0L9.31844 0.212929C8.15084 2.09886 6.82961 5.23194 6 8L9.65642 7.72624Z" fill="white"/>
	                                        </svg>
	                                    </span>
	                                        <?= $opinion->text?>
	                                    <span class="end-quote">
	                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
	                                            <path d="M4.27933 7.72624C4.67877 5.26236 5.47765 2.22053 6.27654 0L3.97207 0.212929C2.80447 2.09886 1.48324 5.23194 0.653631 8L4.27933 7.72624ZM9.65642 7.72624C10.0251 5.26236 10.824 2.22053 11.6536 0L9.31844 0.212929C8.15084 2.09886 6.82961 5.23194 6 8L9.65642 7.72624Z" fill="white"/>
	                                        </svg>
	                                    </span>
	                                </div>
	                            </div>
	                            <button type="button" class="btn-fold media-reviews__fold">
	                                <span class="btn-fold__text">Развернуть отзыв</span>
	                                <spna class="btn-fold__icon">
	                                    <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
	                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.000557029 9L3.9905 12.99L4.00054 13L7.99996 9L6.78114 7.80077L4.99234 9.58397L4.99189 -1.31488e-07L2.98911 5.1891e-06L2.98956 9.58403L1.2096 7.81039L0.000557029 9Z" fill="white"/>
	                                    </svg>
	                                </spna>
	                            </button>
	                        </div>
	                    </div>

	               	<?php } ?>

	            </div>
	        </div>

	        <div class="show-all-button">
	        	<?php if($vars['hasMore']) { ?>
		            <button type="button" class="btn-violet">Показать все отзывы маэстро</button>
	       		<?php } ?>
	        </div>	       	
      	<?php } ?>
    </div>
</div>


<div class="gallery-media">
        <div class="gallery-media__bg"></div>
        <div class="gallery-media__container">
            <div class="gallery-media__content">
                <div class="gallery-media__img">
                    
                </div>
                <div class="gallery-media__card">
                    <div class="gallery-media__card-content">
                        <div class="gallery-media__title"></div>
                        <div class="gallery-media__text"></div>
                        <div class="gallery-media__footer">
                            <div class="gallery-media__footer-img">
                                <div class="gallery-media__footer-img-wrapper">
                                    
                                </div>
                            </div>
                            <div class="gallery-media__footer-text">
                                <div class="gallery-media__author"></div>
                                <div class="gallery-media__note">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>