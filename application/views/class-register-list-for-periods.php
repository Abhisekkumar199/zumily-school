 <script>  
function delete_class_register(class_register_id,class_teacher_id,session_id)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to remove this Class-Register?", function (e) 
    { 
        if (e) 
        { 
        	var pass_data = {class_register_id: class_register_id,class_teacher_id: class_teacher_id,session_id: session_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-class-register",
        	type : "POST",
        	data : pass_data,
        	success : function(data) { 
        	location.reload();
        	}
        	});
        	return false;
        } 
        else 
        { 
        }
    }); 
      
} 
</script> 
 
<!--CENTER SECTION-->
<div class="tz-2 mainContant  " style="min-height: 400px;background-color:#ffffff;" >
<div class="tz-2-com tz-2-main">  
	<div class="row" style="background: #151f31;" >
        <div class="col-md-8 col-xs-8" > 
			<h4>Classes Register List for Reporting Periods </h4>
		</div>
		<div class="col-md-4 col-xs-4" >
		    <form method="get" action="<?php echo base_url(); ?>reporting-periods" >
		    <div class="row"> 
		        <div class="col-md-4" ></div>
                <div class="col-md-7"   > 
        		    <select id="session_year" class="form-control  " name="session_year" onchange="this.form.submit()" style="border: 1px solid rgb(189, 185, 185);  margin: 7px; height:30px;padding-right:10px;" required=""   >
                        <option value=""  >Select session year  </option> 
                        <?php foreach($session_years as $session_year) { ?>
                        <option value="<?php echo base64_encode($session_year->session_id); ?>" <?php if($selected_session == $session_year->session_id ) { ?>selected <?php } ?>  ><?php echo $session_year->session_year; ?></option>
                        <?php } ?>
                    </select> 
                </div>  
			</div>
			<button type="submit" style="  display:none; " >  </button>
			</form>
		</div>
	</div>
        
	<div class="col-sm-12 fullWidth-tab">
		<div class="panel panel-bd lobidrag"> 
             
            <div class="panel-body" id="result"> 
            	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	<table class="table table-hover">
                	    <input type="hidden" name="current_date" id="current_date" />
                    	<thead>
                        	<td  style="width: 60px;" ><span ><a href="javascript:void(0)"  >Class </a></span></td> 
                        	<td  style="width: 70px;" ><span ><a href="javascript:void(0)"  >Session Year </a></span></td> 
                        	<td style="width: 60px;" ><span ><a href="javascript:void(0)"  >Room No. </a></span></td> 
                        	<td style="width: 80px;" ><span ><a href="javascript:void(0)"  >Total Students </a></span></td> 
                        	<td style="width: 160px;" ><span ><a href="javascript:void(0)"  >Class Teacher </a></span></td>   
                        	<td class="text-right">Action</td>
                    	</thead>
                    	<tbody>
                    	<?php
                     	if(@$totalrecord > 0)
                    	{
                    	foreach($classregister_lists as $classregister)
                    	{
                    	     
                    	?> 
            	        <tr  >
                    		<td class="business_list_"><?php echo $classregister->class_name_section; ?></td> 
                    		<td class="business_list_"><?php echo $classregister->session_year; ?></td> 
                    		<td class="business_list_"><?php echo $classregister->room_no; ?></td>  
                    		<td class="business_list_"><?php echo $classregister->total_students; ?></td>  
                    		<td class="business_list_"><?php echo $classregister->first_name." ".$classregister->last_name; ?></td> 
                    		 
                    		<td class="text-right">   
                    		    &nbsp;&nbsp;<a href="<?php echo base_url(); ?>add-reporting-period/<?php echo base64_encode($classregister->class_register_id); ?>" title="Add New Reporting Periods"> <i style="float: right;font-size: 20px;color:#151f31; margin-left: 10px;" class="fa fa-plus-circle"></i>&nbsp;&nbsp;</a>
                        	    
                        	    &nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $classregister->class_register_id; ?>');" title="View all Reporting Periods"v ><i class="fa fa-eye" style="font-size:20px;color:#151f31;"></i></a>
                        	</td>
                    	</tr>
                        
                    	<tr style="display:none;background-color:#ffffff;" class=" business_list_dropdown login2<?php echo $classregister->class_register_id; ?>">
                            <td colspan="6"> 
                            <?php
                            
                                @$periods = class_register_reporting_periods($classregister->class_register_id,$current_date);
                                if(count($periods) > 0)
                                {
                            ?>
                            <table>
                                <tr>
                                    <th><strong>Exam Name</strong></th>
                                    <th><strong>Start Date</strong></th>
                                    <th><strong>End Date</strong></th>
                                    <th><strong>Action</strong></th>
                                </tr>
                                <?php 
                                foreach($periods as $period)
                    	        { 
                                ?>
                                <tr>
                                    <td><?php echo $period->exam_name; ?></td>
                                    <td><?php echo $period->start_date; ?></td>
                                    <td><?php echo $period->end_date; ?></td>
                                    <td><a href="<?php echo base_url(); ?>/update-reporting-period/<?php echo base64_encode($period->reporting_cr_period_id); ?>"   ><i class="fa fa-pencil" style="center; font-size:20px;color:#151f31;"></i></a></td>
                                </tr>
                                <?php } ?>
                            </table>
                            <?php  } else { ?>
                            <p style="color:red;text-align: center;"><strong>** No Reporting Period has been added to this Class-Register yet **</strong></p>
                            <?php } ?>
                            </td>
                        </tr>
                	<?php } } else { ?>
                	<tr>
                		<td colspan="6" class="business_list_"> You have no class register added. <a href="<?php echo base_url(); ?>/add-class-register">Click here</a> to add one.</td>
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
</section>
  <script type="text/javascript">
function showhide2(id) {
$(".login2"+id).toggle();  
}
 
</script> 
