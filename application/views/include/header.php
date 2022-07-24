<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Connecting your Schools with your Students, Parents, & Teachers in realtime!</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/logo3.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
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
        
        
        
        var d = new Date();  
        var fullYear =  d.getFullYear();
        var fullMonth =  d.getMonth() + 1;
        if(fullMonth < 10)
        {
            fullMonth =  "0"+fullMonth;
        }
        var fullDate =  d.getDate();
        
        if(fullDate < 10)
        {
            fullDate =  "0"+fullDate;
        }
        var date1 = fullYear+"-"+fullMonth+"-"+fullDate; 
        
        var time = new Date();  
        var hour =  time.getHours(); 
        var minute =  time.getMinutes(); 
        var second =  time.getSeconds(); 
        if(minute < 10)
        {
            minute = "0"+minute;
        }
        if(second < 10)
        {
            second = "0"+second;
        }
        var date2 = hour+" "+minute;  
        var minutes = time.getMinutes();   
        var dayOfWeek = time.getDay();  
        var current_date_time = date1+" "+hour+":"+minute+":"+second;  
        
        var pass_data = { 'current_date' : date1,'current_time' : date2,'current_date_time' : current_date_time,'day_of_month' : fullDate,'minutes' : minutes,'dayOfWeek' : dayOfWeek};
    	$.ajax({
        	url : "<?php echo base_url(); ?>/set-currentdate",
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

<?php   
if($this->input->cookie('school_id',true))
{
    ?>
    <script language="javascript">
    window.location.href="<?php echo base_url(); ?>dashboard";
    </script>
    <?php
}
?>
<body>
<!--PRE LOADING--> 


    <section class="bottomMenu dir-il-top-fix" id="header">
        <div class="container top-search-main">
            <div class="row">
                <div class="ts-menu">
                    <!-- logo  -->
                    <div class="ts-menu-2">
                        <a href="<?php echo base_url(); ?>dashboard" class="t-bb"><img src="<?php echo base_url(); ?>assets/images/zumily-logo-new.png" style="width:80%;"></a>
                      
                    </div>  
                    <div class="ts-menu-3 pull-right mr-l-none login-listing" style="width:18%;padding-top:0px;" >
                        <div class="v3-top-ri">
							<ul>
								<li><a href="<?php echo base_url(); ?>/signup"  ><i class="fa fa-sign-in"></i> Sign Up</a> </li>
								<li><a href="<?php echo base_url(); ?>login"  ><i class="fa fa-plus" aria-hidden="true"></i> Log in</a> </li>
							</ul>
						</div> 
                    </div>
                  
                
                    <!--MOBILE MENU ICON:IT'S ONLY SHOW ON MOBILE & TABLET VIEW-->
                    <div class="ts-menu-5"><span><i class="fa fa-bars" aria-hidden="true"></i></span> </div>
                    <!--MOBILE MENU CONTAINER:IT'S ONLY SHOW ON MOBILE & TABLET VIEW-->					
                </div>
            </div>
        </div>
    </section>

 


 