<?
class SMS_Sender_mail extends SMS_Sender_Base
{
	public function Send($pnumber, $message)
	{
		LibFactory::GetStatic('mailsender');
		
		$message = substr($message, 0, 160);
		
		$subj = str_replace('{number}', $pnumber, $this->_params['subject']);
		$email = str_replace('{number}', $pnumber, $this->_params['mail']);
		if (isset($this->_params['codetable']) && $this->_params['codetable'] != "windows-1251")
			$message = iconv("windows-1251", $this->_params['codetable'], $message);
		$header.= "Content-type: text/plain; charset=".$this->_params['codetable'].";\n";
		
		// для отладки
		//$message = 'To: '.$email."\n".$message;
		//$email = 'axis@info74.ru';
		
		$mail = new MailSender();

		$mail->AddAddress('to', $email);
		$mail->AddAddress('from', $this->_params['from']);
		if(!empty($subj))
			$mail->AddHeader('Subject', $subj,  true);
		if(isset($this->_params['codetable']))
			$mail->AddBody('html', $message, MailSender::BT_PLAIN, $this->_params['codetable']);
		else
			$mail->AddBody('html', $message, MailSender::BT_PLAIN);
		$mail->body_type = MailSender::BT_PLAIN;
		return $mail->Send();
	}
}
?>