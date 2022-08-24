<?php

class SMS
{

    public function __construct()
    {
    }

    public function Send($to, $message, $login, $passw)
    {
        $login = 'marina';       // логин в системе
        $passw = 'rosetta';    // пароль
        $fl = 's';
        $to = $this->preparePhone($to);
        echo "1".$message."<br>";
        $message = iconv("UTF-8", "windows-1251", $message);
        // echo "2".$message; exit;
// echo "http://gatesms.ru/sender.php?lg=".$login."&pw=".$passw."&fl=".urlencode($fl)."&to=".urlencode($to)."&mg=".urlencode($message)."&char=utf8";
// exit;
        $cs = array('www2.gatesms.ru', 'gatesms.ru');
        for($s=0; $s < 2; $s++)  {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, "http://" . $cs[$s] . "/sender.php?lg=".$login."&pw=".$passw."&fl=".urlencode($fl)."&to=".urlencode($to)."&mg=".urlencode($message))."&char=utf8";
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
    
            if (curl_errno($ch)) { 
                error_log(curl_error($ch)); 
            }
            curl_close($ch);

            if(preg_match("/^OK: (\d+)/", $result, $m)) {
                echo "Сообщение отправлено успешно ID: $m[1].";   // отладочный вывод информации на экран
                return $m[1];
            } else
                if (preg_match("/^ERROR: (\d+)/", $result, $m)) {
                    $ERRORS = array(
                        0 => "Ошибка в параметрах.",
                        1 => "Неверный логин/пароль.",
                        2 => "Ошибка в флаге назначения.",
                        3 => "Ошибка в адресе назначения.",
                        4 => "Баланс ниже необходимого уровня.",
                        5 => "Запрещено."
                    );

                echo "Ошибка № $m[1] - " . $ERRORS[$m[1]];    // отладочный вывод информации на экран
                error_log($ERRORS[$m[1]]);
                // return $ERRORS[$m[1]];
            }
        }

        return false;
        // //return $message; exit;
        // $to = $this->preparePhone($to);

        // if($to === false)
        //     return false;

        // $http_params = [
        //     'lg' => 'марина',
        //     'pw' => 'rosetta',
        //     'fl' => '',
        //     'to' => $phone,
        //     'mg' => $message,
        // ];

        // $server_answer = $this->GetPageByUrl($headers, $http_params);
        // error_log("SMS answer: ".$server_answer);
        // return $server_answer;
    }

    private function preparePhone($phone)
    {
        if(mb_strlen($phone) == 0)
            return false;

        $phone = preg_replace("@[^0-9]@", "", $phone);
        $phone = preg_replace("@^8(\d+)$@", "7$1", $phone);

        if (mb_strlen($phone) != 11)
            return false;

        return $phone;
    }

    private function GetPageByUrl($headers, $post_body)
    {
        $ch = curl_init();
        // http://gatesms.ru/sender.php?lg=LOGIN&pw=PASSWORD&fl=FLAG&to=TO&mg=TEXT
        //curl_setopt($ch, CURLOPT_URL, 'http://xml4.easy-sms.ru/requests/sendsms.php'); // урл страницы
        curl_setopt($ch, CURLOPT_URL, 'http://gatesms.ru/sender.php'); // урл страницы
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); //  завершать при ошибке > 300
        //curl_setopt($ch, CURLOPT_COOKIE, 1); // пишем куки

        curl_setopt($ch, CURLOPT_VERBOSE, 0); // показывать подробную инфу
        //curl_setopt($ch, CURLOPT_MUTE, 0); // показывать подробную инфу

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // отправить заголовки из массива $headers
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // вернуть результат запроса в переменную

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body); // передаём post-данные

        $result = @curl_exec($ch); // получить результат в переменную
        curl_close($ch);
        return $result;
    }

}
