</div>

          <footer id="footer">
              <div class="container">

                  <div class="footer-col">
                      <div class="copyright">© Розетта</div>
                  </div>

                  {if $BLOCKS.footer.footermenu}
                      {$BLOCKS.footer.footermenu}
                  {/if}

                  <div class="footer-col">
                      <ul class="footer-links">
                          <li><a href="#" data-control="feedback" data-form="callback">Заказать звонок</a></li>
                          <li><a href="#" data-control="feedback" data-form="letter">Задать вопрос</a></li>
                      </ul>
                      <div class="social clearfix">
                          <a href="https://vk.com/rosetta_florist" target="_blank" class="social-item item-vk"></a>
                          <a href="https://www.youtube.com/channel/UCO9av2dtuKY6NiZWTwI2uaQ" target="_blank" class="social-item item-yt"></a>
                      </div>
                      <a href="http://zgalex.ru/" target="_blank" title="ZGA - Site, Brand, Support" class="develop">
                          <span class="xs-hidden">сайт разработан</span> <span class="dev-logo">ZG</span>
                      </a>
                  </div>

              </div>
          </footer>

          <div class="ui-arrow-top"></div>
          <div class="ui-mobile-substrate">
              <div class="social clearfix">
                    <a href="https://www.youtube.com/channel/UCO9av2dtuKY6NiZWTwI2uaQ" target="_blank" class="social-item item-yt"></a>
                    <a href="https://vk.com/rosetta_florist" target="_blank" class="social-item item-vk"></a>
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
                                  <div class="form-group group-half field-phone ajax-required">
                                      <input type="text" class="form-control form-control-rect-simple phone-mask" placeholder="+7-(___)-___-____" name="phone"  id="phone"autocomplete="off" data-vtype="phone" data-message="Неверный формат номера телефона">
                                      <p class="help-block help-block-error help-block-error-white"></p>
                                  </div>
                                  <div class="form-group group-half field-email ajax-required">
                                      <input type="text" class="form-control form-control-rect-simple" placeholder="Ваш  e-mail" id="email" name="email" autocomplete="off" data-vtype="email" data-message="Неверный e-mail пользователя">
                                      <p class="help-block help-block-error help-block-error-white"></p>
                                  </div>
                              </div>
                              <div class="form-group field-wishes ajax-required">
                                  <textarea class="form-control form-control-rect-simple" placeholder="Ваши пожелания" id="wishes" name="wishes" autocomplete="off" data-vtype="notempty" data-message="Не заполнен текст пожелания"></textarea>
                                  <p class="help-block help-block-error help-block-error-white"></p>
                              </div>
                              <div class="form-group">
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

    <div id="popup-video" class="popup-video">
        <div class="cross-close"></div>
        <div class="video-container"></div>
    </div>

      <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=default,fetch"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="/resources/scripts/design/rosetta/vendor.js"></script>
      <script src="/resources/scripts/design/rosetta/main.js?v=0.1.3"></script>

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


          <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter36300185 = new Ya.Metrika({
                            id:36300185,
                            clickmap:true,
                            trackLinks:true,
                            accurateTrackBounce:true,
                            webvisor:true
                        });
                    } catch(e) { }
                });

                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = "https://mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/36300185" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
        <script type="text/javascript">
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-82145819-1', 'auto');
          ga('send', 'pageview');
        </script>
      {/literal}

  </body>
</html>