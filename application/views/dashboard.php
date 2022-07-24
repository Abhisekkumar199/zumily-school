 
<script>
var mzOptions = {
    zoomMode: 'off' 
}; 
$(document).ready(function(){ 
    $(document).on("click",".mz-button-close",function() {
         $('.bottomMenu ').css('position','fixed');
    }); 
  
}); 
$(document).ready(function(){ 
    
    
    var end_date = new Date().toDateString("ddd, MMM DD, YYYY"); 
    
    var session_start_year = <?php echo $session_start_year; ?>;
    var session_start_month = <?php echo $session_start_month; ?>;
    var session_start_date = <?php echo $session_start_date; ?>;  
   
    
    if(session_start_month < 10)
    {
       var session_start_month =  "0"+session_start_month;
    }
    
    if(session_start_date < 10)
    {
      var  session_start_date =  "0"+session_start_date;
    }
    var startdate = session_start_year+"-"+session_start_month+"-"+session_start_date+" 00:00"; 
    
    var d = new Date(startdate); 
    var sd = new Date(startdate).toDateString("ddd, MMM DD, YYYY");  
    var ed = end_date; 
    
    $('#attendance_date').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY", 
      minDate:sd,
      maxDate:ed,
      todayBtn: true
    });
    
    $('#filter_start_date').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY", 
      minDate:sd,
      maxDate:ed,
      todayBtn: true
    });  
    $('#filter_end_date').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY", 
      minDate:sd,
      maxDate:ed,
      todayBtn: true
    });
}); 
</script>
    <style>
        .mono-font 
        {
            font-family: monospace;   font-style: normal; font-variant: normal;font-weight: 100;font-size: 11px;
        }
        .tz
        {
                padding: 75px 2px;
        }
        .tz .tz1sidebar 
        { 
            left: 16px!important;
            width: 18%!important;
        }
        .tz-2-com h4 
        {
            margin: 0px;
            background: #253d52;
            padding: 15px;
            color: #fff;
        }
        .tz-2 
        { 
            background: #fff;
        }
        .tz-2-main-admin 
        {
            width: 25%;
        }
        .tz-2-main-2 
        { 
            min-height: 251px;
            max-height: 251px;
                margin: 0px;
                
                padding: 8px!important;
        }
        .tz-2-main-com h2 
        { 
            font-size: 42px;
        }
        .tz-2-main-com span 
        {
            font-size: 20px; 
        }
        
        .tz-2-main-com img 
        { 
            margin-bottom: 12px;
        }
        .inn-title 
        {
            padding: 0px!important;  
        }
        .tz-2-com h4 { 
            background:#151f31!important; 
            text-align: center;
            font-size: 19px;
            padding: 11px;
        }
        .tab-inn 
        {
        padding: 10px;
        }

        .tz-2-main-com img 
        {
            display: block;
            /* width: 80px; */
            margin: 0 auto;
            /* padding-bottom: 20px; */
            border: none!important;
            padding: 0px!important;
            border-radius: 5px;
            margin-bottom: 0px!important;
            width: 50px;
            float: left;
        }
        .tz-2-main-2 
        {
            border: .1em solid #152733; 
         border-width: thin;
        }
        .tz-2-main-1
        { 
            min-height: 168px; 
        }
        .vl {
  border-left: 1px solid green;
  height: 168px;
}
.table-desi i { 
     margin-right: 0px 
}
    </style>
    
