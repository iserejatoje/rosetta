<style>

  #outlook a {
    padding:0;
  }

  body {
    width:100% !important;
    min-width: 100%;
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%;
    margin:0;
    padding:0;
  }

  .ExternalClass {
    width:100%;
  }

  .ExternalClass,
  .ExternalClass p,
  .ExternalClass span,
  .ExternalClass font,
  .ExternalClass td,
  .ExternalClass div {
    line-height: 100%;
  }

  #backgroundTable {
    margin:0;
    padding:0;
    width:100% !important;
    line-height: 100% !important;
  }

  img {
    outline:none;
    text-decoration:none;
    -ms-interpolation-mode: bicubic;
    width: auto;
    max-width: 100%;
    float: left;
    clear: both;
    display: block;
  }

  center {
    width: 100%;
    min-width: 949px;
  }

  a img {
    border: none;
  }

  p {
    margin: 0 0 0 10px;
  }

  table {
    border-spacing: 0;
    border-collapse: collapse;
  }

  td {
    word-break: break-word;
    -webkit-hyphens: auto;
    -moz-hyphens: auto;
    hyphens: auto;
    border-collapse: collapse !important;
  }

  table, tr, td {
    padding: 0;
    vertical-align: top;
    text-align: left;
  }

  hr {
    color: #d9d9d9;
    background-color: #d9d9d9;
    height: 1px;
    border: none;
  }

  /* Responsive Grid */

  table.body {
    height: 100%;
    width: 100%;
    background: #343434;
  }

  table.container {
    width: 949px;
    margin: 0 auto;
    text-align: inherit;
  }

  table.row {
    padding: 0px;
    width: 100%;
    position: relative;
  }

  table.container table.row {
    display: block;
  }

  td.wrapper {
    padding: 10px 20px 0px 0px;
    position: relative;
  }

  table.columns,
  table.column {
    margin: 0 auto;
  }

  table.columns td,
  table.column td {
    padding: 0px 0px 10px;
  }

  table.columns td.sub-columns,
  table.column td.sub-columns,
  table.columns td.sub-column,
  table.column td.sub-column {
    padding-right: 10px;
  }

  td.sub-column, td.sub-columns {
    min-width: 0px;
  }

  table.row td.last,
  table.container td.last {
    padding-right: 0px;
  }

  table.one { width: 30px; }
  table.two { width: 80px; }
  table.three { width: 130px; }
  table.four { width: 180px; }
  table.five { width: 230px; }
  table.six { width: 280px; }
  table.seven { width: 330px; }
  table.eight { width: 380px; }
  table.nine { width: 430px; }
  table.ten { width: 480px; }
  table.eleven { width: 530px; }
  table.twelve { width: 949px; }

  table.one center { min-width: 30px; }
  table.two center { min-width: 80px; }
  table.three center { min-width: 130px; }
  table.four center { min-width: 180px; }
  table.five center { min-width: 230px; }
  table.six center { min-width: 280px; }
  table.seven center { min-width: 330px; }
  table.eight center { min-width: 380px; }
  table.nine center { min-width: 430px; }
  table.ten center { min-width: 480px; }
  table.eleven center { min-width: 530px; }
  table.twelve center { min-width: 949px; }

  table.one .panel center { min-width: 10px; }
  table.two .panel center { min-width: 60px; }
  table.three .panel center { min-width: 110px; }
  table.four .panel center { min-width: 160px; }
  table.five .panel center { min-width: 210px; }
  table.six .panel center { min-width: 260px; }
  table.seven .panel center { min-width: 310px; }
  table.eight .panel center { min-width: 360px; }
  table.nine .panel center { min-width: 410px; }
  table.ten .panel center { min-width: 460px; }
  table.eleven .panel center { min-width: 510px; }
  table.twelve .panel center { min-width: 560px; }

  .body .columns td.one,
  .body .column td.one { width: 8.333333%; }
  .body .columns td.two,
  .body .column td.two { width: 16.666666%; }
  .body .columns td.three,
  .body .column td.three { width: 25%; }
  .body .columns td.four,
  .body .column td.four { width: 33.333333%; }
  .body .columns td.five,
  .body .column td.five { width: 41.666666%; }
  .body .columns td.six,
  .body .column td.six { width: 50%; }
  .body .columns td.seven,
  .body .column td.seven { width: 58.333333%; }
  .body .columns td.eight,
  .body .column td.eight { width: 66.666666%; }
  .body .columns td.nine,
  .body .column td.nine { width: 75%; }
  .body .columns td.ten,
  .body .column td.ten { width: 83.333333%; }
  .body .columns td.eleven,
  .body .column td.eleven { width: 91.666666%; }
  .body .columns td.twelve,
  .body .column td.twelve { width: 100%; }

  td.offset-by-one { padding-left: 50px; }
  td.offset-by-two { padding-left: 100px; }
  td.offset-by-three { padding-left: 150px; }
  td.offset-by-four { padding-left: 200px; }
  td.offset-by-five { padding-left: 250px; }
  td.offset-by-six { padding-left: 300px; }
  td.offset-by-seven { padding-left: 350px; }
  td.offset-by-eight { padding-left: 400px; }
  td.offset-by-nine { padding-left: 450px; }
  td.offset-by-ten { padding-left: 500px; }
  td.offset-by-eleven { padding-left: 550px; }

  td.expander {
    visibility: hidden;
    width: 0px;
    padding: 0 !important;
  }

  table.columns .text-pad,
  table.column .text-pad {
    padding-left: 10px;
    padding-right: 10px;
  }

  table.columns .left-text-pad,
  table.columns .text-pad-left,
  table.column .left-text-pad,
  table.column .text-pad-left {
    padding-left: 10px;
  }

  table.columns .right-text-pad,
  table.columns .text-pad-right,
  table.column .right-text-pad,
  table.column .text-pad-right {
    padding-right: 10px;
  }

  /* Block Grid */

  .block-grid {
    width: 100%;
    max-width: 949px;
  }

  .block-grid td {
    display: inline-block;
    padding:10px;
  }

  .two-up td {
    width:270px;
  }

  .three-up td {
    width:173px;
  }

  .four-up td {
    width:125px;
  }

  .five-up td {
    width:96px;
  }

  .six-up td {
    width:76px;
  }

  .seven-up td {
    width:62px;
  }

  .eight-up td {
    width:52px;
  }

  /* Alignment & Visibility Classes */

  table.center, td.center {
    text-align: center;
  }

  h1.center,
  h2.center,
  h3.center,
  h4.center,
  h5.center,
  h6.center {
    text-align: center;
  }

  span.center {
    display: block;
    width: 100%;
    text-align: center;
  }

  img.center {
    margin: 0 auto;
    float: none;
  }

  .show-for-small,
  .hide-for-desktop {
    display: none;
  }

  /* Typography */

  body, table.body, h1, h2, h3, h4, h5, h6, p, td {
    color: #222222;
    font-family: "Arial", sans-serif;
    font-weight: normal;
    padding:0;
    margin: 0;
    text-align: left;
    line-height: 1.3;
  }

  h1, h2, h3, h4, h5, h6 {
    word-break: normal;
  }

  h1 {font-size: 40px;}
  h2 {font-size: 36px;}
  h3 {font-size: 32px;}
  h4 {font-size: 28px;}
  h5 {font-size: 24px;}
  h6 {font-size: 20px;}
  body, table.body, p, td {font-size: 14px;line-height:19px;}

  p.lead, p.lede, p.leed {
    font-size: 18px;
    line-height:21px;
  }

  p {
    margin-bottom: 10px;
  }

  small {
    font-size: 10px;
  }

  a {
    color: #2ba6cb;
    text-decoration: none;
  }

  a:hover {
    color: #2795b6 !important;
  }

  a:active {
    color: #2795b6 !important;
  }

  a:visited {
    color: #2ba6cb !important;
  }

  h1 a,
  h2 a,
  h3 a,
  h4 a,
  h5 a,
  h6 a {
    color: #2ba6cb;
  }

  h1 a:active,
  h2 a:active,
  h3 a:active,
  h4 a:active,
  h5 a:active,
  h6 a:active {
    color: #2ba6cb !important;
  }

  h1 a:visited,
  h2 a:visited,
  h3 a:visited,
  h4 a:visited,
  h5 a:visited,
  h6 a:visited {
    color: #2ba6cb !important;
  }

  /* Outlook First */

  body.outlook p {
    display: inline !important;
  }
  </style>
  <style>

    .template-label {
      color: #ffffff;
      font-weight: bold;
      font-size: 11px;
    }

    .header-label {
      color: #b3b3b3;
      font-size: 18px;
    }

    .callout .wrapper {
      padding-bottom: 20px;
    }

    .callout .panel {
      background: #ECF8FF;
      border-color: #b9e5ff;
    }

    .header {
      background: #343434;
    }

    .footer .wrapper {
      background: #ebebeb;
    }

    .footer h5 {
      padding-bottom: 10px;
    }

    table.columns .text-pad {
      padding-left: 10px;
      padding-right: 10px;
    }

    table.columns .left-text-pad {
      padding-left: 10px;
    }

    table.columns .right-text-pad {
      padding-right: 10px;
    }

    .code {
      font-size: 18px;
      color: #fff;
      background: #e73a62;
      padding: 20px 25px 17px;
      display: inline-block;
      text-transform: uppercase;
    }

  </style>

  <style>
    table.columns .body-title {
      font-size: 20px;
      color: #e73a62;
      padding: 58px 0 44px 0;
    }

    table.columns .body-paragraph {
      font-size: 14px;
    }

    table.columns .body-paragraph + .body-paragraph {
      padding-top: 20px;
    }

    .link-pink {
      font-size: 14px;
      color: #e73a62;
      text-decoration: underline;
    }

    .link-pink:hover {
      color: #e73a62;
    }

    .text-muted {
      color: #888888;
    }

    .text-muted a {
      color: inherit;
    }

    .text-muted a:hover,
    .text-muted a:visited {
      color: inherit !important;
    }

    .follow-title {
      font-size: 15px;
      color: #fff;
    }

    .follow-footnote {
      color: #898989;
    }

    .follow-footnote a {
      color: inherit !important;
      text-decoration: underline;
    }

    .follow-footnote a:hover,
    .follow-footnote a:visited {
      color: inherit !important;
    }

    .btn-social + .btn-social {
      margin-left: 23px;
    }

    .btn-social img {
      display: inline-block;
      float: none;
    }
  </style>

