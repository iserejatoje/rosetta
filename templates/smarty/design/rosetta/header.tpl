<!DOCTYPE html>
    <html lang="ru">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
            <link rel="shortcut icon" href="/resources/favicon.png" type="image/x-icon">
            <link rel="shortcut icon" href="/resources/favicon.png" type="image/x-icon">
            <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
            <!-- <title>Hello Rosetta World!</title> -->

            {php}
                App::$Title->AddStyle('/resources/styles/design/rosetta/nice-select.css?v=0.0.2');
                App::$Title->AddStyle('/resources/styles/design/rosetta/vendor.css?v=0.0.2');
                App::$Title->AddStyle('/resources/styles/design/rosetta/combined.css?v=0.1.16');
                App::$Title->AddStyle('/templates/stpl/default/freelance.css');
            {/php}

            {$TITLE->Head}

            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

            {literal}

                <!-- Rating Mail.ru counter -->
                <script type="text/javascript">
                    var _tmr = window._tmr || (window._tmr = []);
                    _tmr.push({id: "3246457", type: "pageView", start: (new Date()).getTime(), pid: "USER_ID"});
                    (function (d, w, id) {
                        if (d.getElementById(id)) return;
                        var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
                        ts.src = "https://top-fwz1.mail.ru/js/code.js";
                        var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
                        if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
                    })(document, window, "topmailru-code");
                </script><noscript><div>
                    <img src="https://top-fwz1.mail.ru/counter?id=3246457;js=na" style="border:0;position:absolute;left:-
