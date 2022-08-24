<?php foreach($vars['list'] as $opinion) { ?>
    <div class="media-reviews__item">
        <div class="media-reviews__img">
            <div class="media-reviews__img-wrapper">
                <img class="img-responsive" src="<?= $opinion->thumb['f']?>" alt="<?= UString::ChangeQuotes($opinion->name)?>">
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