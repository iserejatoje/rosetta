<?

global $OBJECTS;



if ( ($err = UserError::GetErrorByIndex('global')) != '' ) {?>

    <div style="margin: 150px 0px; text-align: center; font-size: 24px;"><b>

    <?=$err?>

    </b></div>

    <? if($vars['add_script']) { ?>

        <!— Google Code for Розетта - оплата покупки Conversion Page —>

        <script type="text/javascript">

        /* <![CDATA[ */

        var google_conversion_id = 877043433;

        var google_conversion_language = "en";

        var google_conversion_format = "3";

        var google_conversion_color = "ffffff";

        var google_conversion_label = "rVreCIGa6WgQ6b2aogM";

        var google_remarketing_only = false;

        /* ]]> */

        </script>

        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

        </script>

        <noscript>

        <div style="display:inline;">

        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/877043433/.."/>

        </div>

        </noscript>

    <? } ?>

<? } ?>



