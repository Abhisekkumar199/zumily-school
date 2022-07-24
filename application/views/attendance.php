 
<script>
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
    	    //$total_students = 1022;
    	    //$total_presents = 980;
    	    //$total_absents = 55;
    	    //$total_leaves = 10;
    	?>
								
        <div class="sb2-2" style="padding: 5px;">
			<!--== breadcrumbs ==-->
		 
			<div class="tz-2 tz-2-admin">
				<div class="tz-2-com tz-2-main">
					<h4>Attendance 
                        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>					
                    </h4>
					<div class="tz-2-main-com bot-sp-20">
					    <form method="get" action="<?php echo base_url(); ?>attendance">
					    <div class="row">
    					    <div class="col-md-12" style="width:97%!important;padding-left: 17px!important;padding-right: 3px!important;"> 
    					        <table class="table " style="margin-bottom: 0px;">
									<thead style="border-bottom:none;">
										<tr>
											<td style="background: #dedede;border: 1px solid #152733;width:20%;"> 
											     <input type="text" class="test " style="background-color: #ffffff;font-size:17px;" name="attendance_date" id="attendance_date" onchange="this.form.submit()"  title="Date"   placeholder="Attendance Date" value="<?php echo date('D, d M , Y',strtotime($current_date)); ?>"   />  
											</td> 
											<td style="width:3%"> </td>
											<td style="vertical-align: middle;">
											    <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Students: </h5><h5 class="text-primary pull-left" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-left: 10px;"><?php echo $total_students; ?></h5>
											</td>
											<td style="vertical-align: middle;">
											    <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Presents: </h5><h5 class="text-success pull-left" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-left: 10px;"><?php echo $total_presents; ?></h5> 
                        							    
											</td>
											<td style="vertical-align: middle;">
											    <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Absents: </h5><h5 class="text-danger pull-left" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-left: 10px;"><?php echo $total_absents; ?></h5> 
                        							    
											</td>
											<td style="vertical-align: middle;">
											     <h5 class="pull-left" style="font-family: monospace; font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;">Leaves: </h5><h5 class="text-warning pull-left" style=" font-size: 18px; font-style: normal; font-variant: normal; font-weight: 600; line-height: 25px;margin-left: 10px;"><?php echo $total_leaves; ?></h5>  
                        						
											</td>
										</tr> 
									</thead>
								</table>
    					    </div>
					    </div>
					    </form>
					    <div class="clearfix"></div>
					    
						
						
					</div>
					
					
					<div class="split-row">
						<div class="col-md-12">
							<div class="box-inn-sp"> 
								<div class="tab-inn">
									<div class="table-responsive table-desi">
										<table class="table table-hover">
											<thead>
												<tr>
													<th style="width:8%;">Class</th> 
													<th style="width:8%;" class="text-right">Students</th>
													<th style="width:10%;" class="text-right"><i class="fa fa-check" aria-hidden="true" style="background-color:#5cb85c;" title="Presents"></i></th>
													<th style="width:10%;" class="text-right"> <i class="fa fa-times label-danger" aria-hidden="true" style="background-color:#d9534f;" title="Absents"></i></th>
													<th  style="width:10%;" class="text-right"><i class="fa fa-check" aria-hidden="true" style="background-color:#f0ad4e;" title="Leaves"></i></th>
													<th  class="text-left">Taken By</th>
													<th style="width:15%;" class="text-left">Last Updated</th>
													<th class="text-right">Action</th>
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
													<td class="text-right"> <span class="label label-warning mono-font"><?php echo $attendance->total_leaves; ?></span> </td>
													<td><?php if($attendance->done_by == 'A') { echo "Admin";} else if($attendance->done_by == 'T') { echo "Class Teacher"; }  ?></td>
													
										    		<td class="text-left"><?php if($attendance->done_by == 'A') { } else if($attendance->done_by == 'T') {  }else { echo "<span class='label label-danger'>No attendance taken yet!</span>"; } ?> <?php if($attendance->last_updated != '') {  ?><span class="label label-primary mono-font "> <?php echo  date("M d, Y H:i:s",strtotime($attendance->last_updated)); ?></span>   <?php } ?> </td>
										        	<td class="text-right"><a href="<?php echo base_url(); ?>student-attendance/<?php echo base64_encode($attendance->class_register_id); ?>.<?php echo base64_encode($current_date); ?>"><?php if($attendance->done_by == 'A') { } else if($attendance->done_by == 'T') {  }else { echo " <i class='fa fa-plus'   style='background-color:#5cb85c;' title='Mark Attendance'></i>"; } ?> <?php if($attendance->last_updated != '') {  ?>   <i class='fa fa-pencil'   style='background-color:#5cb85c;' title='Update Attendance'></i>  <?php } ?></a> </td>
											       
												</tr>
											    <?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div> 
					</div>
					  
					  
					 
				</div>
			</div>
		</div> 
         
         

<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Attendance</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Attendance page displays attendance status for all the Class-Registers for the selected date.</li>
                  <li >These Class-Registers are for current session-year only. If you want to check attendance-status for a Class-Register belongs to previous session-years, then go to REPORTS.</li>
                  <li >You can EDIT attendance if it has already been taken in the past.</li>
                  <li >From this page, you can MARK the ATTENDANCE if has not been taken yet.</li>
                  <li >Numbers displayed in the HEADER on this page is total for all the classes in the school.  </li>
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

      