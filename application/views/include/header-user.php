<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Connecting your Schools with your Students, Parents, & Teachers in realtime!</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/logo3.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>/css/font-awesome.min.css">
    <link href="<?php echo base_url()."assets/"; ?>css/materialize.css" rel="stylesheet">
    <link href="<?php echo base_url()."assets/"; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url()."assets/"; ?>css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()."assets/"; ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()."assets/"; ?>css/responsive.css" rel="stylesheet"> 
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="<?php echo base_url()."assets/"; ?>/js/jstz-1.0.4.min.js"></script>
    <script>
    
    function showLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude; 
    var timezone = jstz.determine().name();  
    $.ajax({
    type:'POST',
    url:'https://localhost/project/zumilyschool/getlocation.php',
    data:'latitude='+latitude+'&longitude='+longitude+'&timezone='+timezone,
    success:function(msg){
     //alert(msg);
            if(msg){
       window.location.reload();
               }else{
                $("#location").html('Not Available');
            }
    }
    });
    }
    </script> 
    <script> 
    $(document).ready(function() {  
    var d = new Date();  
     var fullYear =  d.getFullYear();
     var fullMonth =  d.getMonth() + 1;
     var fullDate =  d.getDate();
     var date1 = fullYear+"-"+fullMonth+"-"+fullDate; 
    var pass_data = { 'rightNow' : date1,};
    	$.ajax({
    url : "checkDate.php",
    type : "POST",
    data : pass_data,
    success : function(data) { 
    }
    });
    });
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-1261417894699300",
          enable_page_level_ads: true
     });
</script>
</head>
<body>
<!--PRE LOADING-->

<section>
<div class="v3-top-menu">
    <div class="container">
        <div class="row">
            <div class="v3-menu">
                <div class="v3-m-1">
                 <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/zumily-logo-new.png" alt=""> </a>
                </div> 
                <div class="v3-top-ri">
                    
                </div>
            </div> 
        </div>
    </div>
</div>
</section>
<section>
		<div class="v3-mob-top-menu">
			<div class="container">
				<div class="row">
					<div class="v3-mob-menu">
						<div class="v3-mob-m-1">
							<a href="<?php echo base_url(); ?>"><img src="images/logo2.png" alt=""> </a>
						</div> 
							<div class="v3-top-ri" style="margin-top:5px;margin-right:5px;">
								 
							</div> 
					</div>
				</div>
			</div>
		</div>
		<div class="mob-right-nav" data-wow-duration="0.5s"> 
		</div>
	</section>
 



 