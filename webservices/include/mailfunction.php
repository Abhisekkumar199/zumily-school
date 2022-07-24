<?php
	function send_mail($to, $subject, $message, $headers1, $eMail,$filename)
	{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	if($filename!="")
	{
		$uid = md5(uniqid(time()));

		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n";
	}
	else
	{
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	}	
	
// Additional headers
	//$headers .= 'To: mail <'.$to.'>';
	$headers .= 'From: <'.$eMail.'>';
	mail($to, $subject, $message, $headers);	
}

?>