<table class="body" bgcolor="#363636">
<tr>
  <td class="center" align="center" valign="top">
    <center>

      <table class="row header">
        <tr>
          <td class="center" align="center">
            <center>

              <table class="container">
                <tr>
                  <td class="wrapper last">

                    <table class="twelve columns">
                        <tr>
                            <td height="50px" colspan="2">&nbsp;</td>
                        </tr>

                        <tr>
                            <td width="450px" align="left">
                            <a href="http://<?= $vars['domain'] ?>" target="_blank">
                                <img src="http://<?= $vars['domain'] ?>/resources/img/design/rosetta/mail/logo.png">
                            </a>
                            </td>

                            <td width="450px" align="right" style="text-align: right">
                                <font color="#b3b3b3" size="3">г. Кемерово</font><br/>
                                <font color="#b3b3b3" size="3"><?=$vars['date']?></font>
                            </td>

                            <tr>
                                <td height="50px" colspan="2">&nbsp;</td>
                            </tr>
                            <td class="expander"></td>
                      </tr>
                    </table>

                  </td>
                </tr>
              </table>

            </center>
          </td>
        </tr>
      </table>

      <table class="container" cellspacing="0" cellpadding="0" >
        <tr>
          <td>

            <table class="twelve columns" style="background: #fff;" cellspacing="0" cellpadding="0" >
                <!-- <tr style="height: 6px;">
                    <td style="background: url(http://<?= $vars['domain'] ?>/resources/img/design/rosetta/mail/fence.png) repeat-x; padding: 0;"></td>
                </tr> -->

                <tr>
                  <td>
                    <img src="http://<?= $vars['domain'] ?>/resources/img/design/rosetta/mail/payment1.jpg" alt="">
                  </td>
                </tr>

                <tr style="height: 3px;" bgcolor="#ffffff">
                    <td></td>
                </tr>

              <tr>
                <td style="padding: 0 150px 0 150px;">
                  <table cellspacing="0" cellpadding="0" >
                    <tr>
                        <td height="35px">&nbsp;</td>
                    </tr>

                    <tr>
                      <td class="body-title" colspan="2">
                        <font color="#e73a62" size="3">Уважаемый клиент!</font>
                      </td>
                    </tr>

                    <tr>
                        <td height="35px">&nbsp;</td>
                    </tr>

                    <tr>
                      <td class="body-paragraph">
                        Вы оформили и оплатили заказ №<?= $vars['id'] ?> на сайте <a href="http://<?= $vars['domain'] ?>"><?= $vars['domain'] ?></a>.
                      </td>
                    </tr>

                    <tr>
                      <td class="body-paragraph">
                          В связи с изменениями в данном заказе, которые были согласованы с Вам ранее, просим Вас доплатить сумму в размере <b><?= $vars['sum']?> руб</b>.
                      </td>
                    </tr>

                    <tr>
                        <td height="35px">&nbsp;</td>
                    </tr>

                    <tr>
                      <td>
                         <table cellspacing="0" cellpadding="0" style="border:#000000 1px solid" border="1px" width="100%">
                            <tr>
                                <th align="center" style="border:#000000 1px solid;text-align:center;padding: 5px;">Наименование</th>
                                <th align="center" style="border:#000000 1px solid;text-align:center;padding: 5px;">Кол-во</th>
                                <th align="center" style="border:#000000 1px solid;text-align:center;padding: 5px;">Цена</th>
                                <th align="center" style="border:#000000 1px solid;text-align:center;padding: 5px;">Сумма</th>
                            </tr>

                            <?php $refs = $vars['order']->GetOrderRefs()?>
                            <?php foreach($refs as $item) { ?>
                                <tr>
                                    <td style="border:#000000 1px solid;padding: 3px;"><?= $item['Name']?></td>
                                    <td width="80px" align="center" style="border:#000000 1px solid;padding: 3px; text-align:center"><?= $item['Count']?></td>
                                    <td width="80px" style="border:#000000 1px solid;padding: 3px;"><?= number_format($item['BouquetPrice'], 0, '', '')?> руб.</td>
                                    <td width="100px" style="border:#000000 1px solid;padding: 3px;"><?= number_format($item['Price'], 0, '', '') ?> руб.</td>
                                </tr>
                            <?php }?>
                            <tr>
                                <td colspan="3" style="border:#000000 1px solid;padding: 3px;"><strong>Итого</strong></td>
                                <td style="border:#000000 1px solid;padding: 3px;"><strong><?= $vars['sum']?> руб.</strong></td>
                            </tr>
                         </table>
                      </td>
                    </tr>

                    <tr>
                      <td class="body-paragraph">
                          Благодарим за понимание!
                      </td>
                    </tr>

                    <tr>
                        <td height="12px">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <table cellspacing="0" cellpadding="0" >
                                <tr>
                                    <td>
                                        <a href="http://<?= $vars['domain'] ?>/catalog/payment/<?= $vars['newId'] ?>/">
                                            <img src="http://<?= $vars['domain'] ?>/resources/img/design/rosetta/mail/btn-addpay.png" alt="Доплатить">
                                          </a>

                                        <!-- <a href="<?= App::$Protocol . $vars['domain'] ?>/catalog/payment/<?= $vars['newId'] ?>/" style="background: #e73a62; padding: 8px 30px 10px; color: #fff; text-decoration: none; display: inline-block;">Доплатить</a> -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                      <td class="text-muted" colspan="2" style="padding: 38px 0 0 0;">
                        С уважением, компания "РОЗЕТТА"
                      </td>
                    </tr>

                    <tr>
                      <td class="text-muted" colspan="2" style="padding: 18px 0 0 0;">
                        8-800-500-62-92
                      </td>
                    </tr>

                    <tr>
                      <td class="text-muted" colspan="2" style="padding: 0 0 60px 0;">
                        <a href="http://<?= $vars['domain'] ?>">Rosetta.florist</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <tr style="height: 6px;">
                <td style="background: url(http://<?= $vars['domain'] ?>/resources/img/design/rosetta/mail/fence-invert.png) repeat-x; padding: 0;"></td>
              </tr>
            </table>

            <table class="twelve columns" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td height="15px">&nbsp;</td>
                </tr>

                <tr>
                    <td class="follow-title" align="center">
                        <font color="#ffffff">Следите за нами:</font>
                    </td>
                </tr>

                <tr>
                    <td height="15px">&nbsp;</td>
                </tr>

              <tr>
                <td class="follow-links">
                  <center>
                    <a href="https://vk.com/rosetta_florist" target="_blank" class="btn-social">
                      <img src="http://<?= $vars['domain'] ?>/resources/img/design/rosetta/mail/btn-vk.png">
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="https://www.instagram.com/rosetta_kemerovo/" target="_blank" class="btn-social">
                      <img src="http://<?= $vars['domain'] ?>/resources/img/design/rosetta/mail/btn-inst.png">
                    </a>
                  </center>
                </td>
              </tr>

                <tr>
                    <td height="10px">&nbsp;</td>
                </tr>

              <tr>
                <td class="follow-footnote" style="padding: 10px 0 25px 0; text-align: center;">
                    <font color="#898989">Если у Вас возникли трудности, обратитесь <a href="http://<?= $vars['domain'] ?>" target="_blank">к нам</a></font>
                </td>
              </tr>
            </table>

          <!-- container end below -->
          </td>
        </tr>
      </table>

    </center>
  </td>
</tr>
</table>
