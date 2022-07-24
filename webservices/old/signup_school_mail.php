<?php
//$rowuser=mysqli_fetch_array(mysqli_query($conn,"select * from user_registration where UID='".$uid."'"));
//start mail to customer 
$fromc=$CompanyEmail;
$toc=$emailid;
$fname=$username;
$subjectc="New Account - E-Mail verification link";
$messagec='<body style="width:100%; float:left; padding:0; margin:0; font-family:arial">

<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">

 
  <tr>
    <td colspan="3"  valign="top" align="center">
	<table  width="680" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="font-family:arial; border: 1px solid #ddd; margin:20px 0">
	
	<tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="3"  valign="top" align="center"><a href="https://www.zumily.com/"  target="_blank" ><img src="https://www.zumily.com/images/logo2.png" style="width:200px"></a></td>
        </tr>
		<tr><td colspan="3" ><hr style="border-color:#eee;"></td></tr>
		<tr><td colspan="3"  valign="top" align="center"><h3 style="font-size:17px; margin-bottom:10px"><strong>COMMUNICATE WITH STUDENTS & PARENTS</strong></h3></td></tr>
		<tr>
<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:inherit; padding-top:10px;">
<p style="padding:0 20px; font-size:14px; line-height:20px;"><strong>Dear '.$fname.',</strong></p></td>
</tr>		
<tr>
			<td colspan="3"  valign="top" align="left">
		 
			<p style="padding:0 20px; font-size:14px; line-height:20px;">Congratulations and thank you for joining the Zumily community!<br><br>

			Now, you can start listing your fliers, events, program reminders, and messages to be delivered to students and parents. They can see them on zumily.com or on the app if they have downloaded it.<br><br>

			Please DO remind your students and parents to download the zumily app and favorite the school to see all school fliers and reminders.
			</p>
		
			<h3 style="padding:0 20px; margin-bottom:0"><strong>Benefits:</strong></h3>
			<ul style="font-size:14px; line-height:20px; margin-top:0">
				<li>Publish fliers as often or as little as you like.</li>
				<li>Totally paperless and delivered to users as you create them. No wait!</li>
				<li>You decide when your fliers start and end.</li>
				<li>No emails or mailing lists to worry about!</li>
				<li>And, to serve my community, your account is absolutely FREE for life.</li> 
			</ul>
		
			<p style="font-size:14px; line-height:20px;padding:0 20px;">We do not want anyone to misuse your email so please click on the link below to verify that you have signed up for our services.<br><a href="https://www.zumily.com/merchant_account_verify.php?hash='.$hash.'">https://www.zumily.com/merchant_account_verify.php?hash='.$hash.'</a></p>
			<p style="font-size:14px; line-height:20px;padding:0 20px;">If you have any questions, feel free to contact us at <a href="#">help@zumily.com</a> or visit the live chat on our website.</p>
			<p style="line-height:20px;padding:0 20px;">Thank you,<br>
			Zumily Team
			</p>
			</td>
		</tr>
		<tr><td colspan="3" ><hr style="border-color:#eee;"></td></tr>
		<tr><td valign="top" align="center">
		<h4 style="margin-bottom:10px">Download our free app</h4>
		<a href="#"><img src="https://www.zumily.com/images/android.png" alt="" style="width:100px"> </a>
		<a href="#"><img src="https://www.zumily.com/images/apple.png" alt="" style="width:100px"> </a>
		
		</td>
		<td valign="top" align="left" style="width:200px">&nbsp;</td>
		<td  valign="top" align="center">
		<h4 style="margin-bottom:10px">Follow with us</h4>
		
		<a href=""><img src="https://www.zumily.com/images/icon/facebook-icon.png" style="width:20px"></a>
		<a href=""><img src="https://www.zumily.com/images/icon/google-icon.png" style="width:20px"></a>
		<a href=""><img src="https://www.zumily.com/images/icon/link-icon.png" style="width:20px"></a>
		<a href=""><img src="https://www.zumily.com/images/icon/twitter-icon.png" style="width:20px"></a>
		<a href=""><img src="https://www.zumily.com/images/icon/youtube-icon.png" style="width:20px"></a>
		<a href=""><img src="https://www.zumily.com/images/icon/whatsapp-icon.png" style="width:20px"></a>
		<p>&nbsp;</p></td>
		
		</tr>
		
		<tr><td colspan="3" valign="top" align="center">
		<ul style="padding:0; display:block; margin:0;">
		<li style="width:auto; display:inline-block;"><a href="https://www.zumily.com/privacy-policy" style="width:100%; float:left; color:#5f88ff;font-size:12px; text-decoration:none">Privacy Policy |</a></li>
		<li style="width:auto; display:inline-block;"><a href="https://www.zumily.com/terms-services" style="width:100%; float:left; color:#5f88ff;font-size:12px; text-decoration:none">Term & Services |</a></li>
		<li style="width:auto; display:inline-block;"><a href="https://www.zumily.com/faq" style="width:100%; float:left; color:#5f88ff;font-size:12px; text-decoration:none"> FAQ</a></li></ul>
		
		
		</td></tr>
		<tr><td colspan="3" valign="top" align="center">
		<p style="font-size:11px;color:#333">19504 Kilfinan St, Porter Ranch, CA 91326 <br>&copy; 2018 Zumily.com. All Rights Reserved</p>
		
		</td></tr>
      </table></td>
  </tr>
</table></body>';
?>