<style>
.business_list_dropdown{ display:none;} 
</style>
    	<?php 
    	    $total_students = 0;
    	    $total_presents = 0;
    	    $total_absents = 0;
    	    $total_leaves = 0;
    	    foreach($attendance_list as $attendance) 
    	    {  
    	        $total_students = $total_students + $attendance->total_students;
    	        $total_presents = $total_presents + $attendance->total_presents;
    	        $total_absents = $total_absents + $attendance->total_absents;
    	        $total_leaves = $total_leaves + $attendance->total_leaves; 
    	    } 
    	?>
								
        <div class="sb2-2" style="padding: 5px;">
			<!--== breadcrumbs ==-->
		 
			<div class="tz-2 tz-2-admin">
				<div class="tz-2-com tz-2-main">
					<h4>Dashboard 
                        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
					</h4>
					<div class="tz-2-main-com bot-sp-20">
					    <form method="get" action="<?php echo base_url(); ?>dashboard">
					    <div class="row">
    					    <div class="col-md-3" style="width:21%!important;padding-left: 17px!important;padding-right: 3px!important;"> 
    					        <table class="table " style="margin-bottom: 0px;">
									<thead style="border-bottom:none;">
										<tr>
											<th style="background: #dedede;border: 1px solid #152733;border-bottom: none;"> 
											     <input type="text" class="test " style="background-color: #ffffff;font-size:17px;" name="attendance_date" id="attendance_date" onchange="this.form.submit()"  title="Date"   placeholder="Attendance Date" value="<?php echo date('D, d M , Y',strtotime($current_date)); ?>"   />  
											</th> 
										</tr>
										<tr >
										    <th style="border: 1px solid #152733;border-top: none; ">
										        <div class="rows">
                        							<div class="col-md-3" style="padding-left: 0px;"> 
                        							    <img src="<?php echo base_url(); ?>/assets/icons/event64.png" alt="" />
                        							</div> 
                        							<div class="col-md-9"> 
                        							    <h5 style="margin-top:13px;font-size: 20px;font-weight: 600;margin-bottom:35px;">Attendance</h5>
                    							    </div>    
                        							    <div class="clearfix"></div>
                        							    <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Students: </h5><h5 class="text-primary pull-right" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-right: 35px;"><?php echo $total_students; ?></h5>
                        							     <div class="clearfix"></div> 
                        							    <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Presents: </h5><h5 class="text-success pull-right" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-right: 35px;"><?php echo $total_presents; ?></h5> 
                        							     <div class="clearfix"></div> 
                        							    <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Absents&nbsp;: </h5><h5 class="text-danger pull-right" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-right: 35px;"><?php echo $total_absents; ?></h5> 
                        							    <div class="clearfix"></div>    
                        							    <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Leaves&nbsp;&nbsp;: </h5><h5 class="text-warning pull-right" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-right: 35px;"><?php echo $total_leaves; ?></h5>  
                        							</div>
                        						</div>
										    </th>
										</tr>
									</thead>
								</table>
    					    </div>
    					    <div class="col-md-9" style="width:79%!important;padding-left: 4px!important; padding-right: 18px!important;"> 
    					        <table class="table " style="margin-bottom: 0px;">
									<thead style="border-bottom:none;">
										<tr>
											<th style="background: #dedede;border: 1px solid #152733;border-bottom: none;"> 
											    <div class="row "> 
											        <div class="col-md-3" style="margin-left:56px;">
											            <input type="text" style="background-color: #ffffff;font-size:17px;" class="test " name="filter_start_date" id="filter_start_date"   title="Date"   placeholder="Start Date" value="<?php echo date('D, d M , Y',strtotime($filter_start_date)); ?>"   /> 
											        </div>
											        <div class="col-md-2" style="padding-right: 0px;padding-left: 0px;">
											            <p style="text-align: center;margin-top: 12px;"><strong>To</strong></p>
											        </div>
											        <div class="col-md-3" style="padding-right: 15px;padding-left: 0px;">
											            <input type="text" style="background-color: #ffffff;font-size:17px;" class="test " name="filter_end_date" id="filter_end_date"   title="Date"   placeholder="End Date" value="<?php echo date('D, d M , Y',strtotime($filter_end_date)); ?>"   /> 
											        </div>
											        <div class="col-md-2">
											            <button type="submit" style="  margin: 7px;" class="btn btn-success height-36 "  >Search</button>
										            </div>
										        </div>  
											</th> 
										</tr>
										<tr>
										     <th style="border: 1px solid #152733;border-top: none;">
									            <div class="tz-2-main-1 tz-2-main-admin">
                        							<div class="rows" style="border-right: none;"> 
                        							    <div class="col-md-5" style="padding-left: 33px;min-height: 80px;"> 
                        							        <img src="<?php echo base_url(); ?>/assets/icons/message64kb.png" alt="">
                            							</div> 
                            							<div class="col-md-7" style="min-height: 80px;"> 
                            							    <a href="<?php echo base_url(); ?>messages-list"><h5 style="margin-top:9px;font-size: 20px;font-weight: 600;margin-bottom:35px;text-align: left;">Messages</h5></a>
                        							    </div>    
                        								<h2><?php echo count($message_list); ?></h2>  
                    								</div>
                    								
                        						</div>
                        						<div class="tz-2-main-1 tz-2-main-admin">
                        						    <div class="rows" style="border-right: none;"> 
                        							    <div class="col-md-5" style="padding-left: 33px;min-height: 80px;"> 
                        							        <img src="<?php echo base_url(); ?>/assets/icons/event64.png" alt="">
                            							</div> 
                            							<div class="col-md-7" style="min-height: 80px;"> 
                            							    <a href="<?php echo base_url(); ?>events-list"><h5 style="margin-top:9px;font-size: 20px;font-weight: 600;margin-bottom:35px;text-align: left;">Events</h5></a>
                        							    </div>    
                        								<h2><?php echo count($event_list); ?></h2>  
                    								</div> 
                        						</div>
                        						<div class="tz-2-main-1 tz-2-main-admin">
                        						    <div class="rows" style="border-right: none;"> 
                        							    <div class="col-md-5" style="padding-left: 33px;min-height: 80px;"> 
                        							        <img src="<?php echo base_url(); ?>/assets/icons/event64.png" alt="">
                            							</div> 
                            							<div class="col-md-7" style="min-height: 80px;"> 
                            							    <a href="<?php echo base_url(); ?>leave-request-list"><h5 style="margin-top:3px;font-size: 20px;font-weight: 600;margin-bottom:35px;text-align: left;">Leave Requests</h5></a>
                        							    </div>    
                        								<h2><?php echo count($leave_request_list); ?></h2> 
                    								</div>  
                        						</div>
                        						<div class="tz-2-main-1 tz-2-main-admin">
                        						    <div class="rows"> 
                        							    <div class="col-md-5" style="padding-left: 33px;min-height: 80px;"> 
                        							        <img src="<?php echo base_url(); ?>/assets/icons/event64.png" alt="">
                            							</div> 
                            							<div class="col-md-7" style="min-height: 80px;"> 
                            							    <a href="<?php echo base_url(); ?>holidays-list"><h5 style="margin-top:9px;font-size: 20px;font-weight: 600;margin-bottom:35px;text-align: left;">Holidays</h5></a>
                        							    </div>    
                        								<h2><?php echo count($holidays_list); ?></h2> 
                    								</div> 
                        						</div>
										     </th>
										</tr>
									</thead>
								</table>
    					    </div>
					    </div>
					    </form>
					    <div class="clearfix"></div>
					    
						
						
					</div>
					
					
					<div class="split-row">
						<div class="col-md-7">
							<div class="box-inn-sp">
								<div class="inn-title">
									<h4>Attendance</h4> 
								</div>
								<div class="tab-inn">
									<div class="table-responsive table-desi">
										<table class="table table-hover">
											<thead>
												<tr>
													<th>Class</th> 
													<th class="text-right">Students</th>
													<th class="text-right"><i class="fa fa-check" aria-hidden="true" style="background-color:#5cb85c;" title="Presents"></i></th>
													<th class="text-right"> <i class="fa fa-times label-danger" aria-hidden="true" style="background-color:#d9534f;" title="Absents"></i></th>
													<th class="text-right"><i class="fa fa-check" aria-hidden="true" style="background-color:#f0ad4e;" title="Leaves"></i></th>
													<th>Taken By</th>
													<th>Last Updated</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											    <?php 
                                            	foreach($attendance_list as $attendance)
                                            	{
                                            	?>
												<tr>  
													<td><?php echo $attendance->class_name_section; ?></td> 
													<td class="text-right "> <span class="label label-primary mono-font"><?php echo $attendance->total_students; ?></span> </td>
													<td class="text-right"> <span class="label label-success mono-font"><?php echo $attendance->total_presents; ?></span> </td>
													<td class="text-right"> <span class="label label-danger mono-font"><?php echo $attendance->total_absents; ?></span> </td>
													<td class="text-right"> <span class="label label-warning mono-font"><?php echo $attendance->total_leaves; ?></span> </td><td><?php if($attendance->done_by == 'A') { echo "Admin";} else if($attendance->done_by == 'T') { echo "Class Teacher"; }  ?></td>
													
										    		<td><?php if($attendance->done_by == 'A') { } else if($attendance->done_by == 'T') {  }else { echo "<span class='label label-danger'>No attendance taken yet!</span>"; } ?> <?php if($attendance->last_updated != '') {  ?><span class="label label-primary mono-font "> <?php echo  date("M d, Y H:i:s",strtotime($attendance->last_updated)); ?></span>   <?php } ?> </td>
										        	<td class="text-right"><a href="<?php echo base_url(); ?>student-attendance/<?php echo base64_encode($attendance->class_register_id); ?>.<?php echo base64_encode($current_date); ?>"><?php if($attendance->done_by == 'A') { } else if($attendance->done_by == 'T') {  }else { echo " <i class='fa fa-plus'   style='background-color:#5cb85c;' title='Mark Attendance'></i>"; } ?> <?php if($attendance->last_updated != '') {  ?>   <i class='fa fa-pencil'   style='background-color:#5cb85c;' title='Update Attendance'></i>  <?php } ?></a> </td>
											       
												</tr>
											    <?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-5" style="padding-left: 0px;">
							<div class="box-inn-sp">
								<div class="inn-title">
									<h4>Holidays</h4> 
								</div>
								<div class="tab-inn">
									<div class="table-responsive table-desi">
										<table class="table table-hover">
											<thead>
												<tr>
													<th>Date</th>
													<th>Name</th>
												</tr>
											</thead>
											<tbody>
											    <?php 
											    if(count($holidays_list) > 0)
											    {
                                            	foreach($holidays_list as $holidays)
                                            	{
                                            	?>
												<tr>  
													<td>
													    <span class="label label-primary mono-font ">
													    <?php 
													    echo date("D M d, Y",strtotime($holidays->holiday_start_date));
													    if($holidays->holiday_end_date != $holidays->holiday_start_date)
													    {
													         echo " - ".date("D M d, Y",strtotime($holidays->holiday_end_date));
													    }
													    ?> 
													    </span>
													</td>
													<td><?php echo $holidays->holiday_name; ?></td>
													  
												</tr>
											    <?php } } else { ?>
											    <tr>   
													<td colspan="7"><span class="label label-danger" style="font-size:16px;">*** No Holidays for this date range! ***</span></td>  
												</tr>
											    <?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div> 
					</div>
					
					
					
					<div class="split-row">
						<div class="col-md-12">
							<div class="box-inn-sp">
								<div class="inn-title">
									<h4>Messages</h4> 
								</div>
								<div class="tab-inn">
									<div class="table-responsive table-desi" style="height: 400px;">
										<table class="table table-hover">
											<thead>
												<tr>
													<th style="width:40%;">Title</th>
													<th>Type</th>
													<th>Sending to</th> 
													<th style="width: 125px;">Created by</th> 
													<th class="text-right">Views</th>
													<th style="width: 200px;">Sent On</th> 
												</tr>
											</thead>
											<tbody>
											    <?php 
											    if(count($message_list) > 0)
                                            	{
                                            	foreach($message_list as $message)
                                            	{
                                            	?>
    												<tr  class="login<?php echo $message->message_id; ?>"   >  
    													<td><?php echo $message->title; ?></td>
    													<td><?php echo $message->message_type_display_name; ?></td>
    													<td>
    													    <?php 
    													    if($message->sending_to == 'A')
    													    {
    													        echo "All Students";
    													    }
    													    else if($message->sending_to == 'C')
    													    {
    													        echo "Selected Classes";
    													    }
    													    else if($message->sending_to == 'S')
    													    {
    													        echo "Selected Students";
    													    }
    													    ?>
    													</td>
    													<td><?php if($message->is_createdby_teacher == '0') { echo "Admin";} else if($message->is_createdby_teacher == '1') { echo " Class Teacher "; }  ?></td>
    													
    													<td class="text-right"> <span class="label label-primary"><?php echo $message->total_views; ?></span> </td>
    													<td  ><span class="label label-primary mono-font "> <?php echo  date("M d, Y H:i",strtotime($message->date_created)); ?></span> 
    													&nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $message->message_id; ?>');"   ><i class="fa fa-eye" style="font-size:10px;"></i></a>
    													</td>  
    												</tr>
    												
    												<tr class=" business_list_dropdown login2<?php echo $message->message_id; ?>">
                                                        <td colspan="7">  
                                                            <div class="col-sm-12">  
                                                                <div class="col-md-12 flyer_detail_show" >   
                                                                    <div class="row title">
                                                                    	<div class="col-md-12">   
                                                                        		<h4 style="color: #000000;background-color:#ffffff!important;padding-left:0px;"><?php echo $message->title; ?></h4>   
                                                                    	</div> 
                                                                    </div>  
                                                                    <div class="row">
                                                                    	<div class="col-md-12"> <?php echo $message->description; ?>
                                                                    	</div> 
                                                                    </div>  
                                                                     
                                                                    <br>
                                                                    <div class="clearfix"></div> 
                                                                    <?php if($message->message_images != ''){ ?>
                                                                    <div class="preview col">   
                                                                        <div class="app-figure" id="zoom-fig"> 
                                                                            <div id="myCarouselflyer<?php echo $message->message_id; ?>" class="carousel slide" data-ride="carousel"> 
                                                                                <!-- Indicators -->
                                                                                <div class="carousel-inner"> 
                                                                                    <?php  
                                                                                    $document_array = explode(';',$message->message_images);   
                                                                                    for($i=0;$i<count($document_array);$i++)
                                                                                    { 
                                                                                        $string_array = explode('|',$document_array[$i]);
                                                                                    ?>  
                                                                                        <div class="item <?php if($x == 1){ ?>active <?php } ?> "> 
                                                                                            <a id="Zoom-flyer<?php echo $message->message_id; ?>" style="max-height: 500px;min-height: 500px;" class="MagicZoom" onclick="imageevent();"  href="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>">
                                                                                                <img data-animation="animated zoomInLeft" style="max-height: 500px;min-height: 500px;" src="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>"> 
                                                                                            </a> 
                                                                                        </div>  
                                                                                        <a class="left carousel-control" href="#myCarouselflyer<?php echo $message->message_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 225px 0px;
                                                                                        font-size: 28px; background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                                        <a class="right carousel-control" href="#myCarouselflyer<?php echo $message->message_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 225px 0px; font-size: 28px;
                                                                                        background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                                        <div class="selectors">
                                                                                            <a data-zoom-id="Zoom-flyer<?php echo $message->message_id; ?>" style="max-height: 500px;min-height: 500px;" href="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>"
                                                                                            data-image="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>" >
                                                                                            <img style="max-height: 500px;min-height: 500px;" srcset="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>">
                                                                                            </a>
                                                                                        </div>  
                                                                                    <?php  $x++; } ?> 
                                                                                   
                                                                                </div>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                    <div class="clearfix"></div>
                                                                    <div class="row" style="margin:15px 0px;">  
                                                                        <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?php echo $message->date_created; ?> </span> 
                                                                    </div> 
                                                                    <div class="clearfix"></div>   
                                                                </div>  
                                                            </div>  
                                                        </td>
                                                    </tr>  
    												
											    <?php } } else { ?>
											    <tr>   
													<td colspan="7"><span class="label label-danger" style="font-size:16px;">*** No Messages for this date range! ***</span></td>  
												</tr>
											    <?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="split-row">
						<div class="col-md-12">
							<div class="box-inn-sp">
								<div class="inn-title">
									<h4>Events</h4> 
								</div>
								<div class="tab-inn">
									<div class="table-responsive table-desi" style="height: 300px;">
										<table class="table table-hover">
											<thead>
												<tr>
													<th style="width:32%;">Title</th> 
													<th style="width:16%;">Sending to</th>  
													<th style="width:14%;">Created by</th> 
													<th style="width:10%;" >Event Date</th> 
													<th style="width:7%;">From</th>
													<th style="width:7%;">To</th>
													<th style="width:10%;" class="text-right">Views</th>
												</tr>
											</thead>
											<tbody>
											    <?php 
											    if(count($event_list) > 0)
                                            	{
                                            	foreach($event_list as $event)
                                            	{
                                            	?>
												<tr class="login<?php echo $event->event_id; ?>"   >  
													<td><?php echo $event->title; ?></td>
													<td>
													    <?php 
													    if($event->sending_to == 'A')
													    {
													        echo "All Students";
													    }
													    else if($event->sending_to == 'C')
													    {
													        echo "Selected Classes";
													    }
													    else if($event->sending_to == 'S')
													    {
													        echo "Selected Students";
													    }
													    ?>
													</td>
													<td><?php if($event->is_createdby_teacher == '0') { echo "Admin";} else if($event->is_createdby_teacher == '1') { echo "Class Teacher"; }  ?></td>
													
													<td><span class="label label-primary mono-font "><?php echo date("D M d, Y",strtotime($event->start_date)); ?></span></td> 
													<td><span class="label label-primary mono-font "><?php echo date("h:i A",strtotime($event->start_time)); ?></span></td>
													<td><span class="label label-primary mono-font "><?php echo date("h:i A",strtotime($event->end_time)); ?></span></td>
													<td class="text-right"> 
													<span class="label label-primary mono-font"><?php echo $event->total_views; ?></span> 
													&nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $event->event_id; ?>');"     ><i class="fa fa-eye" style="font-size:10px;"></i></a>
													</td>
												</tr>
												
												
                                                	<tr class=" business_list_dropdown login2<?php echo $event->event_id; ?>">
                                                        <td colspan="7">  
                                                            <div class="col-sm-12">  
                                                                <div class="col-md-12 flyer_detail_show" >   
                                                                    <div class="row title">
                                                                    	<div class="col-md-12">   
                                                                        		<h4 style="color: #000000;background-color:#ffffff!important;padding-left:0px;"><?php echo $event->title; ?></h4>   
                                                                    	</div> 
                                                                    </div>  
                                                                    <div class="row">
                                                                    	<div class="col-md-12"> <?php echo $event->description; ?>
                                                                    	</div> 
                                                                    </div>  
                                                                     
                                                                    <br>
                                                                    <div class="clearfix"></div> 
                                                                    
                                                                    <?php if($event->event_images != ''){ ?>
                                                                    <div class="preview col">   
                                                                        <div class="app-figure" id="zoom-fig"> 
                                                                            <div id="myCarouselflyer<?php echo $event->event_id; ?>" class="carousel slide" data-ride="carousel"> 
                                                                                <!-- Indicators -->
                                                                                <div class="carousel-inner"> 
                                                                                    <?php  
                                                                                    $document_array = explode(';',$event->event_images);   
                                                                                    for($i=0;$i<count($document_array);$i++)
                                                                                    { 
                                                                                        $string_array = explode('|',$document_array[$i]);
                                                                                    ?>  
                                                                                        <div class="item <?php if($x == 1){ ?>active <?php } ?> "> 
                                                                                            <a id="Zoom-flyer<?php echo $event->event_id; ?>" style="max-height: 500px;min-height: 500px;" class="MagicZoom" onclick="imageevent();"  href="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>">
                                                                                                <img data-animation="animated zoomInLeft" style="max-height: 500px;min-height: 500px;" src="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>"> 
                                                                                            </a> 
                                                                                        </div>  
                                                                                        <a class="left carousel-control" href="#myCarouselflyer<?php echo $event->event_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 225px 0px;
                                                                                        font-size: 28px; background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                                        <a class="right carousel-control" href="#myCarouselflyer<?php echo $event->event_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 225px 0px; font-size: 28px;
                                                                                        background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                                        <div class="selectors">
                                                                                            <a data-zoom-id="Zoom-flyer<?php echo $event->event_id; ?>" style="max-height: 500px;min-height: 500px;" href="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>"
                                                                                            data-image="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>" >
                                                                                            <img style="max-height: 500px;min-height: 500px;" srcset="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>">
                                                                                            </a>
                                                                                        </div>  
                                                                                    <?php  $x++; } ?> 
                                                                                   
                                                                                </div>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                    <div class="clearfix"></div>
                                                                    <div class="row" style="margin:15px 0px;">  
                                                                        <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?php echo date("D M d, Y",strtotime($event->date_created)); ?> </span> 
                                                                    </div> 
                                                                    <div class="clearfix"></div>   
                                                                </div>  
                                                            </div>  
                                                        </td>
                                                    </tr>
											    <?php } } else { ?>
											    <tr>   
													<td colspan="7"><span class="label label-danger" style="font-size:16px;">*** No Events for this date range!  ***</span></td>  
												</tr>
											    <?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="split-row">
						<div class="col-md-12">
							<div class="box-inn-sp">
								<div class="inn-title">
									<h4>Leave Requests</h4> 
								</div>
								<div class="tab-inn">
									<div class="table-responsive table-desi">
										<table class="table table-hover">
											<thead>
												<tr> 
													<th style="width:190px;">Name</th>
													<th style="width:50px;" >Class</th>
													<th  >Title</th>
													<th style="width:100px;">Start Date</th>
													<th style="width:100px;" >End Date</th>
													<th style="width:100px;" >Status</th>
													<th style="width:100px;">Approved By</th>
												</tr>
											</thead>
											<tbody>
											    <?php 
											    if(count($leave_request_list) > 0)
											    {
                                            	foreach($leave_request_list as $leave_request)
                                            	{
                                            	?>
												<tr>  
													<td>
													<?php 
													if($leave_request->profile_picture != '')
													{
													    ?>
													    <img src="<?php echo base_url(); ?>/assets/uploadimages/studentimages/<?php echo $leave_request->profile_picture; ?>" class="img-circle" style="width:30px; height:30px;" />
												    <?php  }else { ?>
												        <img src="<?php echo base_url(); ?>/assets/images/name.png" class="img-circle" style="width:30px; height:30px;" /> 
													<?php } ?> 
													<?php echo $leave_request->first_name." ".$leave_request->last_name; ?>
													</td> 
													<td><?php echo $leave_request->class_name; ?></td> 
													<td><strong><?php echo $leave_request->request_title; ?></strong></td> 
													<td><span class="label label-primary mono-font "><?php echo date("D M d, Y",strtotime($leave_request->start_date)); ?></span> </td> 
													<td><span class="label label-primary mono-font "><?php echo date("D M d, Y",strtotime($leave_request->end_date)); ?></span> </td> 
													
													<td><?php if($leave_request->request_status == '0') { echo "Denied";} else if($leave_request->request_status == '1') { echo "Approved"; } else { echo "<span class='label label-danger'>Pending</span>"; } ?></td>
													<td class="text-right">
													    <?php if($leave_request->approved_by == 'A') { echo "Admin";} else if($leave_request->approved_by == 'T') { echo "Class Teacher"; } ?>
                        	                            &nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $leave_request->student_leave_request_id; ?>');"     ><i class="fa fa-eye" style="font-size:10px;"></i></a>
													</td>  
												</tr>
												
												
												<tr class=" business_list_dropdown login2<?php echo $leave_request->student_leave_request_id; ?>">
                                                <td colspan="7">  
                                                    <div class="col-sm-12">  
                                                        <div class="col-md-12 flyer_detail_show" >   
                                                            <div class="row title">
                                                            	<div class="col-md-12">   
                                                                		<h4 style="color: #000000;background-color:#ffffff!important;padding-left:0px;"><?php echo $leave_request->request_title; ?></h4>   
                                                            	</div> 
                                                            </div>  
                                                            <div class="row">
                                                            	<div class="col-md-12"> <?php echo $leave_request->request_reason; ?>
                                                            	</div> 
                                                            </div>  
                                                             
                                                            <br>
                                                            <div class="clearfix"></div> 
                                                            <?php if($leave_request->leave_requests_images != '') { ?>
                                                            <div class="preview col">   
                                                                <div class="app-figure" id="zoom-fig"> 
                                                                    <div id="myCarouselflyer<?php echo $leave_request->student_leave_request_id; ?>" class="carousel slide" data-ride="carousel"> 
                                                                        <!-- Indicators -->
                                                                        <div class="carousel-inner"> 
                                                                                <?php  
                                                                                $document_array = explode(';',$leave_request->leave_requests_images);   
                                                                                for($i=0;$i<count($document_array);$i++)
                                                                                { 
                                                                                    $string_array = explode('|',$document_array[$i]);
                                                                                ?>   
                                                                                <div class="item <?php if($i == 0){ ?>active <?php } ?> "> 
                                                                                    <a id="Zoom-flyer<?php echo $leave_request->student_leave_request_id; ?>" style="max-height: 500px;min-height: 500px;" class="MagicZoom" onclick="imageevent();"  href="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>">
                                                                                        <img data-animation="animated zoomInLeft" style="max-height: 500px;min-height: 500px;" src="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>"> 
                                                                                    </a> 
                                                                                </div>  
                                                                                <a class="left carousel-control" href="#myCarouselflyer<?php echo $leave_request->student_leave_request_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 225px 0px;
                                                                                font-size: 28px; background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                                <a class="right carousel-control" href="#myCarouselflyer<?php echo $leave_request->student_leave_request_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 225px 0px; font-size: 28px;
                                                                                background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                                <div class="selectors">
                                                                                    <a data-zoom-id="Zoom-flyer<?php echo $leave_request->student_leave_request_id; ?>" style="max-height: 500px;min-height: 500px;" href="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>"
                                                                                    data-image="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>" >
                                                                                    <img style="max-height: 500px;min-height: 500px;" srcset="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>">
                                                                                    </a>
                                                                                </div>  
                                                                            <?php   } ?> 
                                                                           
                                                                        </div>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="clearfix"></div>
                                                            <div class="row" style="margin:15px 0px;">  
                                                                <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?php echo $leave_request->date_created; ?> </span> 
                                                            </div> 
                                                            <div class="clearfix"></div>   
                                                        </div>  
                                                    </div>  
                                                </td>
                                            </tr>
												
												
												
											    <?php } } else { ?>
											    <tr>   
													<td colspan="7"><span class="label label-danger" style="font-size:16px;">*** No Leave Request for this Period ***</span></td>  
												</tr>
											    <?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="split-row">
						
					</div>
					
					 
				</div>
			</div>
		</div> 
         
  <script type="text/javascript">
function showhide2(id) {
$(".login2"+id).toggle();  
}
function imageevent(){ 
    $('.bottomMenu ').css('position','inherit');
}
</script> 
       


<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - DASHBOARD</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Dashboard is the HOME-Page for the Zumily-School application. </li>
                  <li >It lists the information for Attendance, Messages, Events, Leave-Requests, & Holidays. </li>
                  <li >The default date to show the Attendance is today. However, you can select any date in past for this session-year to see Attendance for all the Classes. You can goto a specific Class-Register and EDIT if already taken OR MARK if not yet taken by Class-Teacher or Admin.</li>
                  <li >Messages, Events, Leave-Requests, & Holidays work within 2 date ranges. The default date range is current month to date. However, you can change to any date ranges within this session-year dates.</li>
                  <li >Holidays section will display all the holidays within the date-range selected in the top section.</li>
                  <li >Messages section will display all the messages sent within the date-range selected in the top section. You can view any message just by clicking on the view icon to see complete information including description and images if any.</li>
                  <li >Events section will display all the events within the date-range selected in the top section. You can view any event just by clicking on the view icon to see complete information including description and images if any.</li>
                  <li >Leave Request displays all the LR sent by Students/Parents for the date range selected. You can also VIEW to see complete information including description and document if any attached OR EDIT to Approve/Deny the LR.</li>
                </ul> 
            </div> 
        </div> 
    </div>
</div>
<style> 

.popup li::before {
  content: "\2022";
  color: red;
  font-weight: bold; 
  width: 1em;font-size: 25px;
  margin-left: -1em;
  margin-right: 10px;
}
</style>

