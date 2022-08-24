</div>

{if !$smarty.cookies.plashka}
    <div class="sale-warning" style="position: fixed;
        padding: 20px;
        line-height: 1.3em;
        background: #e73a62;
        border-radius: 2px;
        bottom: 20px;
        left: 20px;
        max-width: 437px;
        margin-right: 20px;
        color: #fff;
        z-index: 10;">
        <button onclick="setCookie('plashka', '1')" style="width: 30px;
        height: 30px;
        background: transparent;
        padding: 0;
        border: 0;
        position: absolute;
        right: 10px;
        top: 10px;">
            <svg width="22" height="22" fill="#fff" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 64 64"><g transform="translate(381 231)"><path d="m-370.7-174.7-2.3-2.3 46-46 2.3 2.3-46 46" class="st0"/><path id="Fill-17" d="m-327-174.7-46-46 2.3-2.3 46 46-2.3 2.3" class="st0"/></g></svg>
        </button>
        <p style="margin-bottom: 10px;"><b>Уважаемые клиенты!</b></p>
        <p>С 1.04.2022 временно изменены условия дисконтной программы: максимальная скидка по дисконтной карте при покупке в интернет-магазине составит 5%. Приносим извинения за доставленные неудобства. Мы вернем прежние условия при первой возможности.</p>
    </div>
{/if}

          <footer id="footer">
              <div class="container">

                  <div class="footer-col">
                      <div class="footer-col-title">
                          Телефон:
                      </div>

                      <a href="tel:+78005006292" class="footer-phone" data-ya-target="click_phone">8-800-500-62-92</a>

                      <div class="copyright">© Розетта</div>
                  </div>

                  {if $BLOCKS.footer.footermenu}
                      {$BLOCKS.footer.footermenu}
                  {/if}

                  <div class="footer-col footer-col-offset-1">

                        <div class="footer-col-title">
                            Обратная связь:
                        </div>

                      <ul class="footer-links">
                          <li><a href="#" data-control="feedback" data-form="callback">Заказать звонок</a></li>
                          <li><a href="#" data-control="feedback" data-form="letter">Задать вопрос</a></li>
                      </ul>
                      <div class="social clearfix">
                          <a href="https://vk.com/rosetta_florist" target="_blank" class="social-item item-vk"></a>
                          <a href="https://www.youtube.com/channel/UCO9av2dtuKY6NiZWTwI2uaQ" target="_blank" class="social-item item-yt"></a>
                      </div>
                      <a href="http://zgalex.ru/" target="_blank" title="ZGA - Site, Brand, Support" class="develop">
                          <span class="xs-hidden">Сайт разработан в </span> <span class="dev-logo">zgalex.ru</span>
                          <span class="dev-logo dev-logo-mobile">ZG</span>
                      </a>
                  </div>

              </div>
          </footer>

          <div class="ui-arrow-top"></div>

          <div class="ui-mobile-substrate">
              <div class="social clearfix">
                  <a href="https://vk.com/rosetta_florist" target="_blank" class="social-item item-vk"></a>
                  <a href="https://www.youtube.com/channel/UCO9av2dtuKY6NiZWTwI2uaQ" target="_blank" class="social-item item-yt"></a>
              </div>
          </div>

          <div class="alert-popup-bg"></div>
          <div class="alert-popup">
                <div class="alert-popup-close cross-close"></div>
                <div class="alert-popup-title"></div>
                <div class="alert-popup-message"></div>
          </div>

          <div id="popup-bg"></div>
          <div class="popups">
              <div id="popup-make-order" class="popup popup-item">
                  <div class="close-btn"></div>
                  <div class="popup-body">
                      <div class="popup-notice">
                          Оставьте заявку на заказ свадебного букета<br>
                          и наши специалисты свяжутся с вами.
                      </div>
                      <div class="popup-form">
                          <form method="post" action="/catalog/">
                              <input type="hidden" name="action" value="ajax_send_bouquet_offer">
                              <input type="hidden" name="id" value="">
                              <div class="form-group-grid clearfix">
                                  <div class="form-group group-part-left group-2-3 field-username ajax-required">
                                      <input type="text" class="form-control form-control-rect-simple" placeholder="Ваше имя" id="username" name="username" autocomplete="off" data-vtype="notempty" data-message="Укажите ваше имя">
                                      <p class="help-block help-block-error help-block-error-white"></p>
                                  </div>
                                  <div class="form-group group-part-right group-1-3 field-wedding_date ajax-required">
                                      <input type="text" class="form-control form-control-rect-simple datepicker" readonly="readonly" placeholder="Дата свадьбы" name="wedding_date" id="wedding_date" autocomplete="off">
                                      <p class="help-block help-block-error help-block-error-white"></p>
                                  </div>
                              </div>
                              <div class="form-group-grid clearfix">
                                  <div class="form-group field-contact ajax-required">
                                      <input type="text" class="form-control form-control-rect-simple" placeholder="Ваш телефон либо почта" name="contact"  id="contact" autocomplete="off" data-vtype="notempty" data-message="Необходимо заполнить поле">
                                      <p class="help-block help-block-error help-block-error-white"></p>
                                  </div>
                                  {* <div class="form-group group-half field-phone ajax-required">
                                      <input type="text" class="form-control form-control-rect-simple phone-mask" placeholder="+7-(___)-___-____" name="phone"  id="phone"autocomplete="off" data-vtype="phone" data-message="Неверный формат номера телефона">
                                      <p class="help-block help-block-error help-block-error-white"></p>
                                  </div>
                                  <div class="form-group group-half field-email ajax-required">
                                      <input type="text" class="form-control form-control-rect-simple" placeholder="Ваш  e-mail" id="email" name="email" autocomplete="off" data-vtype="email" data-message="Неверный e-mail пользователя">
                                      <p class="help-block help-block-error help-block-error-white"></p>
                                  </div> *}
                              </div>
                              <div class="form-group field-wishes ajax-required">
                                  <textarea class="form-control form-control-rect-simple" placeholder="Ваши пожелания" id="wishes" name="wishes" autocomplete="off" data-vtype="notempty" data-message="Не заполнен текст пожелания"></textarea>
                                  <p class="help-block help-block-error help-block-error-white"></p>
                              </div>
                              <div class="form-group field-isAcceptWedding ajax-required">
                                <div class="checkbox-privacy">
                                    <div class="checkbox is-active" data-control="checkbox" data-trigger="disableSubmitBtn">
                                        <input type="hidden" id="isAcceptWedding" name="isAcceptWedding" value="1" data-vtype="notzero" data-message="Поле обязательно">
                                        <div class="checkbox-body">
                                            <div class="checkbox-icon"></div>
                                            <div class="checkbox-label">Согласен на обработку моих <a href="/oferta/#privacy" target="_blank">персональных данных</a></div>
                                            <p class="help-block help-block-error"></p>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-white-wide hover-red pull-right popup-send">отправить</button>
                            </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>

      </div>


    {include file="design/rosetta/feedback.tpl"}

    {if $BLOCKS.header.sidebarmenu}
        {$BLOCKS.header.sidebarmenu}
    {/if}

    {php} if(App::$CurrentEnv['url'] != '/reward') { {/php}
      <div class="btn-mastery">
        <div class="btn-mastery__container">
            <div class="btn-mastery__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <rect x="1.04904e-05" y="24" width="24" height="24" transform="rotate(-90 1.04904e-05 24)" fill="url(#pattern0)"/>
                    <defs>
                    <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0" transform="scale(0.0222222 0.0227273)"/>
                    </pattern>
                    <image id="image0" width="199" height="44" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMcAAAAsCAYAAADRhqyHAAAX40lEQVR4Ae2dB7RuVXHHZxQxKsaOoKKJMZYQEguxoxIbComVJBoTQWWpAUuwYOwlQqIRjSU2RCFGIaiIEhFRLIiCJioqRYOCFAUCQRSwIX/X79zZh332N+d8373vXZ+s9c1a751z9p49u3y7TNtz3TYSSLqumf2VmT3QzP7YzG5oZj80s6+Z2afM7BB3/8lGqm5JZjkCV48RkLSnpO9rGs6V9HdXjx4tW7kcgQ0cAUnXk/Sx6TUxk/tRSdfZwKqXxZcjsO4j4KupQdK1zOw2ZnZ9M7uGmb3HzP5wNTQC93/M7Mlmdk0zu8TMznL3X6yBzrLIcgQ27QhIerykD0r6wcw5sHESYMkOk/SXm7any9qXI3DVCEyeHJL+xMzeZGb3uKrIur99wcz2cvevboyaJKEY+Lm7X17Tk/RboTS4iZltaWbXMzNORpnZT83sXHf/Rl1mNe+SbmpmNzOzK83sAne/eDXlC66k3zGz20VbOV3/38xOd/cfFJz6KekGtN/df1an1+/R92ub2WbxDy4AuIKxMrPLy0kuidP9SndnXNYMwXVcAR1JzLtrujv1rRmibXJ3xrgDWP3gbBjzOv1apU8Fd95zdHFI+nMzO2IegXXM38Xd/2tD6Uv6CzPbz8yYrN8xM/qMZu3GZsZEYkGMwWlm9kEze427/2gMiXRJLDLqeoCZ3d/Mbt7gf8/MjjOzY8zsP92dBTgDkn7XzB4eNB5hZpvPIK1M4hPN7GgzO6BeKJKeaWbPMzPkum/FYmcRsBmwIFhsvGfAArjMzN7g7i8BQRK/wXaxiBgzcJh0TOxvx0ZSaDG2sN03CpaZhcWmxMZAnbu6++clodXcPxYi40Yffxl0zzczFn5ZjNCEjb9t0GQhk3dh/JZHuzssegeStolx+b2gwyZBO1g073f3vQvump6Stt043NIGU7njmjpQFUL4l7SDpHePtOYSSS+QtLukV0n6coKHpu0PKrKDV0nPlgSdGt4u6bEsTkn/XmdIgt7fDIjEh6RTKtxzJO0j6T6S7o62T9K3q3xeL48NoKPASSlpJ0mfbfDKJ+18raTnS3qxpP0lvU/SNwuCpH8rbZN0XpVOe74miQl+QpVev14s6ThJX5L0rTpD0mOgK+k5VfpPJJ0a9D4n6RdVXv1KncdL+oak86uMz5e2lqek20t6YYVTv8JJrB0kfaemtgnfT117L2ZLSnpr0pdXtZixWFrUH0v67QT30AbxMkl3SPCY4C28IcE7KZAObPPKt6STW0KSdiz55TmyQHYu+e0zVPKQfit5sD+SfirpZ5JmFC+SPpG0g5OvB0mbSWKjAPYgQ9K+8f38HjFeJP1p5NWPrj01rqQHBgKnYwqSjq6JxPtzU+RFEmGnGoJXrlIQZ3c5QtKrJe0l6UnxD1vIKyR9QBI4i8KfLdLuRXAk7ZZU+sqsrKTDE9x/rnElHZzg7FLj1O8ji+5lDQ674qSxVNIjknpPD16+JyfpdQnew3qE5EXSBZwOZEm6bZTv2Za6yMgY3b7GKe9B56Cgy+5/XsmrnyOLY2YTCToHQrcuX96RccL2xvytT6NUVivlJp+SDmkGFOIvknQrSU+R9ObQXLEqj4wJsp+kXSXdKYSkeXWwm8DqvKupK/uE598oIOkZSQX/lBGXtH2Cy8TtZABJD0vyR3exUoekC5Ny25IfOzXZBxT87Clpy4QGSe2u/ZYE71EZzZIWv/WZfAermU6+yD8qoY93xAxI+kywRNeQdIWkwaZQCkjaJaH5tpJfPznNAhc5agCSnhB5sKXfa2juNEBe9GOEpUKQXBWwSODTJd1iqmAsku82ja8/6dio4mCKdpsXskFNm/exxUH7f9QiMzGhK4mduoV/aOtsvyW9py0k6eNBkzr5UVEejMLE4rhTXWiEjZy3ONhxO1mPxSbpj2qa9TvtTvpylxqnvKNFk7RdzIu7SkI5MAMJ50IV75hBjISQj2fGq8g7oEn6VNPOGTklo19UeF1eTGS0Ai3cN1YfQhinRNqxUigmMw042czOlPT6ktc+3Z2Fd+fQLLTZfN860fxkeIukZYssSzN3R3uSqUN/GJMXbUgLn24Tkm+0TC08VNLNqdPd3+vuaGKmYLAIAhGNENq4NUFsZNuj7nR3tHSMwRnu/vUJgoP5E3hj43kJqvHo41cmVM1Z+Sytq87dT27HSxJzBvbuw9GmzzZ9QP4DZxLazk3pnSGGveMFZjbgvZMaoHu3SEdVijYnPUbBCTUpassxmOTBxwol6dkgZ2nsNqgEUTMOwN2xA+w6SLzqYxF+dmyy7XAVmblvT0sw9oy2JVkLJR0eTqMLIQdSNnbtnFoNPXCz8lnaFF1U2cC/xjM7eZ4ReaOPtlJ4t6kFUgjdp7xMPC9o8l6eaXsKjrt/2cxOKN/Vk/Zkp1mFsvBr9mOOFWaxtvhfCuTMKMoCxhVmHpw7grD9SPogGeVGeD+XdAyD+7j7+0vCnGcnT9Q4YXdgp2WBrAba+UPZdsxWQ2+s/Gpp7hWGzM90BN0R/ttTHbU49o9RwDjUAbybmR0bxp6SPPbEKLMWQB2IBXwMOAbv2WTSxk+j53d3jE4bAtkgj/l0ZSq/V0flWyeN+HEYvJKsQRILCANga4ibOeYlYYhDwP2/wMcYV05kiMK27uHuXxzUMP0BW/zdmMS0AYMdGwFs5Peni87kZuOZLZiZghMJWfksLSWBtisy3t0goPGq1d0Ygv/azA5u8PrPbnGEDMEqw4q4CGSDskg5GjQF3P/IAEs2Rq1tNtDlIBvkmd1DEipHLL01HOnuH4mEzKrOIlvk1AUH3HZxZJ7KsG8siDG4JdZ7SUe5+75jSE36Q5vv8snJt9rfNRvP1dIo9ZdnVj5LK/jt88WRUFiqkv9RM8PLobZVvXBqcZTOYWSZkfgL1eTZ+6wkeVNJ7K5TsMVE5lZm9uaJ/EWyskFG1cdu+qCwaHN6/m1D7HB3r+0tyB0toOLNFk2Lx4aU4Q3kqlBqsDh+P9wnGBuUAM8yM1wsAKy99zUzbEpYpbP+BWr/eFy4lqBUYbNCG3WSmUE/a1dfMHnJ6svSkqKjSWVO1ghZWp3fvYcfHacDfnH/WyOEb9jb6zQzu4OkjEVeQZN0u0bNtcjnpOU61HWZoW/SdL/g3ZBJ1XDT+cHniBHu7IkO40qCH9AAElsQJLAk43s0CZJuM1Lfv0wWrDLx45J0UUJnoBUcUeU+qCLVveKIGLQe2eZNfUvC3aOFReTRUbKMd0tQ0ntHC1QZ4WpD8YdUyf1rzEvcVWr4UI/QvLCLPaFJW69PrsmOsU1oh7AfTFpvo2FPMbPUqr1Aw7NdDa9jjmDcKmgDvDc8PirCwe5T0T+rei+v7MQsfrxmp4ATMIOFvZDdnYWBTaXdCTHSPq9iPbMdFxZ1ADhB4ldmZmNtG+BXH9l4ZmlVkbmvWZuztIwQgjiAdhRDH8oPTnlOSJRNt0rY2UeFGr2cxkFixWW5CDB94kZ6gR8ucDpu6OVj5LmopoROr3VxZIO8VejcR3eQpL3IHkVdWGej/kXYnYIxGeJzU4WSPO7ltwBrxOS/KDI6mbJBmpGxyHf3l9ZsGc579KVaaA2Z7jMbzw1dHFn5rJ5BeyShyGHyI9OxyWYbLR7H30wu6D3dzF4+IBg65cyY1eKt9huZBD0ywtHuZrYtu11GRNJdJKFmu3eWn6RxR2KtkA38qHvEWCW4XVd8f402JuzWOJnK9kR3P7tGWuM77uFMgAILLw4KlDsb4ZWLBmze2GSTNksr7VnkmZXPfreWVtEu7u3u4CN4I0fz7wakufsW7s7m1MqMuPnPAIO3SMUzBecluHsqPIf/D855CEK4gafuBvPorzE/UyTMmwBjVe0T14Tr/MebGRqQKeCeTAvlh23Tp76zEwjLc31PJPtt05OjqYid9NDwEmiyBp/ZeGZpg0JzPrLyk7+RJE5M3OHRAnYevO4+pfzBXw/FRIEb4bZSaSO7dFYpl3A2Nlxb0odDT9/SRp0GTw9/vpaFMSq3tBUl35k7SJaWFB0muTvq3s7IVOUgbI/6LkX0ldZGcmCcRB2ZYGcqkqOvL0py2kWWqZazydeTklRUoIuwmdnJVC/Onu4qXrLfY3JxhL2CKlBpZ31uqx8oLiJz1oMDx7tadF/wfZ62Cs/LAq0xpm+opK1H7gSUstkzdRTsiU68wL4lBFftVFmqCO0HF3BquFTSDKvKlWNJeDjXMPA4jrv65L8jrseWqgZPSdg2Wnj2AGnF4a69bEQZDF8zgK0rrhkUuhn715fD20ESfW3hFT3SGl7QTLUEcYYdIxX3RUpYKNTwcwEBPKmDpKEsW7n9juCnyfMWB96lZ1UlJ12ERzxVq+KD11W5koQn6ONGLv4UwqhsCSLRuY7PHd0GIW7W/bIQi+cr40LOwyW9s8nj4tQM+yXpjQ0e9x64nch1gJ3D5b6+sQf6GZJ6FWzcGHxac4OvJotminsoXPw6KO5k0P+f10hxF73paefhihPqM+MGYlOk/6S/uJ53HswzRJqEuDfyaEmEbRoD+vlkZFSKS7pz3GZsVbP0Bc9mLP8DwMM47vRkZoZS7xckMV+27nhSBsjM+gEeUMw/TnP3zDO0ww6fFdi1orE6yd3xvB0F3IrNbJ7m7GB3f+IokSYjtC/QvVcYuLhvgTBWjmnYSlSwGNo4jvGd2nEBXrupqfuxuEvxaDNjI6AfrWCJke+TZoZ7+mHuDms5A+Euji0C1fLYpoKDIyzdkbVsEL5rXwmVLPw3qmhU0/zOGPiwyqPRqa3EdRtQQ8P2nuLuMzcGudNjZoRVwp6D8M9vDH1YNeqgz9BmLMj/R3fn/v4kxP0V5DW8BHARYqygye8ETdrOacw72iYMn/9hZsiujCMaQvAxxCKLIVc93d0JHdVBBHhAI4gLE3OAMvzm9VygfuY1Y7d/WRzw/zhnTbqil4oYdHdPb3yBE4sD7UvNX2/n7nQshbhEdEoMQoZzrLsTanRhiMXBD3nphIt0Ry9caFCDXlhHrVi4sgoxontgM2D34kdj0p232ugXkJQEHfqAaw/8OK7p5xTNUlUtuPx+129duGucoImswETiyYRjgtBO3NVHZYYI+coEunjeGEnC/26zRaKuhPGUiCksqFGAhYoxxT9tc3e/NEOOhXCdOihGVfaiBdrO2CDkr0BcOipHy7znmNt1IccP1d6+ek2fOfISfCw3EeujkmubM/e8R0gsk5cjsD4jIIlLN/V927FFMlfwSYIAzLMc952Km25coOcq7Txnxb7c8mU5Aus2AggxY6uhSW/dFmbaFPfMm2K5pmSm8DJhOQK/ASPQyRylHXF1cBG7xx3dfTKYgCQs3scX2vGEX95yQV10U3Rtn+GEVuwpCGAIlYchdIYLCHzr8e6OEx1CH5E2uCZKMDM8cQnOhiqRYGx7hpLhjfQ/aOPVilAKbQTRj7s7IWvwDMCdhBMTXhkhEVq4KSDbkA+vjys1F5CeGninFmNUyG67Rbn9WjlDEu1DCYAPEbICMgnCfnahiUBz/ANn/yL/SMLghxX5GHfvL5uhbTKzu5rZW1rvBkkEnXtwyKm49r/O3QnnRKgd+ooBDlmmk4HMDBsCfUfoBpAtuGVJJEXC9HCXBQdPFAbw+yhyMEJ2d+spEJpEovQzPwl9hK/eMWgj43eivkNDoYBnBi5L7ypySZTH8EcQuIH6Pq49U4axoe38lrPycaOCrXd+4jHhFp35rKx0ufk/XMApU8NRDdq6fkaAL+qHXSTgw7Nw2gtPVIKaAS+lEaF6PU3SvSL/ZZFPQLVt4p1wN931WTRLkUbgM3CeCy1J2HneJgn1ZAl+VlS6hNUhOj3BzwB07gQ1KEEABtdlQ00M3sCOQVC4leJdcLYSw+nYCRXsVoHPA20P/b1lpBENpFaekEcwOmDg6VDZWPCeZTwx9hIgjj6gGq7DBqHOxWZDYIUtYv5Ak8gt9448IqlgM0GFCtxfErdGARY+bXlMfBOojQg3r5eEtoq8PhJLfPPbEuHlwSGYkzyD1yWupNMu8Pm3Y/WnNGbidEHkQ9GQ+kEYnkU1WaXe/olBKwKDFZqZhbLHr1/Q1tQOcXXeou8xEYnUlxnnCC/Dzk/fmcxdVL74ZoABomWgY5/x/wr7QHcJKn5kJn7vooHFGQKlrcWtPdzzu3qjrr1Xqhr+eYaYbNg7BldwIyxSTZfio9FPwuDKggU+EHUyeZkUM2rlkD8Zs7qOG68U1yCGQCxwTowOJLHB9NekQ3PF+HabUYUHG9/JlBHTrK6LqkqcK94HcYvLBgWtiBJJoDsWIRvagCMKHEItHRDt7114Ym6S/PeB9xE+eOcoagGWowaOmCehCo0dkVCLD4iJhLFlD45mSRiecJnGmMbu0Ud4iGO+HlBcignINeM+XVcsiauN/WSt81b5jjMedTHBOf5hVQrAIrDTY+vhOK+9XcvlH3T7O7h7dsUXh0piejG4B7n7ZY2dpLvhF/4/OPcVxUR38y5iQxEaFBaJxdKrECXdj3vp4SzH7kpbC8CeYRlm1y72oakNDDaIU/sQxjQWMEY63EVuGjaMjnbYWm5SbFOctlFp2RwGChl3P79hlZlX/dyq/Jy6BRRB/j6GfalS33Y3I8NQ99qoj1O6bDTEBe6hYfW43ot9Ai3qES37GYV2cneuO8A61jIzbBos81MjaiRsd6fO7ld7qZWL+jEpi3UTgwiWW+waXDSae6Gn0OJJXNPg2YvxraxqeG6iKxLAjIHCLsJChGW5Oz750eEbjnS2rmbeO33BKY9jGfaBuLnHwSdDGzbKzPBCJa323SptJaD2EyWd6e6tazOTGT4VGYUbdfQZ/T596T7j2Z8S8c3CY4dCvuF5ThjS+t0z7jzfjItUUQbenbFikf03O7GZETZ0EZcavJkxsOEiAX//zlgY9Js0+H7aALAIsYTDtyMf0GcWUXHHnwmiFuXmPcqCwdiKXETYphL9vIwPuzpzgM3o6xXHMmpXiw3ljGjrV7G4E1aoNCY4BsKMImtgGL1nucMRc+shcVrgm0a5mXCuhRY/LvzgpoDW96jsVH3b1vISHUEZQN9KQGnC+ncQbAFuGZ0sUaWX8KHw07hMAC0PTlp3USnYKliH/n54YX8Ka1HR7uIRV9+F5ek2pTjuiRJ4v2DrivzT3bSr5AUmOf0CpuLrEqK1C14RuN0i5PSO726BRSBq5AhkpLsFOwlK4f+L/apbIOHbROBxBOkOYFMpUL7Lswqf2p3I4Q7T/cbV7cpyWpdi9I32AJx+HSBgl9M48roNpLoh2QfqCC4FH8J7VGxUHz8s8st4EMWze585OagZ9oFBQdqPtvy6HmWnpr7dRtiYhdsSvCcaGlglBODnxA65p7uzKzLw7MbE4tq5PqrDL4ijmrsbu7s7pydaHUKjYk3eN/5uBvn4keHWAnsDi1F+KHY7ThW0dpyS74uTClcadnEEef4GCqcrCwo8hGscEtm9YcE4zfi90IqRjyBM/Whe8OiFrX1s5IHIrll2+G6soixji/YMtoLbj8WxkMmJWwWKAbiCsiGdAAsYfaZeNgpcU2g74TnfhBAdrCCnQBlP8nFt2RwFBxFtov3Ie7Sb8YIdZyPizzUQgZ6FBodCPfiRoYkCtwN3fySKADN7CYqPuLPCicYVZ6KxELTtuigIIowTbBIxmWEH2bj43T7p7idGH5kPyE8oJvBiwKcOhQpsNWsCZ9JR7+quUbF7ZGEvY7Guy6OoSGNo1v5gcdSnQXR+QBB1bMWz93kIivGHUFhA/QWr0Mqwo6Ll6O/ER+jMgbNbk8+9727xN21CKO19nfjx4LPLThztoB9dZJjYqW/RlOn+Fkj0d0aOK7JdEX77Tq5sDnUf8MztTgBOupZeUyfsHp7Gg6u1Td8Ka84Y9u2KuMs9a9bQRf4p7FfdVGhwglNn73w6Ud+tQ5vWhZGq+lX3lw2hD4lUOyvCTQwqzz5CCEeTgh0Aj871AOjCQhTBL2vKMm05Ar/WEajZmLkVx2riaGYXQIsAj1s8b+eWrxA49tEcsEMgAJ/t7r3qr8Jbvi5H4Oo5AgSejr/gs5rT5IsLHVlXzyFZtno5AsMRCItme1mmXTDYSTpL9LD08ms5Ar+ZI7AqtmqqCwQrC/05AbUQtrB8YnxDk/GJ8IXJ4j1NkV3mLUdgk43ArwCZ/sfOCdD4pgAAAABJRU5ErkJggg=="/>
                    </defs>
                </svg>
            </div>
            <div class="btn-mastery__text">
                Наше мастерство
            </div>
            <a href="/reward" class="btn-mastery__link"></a>
        </div>
      {php} } {/php}
  </div>

    <div id="popup-video" class="popup-video">
        <div class="cross-close"></div>
        <div class="video-container"></div>
    </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="/resources/scripts/design/rosetta/vendor.js?v=0.0.3"></script>
      <script src="/resources/scripts/design/rosetta/main.js?v=0.0.12"></script>
      <script src="/resources/scripts/design/rosetta/roman_filter.js"></script>

      {literal}

          <!-- Facebook Pixel Code -->
          <script>
              !function(f,b,e,v,n,t,s)
              {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                  n.queue=[];t=b.createElement(e);t.async=!0;
                  t.src=v;s=b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '1520422061665111');
              fbq('track', 'PageView');
          </script>
          <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1520422061665111&ev=PageView&noscript=1"/></noscript>
          <!-- End Facebook Pixel Code -->

          <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?169",t.onload=function(){VK.Retargeting.Init("VK-RTRG-1149076-3NAFI"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1149076-3NAFI" style="position:fixed; left:-999px;" alt=""/></noscript>

        <!-- REMARKETING -->
        <div style="position: absolute;top:0">
        <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 877043433;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/877043433/?guid=ON&amp;script=0"/>
        </div>
        </noscript>
        </div>
        <!-- /REMARKETING -->
      {/literal}

  </body>
</html>