9999px;" alt="Top.Mail.Ru" />
                </div></noscript>
                <!-- //Rating Mail.ru counter -->
                <!-- Rating@Mail.ru counter dynamic remarketing appendix -->
                <script type="text/javascript">
                    var _tmr = _tmr || [];
                    _tmr.push({
                        type: 'itemView',
                        productid: 'VALUE',
                        pagetype: 'VALUE',
                        list: 'VALUE',
                        totalvalue: 'VALUE'
                    });
                </script>
                <!-- // Rating@Mail.ru counter dynamic remarketing appendix -->




                <!-- Yandex.Metrika counter -->
                <script type="text/javascript" >
                    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
                    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                    ym(36300185, "init", {
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                </script>
                <noscript><div><img src="https://mc.yandex.ru/watch/36300185" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                <!-- /Yandex.Metrika counter -->

                <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id=UA-167948321-1"></script>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());

                    gtag('config', 'UA-167948321-1');
                </script>

                <!-- Google Analytics -->
                <script type="text/javascript">
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                    ga('create', 'UA-82145819-1', 'auto');
                    ga('send', 'pageview');
                </script>
                <!-- /Google Analytics -->


            {/literal}


        </head>
        <body>

            <header id="header">
                <div class="container">
                    <div class="btn-hamburger" data-control="menu-open">
                        <div class="hamburger-lines">
                            <div class="hamburger-line"></div>
                            <div class="hamburger-line"></div>
                            <div class="hamburger-line"></div>
                        </div>
                    </div>
                    <a href="/" class="logo">
                        <img src="/resources/img/design/rosetta/logo.png" class="img-responsive logo-img" alt="rosetta">
                        <img src="/resources/img/design/rosetta/logo-small.png" class="img-responsive logo-img-small" alt="rosetta">
                    </a>
                    <a href="https://wedding.rosetta.florist/" class="btn-attention">
                        {literal}
                        <span class="btn-attention__img">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="212" height="44" viewBox="0 0 212 44">
                            <defs>
                                <style>
                                    .cls-1 {
                                    font-size: 24px;
                                    fill: #fff;
                                    text-anchor: middle;
                                    font-family: "Palatino Linotype";
                                    }
                                </style>
                                </defs>
                                <image width="42" height="44" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACoAAAAsCAQAAAC5k+LNAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAHdElNRQfjBQ0OFyhcJpVHAAAEf0lEQVRIx52XWWwXVRSHvw4UaBEKyCJYKJViKNIGEAQVow+4wIsgicb4oKJCSIgPBIm8qJEAD2gQTVDBiEtVEAwKiYaiBLCgEHZCDS2yGvZChVJZ2n4+dPrvf/pf2nDuy5zfPffLzJwz595B0o4J7rPK85aY53QPecnjLrRb+lXpkc95zSY7ZrOts+PtQnt7yFT2YjpoQGobxtCUc0PSrEsLreVGyrmM24VWcDDl3L500FTvZYr54mTrk77Rb8008Fn7tz1Rj7jaBlebLc7wdAtgnZ+YJT6jnnSWnVuHdnJhWEaV5ot4r9/EIcudEkYuDpUNDk8PzXWTqsd9zW4GMX221aqusU9My3SiG1Q907LA4p3B7lJ1ZXiP8WO8Vf7gHS3UwOlWqTo3OTTfg2qD76RI3WC7JtWLw0/kjURod39VG5zTSi/ISKINcqda49NNSoYAmXzMK8AcFgGFtKec+ljVdWEg+QwioJhsblDBKfazJ/J9bSSXf3iCv5rrdKJ1akmYmjetcberXOB8v3etBzyfUKmX/NHxcXc7yXq1pPnxO/m7etwBYcAYd3g2AXPV7ywJ09Jkb8VhP1RrfbIJ+qqqU+PeW2f7OtMbEcBvIo7yeER9O1Z4fT2qlhoIZvqzut/shATsjCwvDdXpEbXaEbH4+epNx0rAWB4D1lGb0Bb+S9qXtnM9Ts2hOHb9NVfI5CUIuJ8satjQ5g52iVMRPyd2VUkZMIqcgFFARSutLN7uIj/iX4td1bMNGEBewDigkpo2Q0fSPs6rYm+ct4vr9KJPQBdgVxtgtwDoy+sR9bPIR3CdemBge+pjC9JbAXPJYhLD4hCfMy8Sc47LdOaexkfJaAN0MAvivE2UsoU/W8Qc5QK51DVmuK4N0L28zImY15dL7E+IyaUH0C6gHZDbBuhZvmAKZ0KvkGWUUZAA7QmcDjgCafb3ZssEdrMEY8pI1lMUicmhA1AZcALIiyvh9LaCi3HeEL6iV5z/IJn8y4WAUmAwY5IAjHgNAJxnZUQdzirGkgV0ZjLTgHIOY5FX1PeTdPQ/Iq1je9hyxiU0xVo3u9wyb6r6nmDgGvWId7ZAFnolsrTGMeEmvtbUVuOwxn76lLfU2ZGdaIDrEhastZ+I93kxJfTL5o3vJ/WiRSHyITe26PBNds719hYfT7LBqF6xuBn6gNXqL2aLHVyr1ltttZVucatb3ezfVocHisYd/lF32RCDVXhYmzOTEaZ4NouAD5hFNtM4y2mOkEkVV8MsdyMHKKIXWSwFIJuJjKYjGezkFovpxw4mcDmsGxE7WKLqkqQ7e/pRaKV6pvHRoyeU3m5RdUWyc1yaMdlTao0PJz9L9XC9qmVh8bQ++rjUOvWEzyc/SyF29VMb1Bo/sqAVYHdnWKHqAQujc4nBL4Q/Nxdc7mTzkuC6Osy5Yb6vu8zeLSMyTPzm+zOTqfQE4CR7OEYlFwiQdhSQRxHFZAFQxjxKk3aNpCPfd92X4sSvesp1Tkr1i5bsTpusKyMZzQiGcndMu0k55WxjD0dSL/wfkZAV/lE/gxUAAAAASUVORK5CYII="/>
                                <text class="cls-1" x="139.896" y="29.252">Все к свадьбе</text>
                            </svg>
                        </span>
                        {/literal}
                        <span class="btn-attention__text">Все к свадьбе</span>
                    </a>

                    {if $BLOCKS.header.phone}
                        {$BLOCKS.header.phone}
                    {/if}

                    <div class="social social-header with-border clearfix">
                        <a href="https://vk.com/rosetta_florist" target="_blank" class="social-item item-vk"></a>
                        <a href="https://www.youtube.com/channel/UCO9av2dtuKY6NiZWTwI2uaQ" target="_blank" class="social-item item-yt"></a>
                    </div>

                    {if $BLOCKS.header.cart}
                        {$BLOCKS.header.cart}
                    {/if}
                </div>
            </header>

            <div class="wrap">

                <div id="content">
