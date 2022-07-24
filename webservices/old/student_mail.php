<?php
$fromc=$CompanyEmail;
$toc=$sqlUser['emailid'];
$fname=$sqlUser['first_name']." ".$sqlUser['middle_name']." ".$sqlUser['last_name'];
$sendername= $sqlUser1['business_name'];
$subjectc="Email From $sendername";

$messagec='<body style="width:100%; float:left; padding:0; margin:0; font-family:arial">

<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">

	<tr><td colspan="3"  align="center"><a href="#" target="_blank" style="color: #000;font-weight: normal;text-decoration: underline; font-size:12px; background:#fff; padding:6px 0; width:100%; float:left">View this email in your browser</a></td></tr>
  <tr>
    <td colspan="3"  valign="top" align="center">
	<table  width="680" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="font-family:arial; border: 1px solid #ddd; margin:20px 0">
	
	<tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="3"  valign="top" align="center"><a href="https://www.zumily.com/"  target="_blank" ><img src="https://www.zumily.com/images/logo2.png" style="width:200px"></a></td>
        </tr>
		<tr><td colspan="3" ><hr style="border-color:#eee;"></td></tr>
		<tr><td colspan="3"  valign="top" align="center"><h3 style="font-size:17px; margin-bottom:10px"><strong>CONNECTING YOU TO BUSINESSES, SCHOOLS, & ORGANIZATIONS</strong></h3></td></tr>
		<tr>
<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:inherit; padding-top:10px;"><strong>Dear '.$fname.',</strong><br /></td>
</tr>		
<tr>
			<td colspan="3"  valign="top" align="left">
			<br>
			<p style="padding:0 20px; font-size:14px; line-height:20px;">You are receiving this email from Zumily.com because  '.$sendername.' has added you in their contact lists. To view all the message, fliers, & events, you need to sign-up on zumily.com or down our app.
			</p>
		
			 
			<p style="font-size:14px; line-height:20px;padding:0 20px;"> <br><a href="https://www.zumily.com/register-user?hash='.$emailid.'&userid='.$_SESSION['login_id'].'&messageid='.$insertId.'">Click here</a> to sign-up and get connected with the schools, organizations, and your neighborhood businesses. </p>
			
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
		<li style="width:auto; display:inline-block;"><a href="#" style="width:100%; float:left; color:#333;font-size:12px; text-decoration:none">Privacy Policy |</a></li>
		<li style="width:auto; display:inline-block;"><a href="#" style="width:100%; float:left; color:#333;font-size:12px; text-decoration:none">Term & Services |</a></li>
		<li style="width:auto; display:inline-block;"><a href="#" style="width:100%; float:left; color:#333;font-size:12px; text-decoration:none"> FAQ</a></li></ul>
		
		
		</td></tr>
		<tr><td colspan="3" valign="top" align="center">
		<p style="font-size:11px;color:#333">19504 Kilfinan St, Porter Ranch, CA 91326 <br>&copy; 2018 Zumily.com. All Rights Reserved</p>
		
		</td></tr>
      </table></td>
  </tr>
</table></body>';


?>