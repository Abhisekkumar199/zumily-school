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
<div class="tz-2 mainContant  " style="min-height: 500px;background-color:#ffffff;" >
<div class="tz-2-com tz-2-main">  
	<div class="row" style="background: #151f31;" >
	        <div class="col-md-8 col-xs-8" > 
			    <h4>Class Registers - Populate Students Report Card</h4>
		    </div>
    		<div class="col-md-4 col-xs-4" >
    		    <form method="get" action="<?php echo base_url(); ?>school-fee-payment" >
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
            	        <tr class=" "   >
                    		<td class="business_list_"><?php echo $classregister->class_name_section; ?></td> 
                    		<td class="business_list_"><?php echo $classregister->session_year; ?></td> 
                    		<td class="business_list_"><?php echo $classregister->room_no; ?></td>  
                    		<td class="business_list_"><?php echo $classregister->total_students; ?></td>  
                    		<td class="business_list_"><?php echo $classregister->first_name." ".$classregister->last_name; ?></td> 
                    		 
                    		<td class="text-right">   
                    		  <?php if($classregister->total_students > 0 ) { ?>  <a href="<?php echo base_url(); ?>report-card-class-students/<?php echo base64_encode($classregister->class_register_id); ?>" >Class Students</a> <?php } else { ?>Class Students<?php } ?>   
                    		</td>
                    	</tr>
                
                	<?php } } else { ?>
                	<tr>
                		<td colspan="4" class="business_list_"> You have no class register added. <a href="<?php echo base_url(); ?>/add-class-register">Click here</a> to add one.</td>
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
  