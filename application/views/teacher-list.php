 <!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent" >
<div class="tz-2-com tz-2-main"> 
    <div id="snackbar">Teacher updated Successfully!</div>
    
	<div class="row" style="background: #d5d5d5;" >
		<div class="col-md-12 col-xs-12" > 
			<h4>Teachers List
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
            <a href="<?php echo base_url(); ?>teacher-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
			
			<a  style="margin-right: 10px;" class=" pull-right" href="<?php echo base_url();?>add-teacher"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a>
			<a  style="  margin: -5px;margin-left: 10px;margin-right: 10px;" class="btn btn-success dropdown-toggle height-36 pull-right" href="<?php echo base_url();?>terminated-teacher">Terminated Teachers </a>
			</h4>
		</div>
		 
	</div>
        
	<div class="col-sm-12 fullWidth-tab">
		<div class="panel panel-bd lobidrag"> 
             
            <div class="panel-body" id="result"> 
                <?php
                $success = $this->session->userdata('success'); 
                if (!empty($success)) 
                {
                    echo  $success ;
                    $this->session->unset_userdata('success');
                }
                ?>
            	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	<table class="table table-hover">
                    	<thead>
                        	<td  ><span ><a href="javascript:void(0)"  >Name </a></span></td>  
                        	<td ><span ><a href="javascript:void(0)"  >Mobile No. </a></span></td> 
                        	<td class="col-md-3" ><span ><a href="javascript:void(0)"  >Subject(s) </a></span></td> 
                        	<td  ><span ><a href="javascript:void(0)"  >Designation </a></span></td> 
                        	<td  ><span ><a href="javascript:void(0)"  >Joining Date </a></span></td>  
                        	<td class="pull-right">Action</td>
                    	</thead>
                    	<tbody>
                    	<?php
                     	if(@$totalrecord > 0)
                    	{
                    	foreach($teacher_lists as $teachers)
                    	{
                    	?>
                
            	        <tr class=" "   >
                    		<td class="business_list_">
                    		     <?php if(!empty($teachers->profile_picture)) { ?>
                        		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/teacherimages/<?php echo $teachers->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                        		    <?php } else { ?>
                        		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                        		    <?php } ?>
                    		    <?php echo $teachers->first_name." ".$teachers->last_name; ?></td> 
                    		<td class="business_list_"><?php echo $teachers->mobile_no; ?></td> 
                    		<td class="business_list_">
                    		<?php  
                    		if($teachers->subject1 != '') {echo $teachers->subject1 ; }  
                    		if($teachers->subject2 != '') {echo ", ".$teachers->subject2;  } 
                    		if($teachers->subject3 != '') {echo ", ".$teachers->subject3;  } 
                    		?>
                    		</td>  
                    		<td class="business_list_"><?php echo $teachers->designation; ?></td> 
                    		
                    		<td class="business_list_"><?php echo date("D, M d, Y",strtotime(@$teachers->joining_date)) ; ?> </td>  
                    		<td class="pull-right">  
                    			<a href="<?php echo base_url(); ?>update-teacher/<?php echo base64_encode($teachers->teacher_id); ?>"   title="Edit this Teacher's data"  ><i class="fa fa-pencil" style="font-size:20px;color:#151f31;"></i></a>
                    		    &nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $teachers->teacher_id; ?>');" title="View all  "v ><i class="fa fa-eye" style="font-size:20px;color:#151f31;"></i></a>
                    		    	<!--<?php if($teachers->displayflag == 1 ) { ?>
                    			<a href="<?php echo base_url(); ?>disable-teacher/<?php echo $teachers->teacher_id; ?>" title="Disable this Teacher"  ><i class="fa fa-ban" style="color:green;" style="font-size:25px;"></i></a>
                    			<?php } else { ?> 
                    			<a href="<?php echo base_url(); ?>enable-teacher/<?php echo $teachers->teacher_id; ?>"   title="Enable this Teacher"  ><i class="fa fa-ban" style="color:red;" style="font-size:25px;"></i></a>
                    			<?php } ?> -->
                    		</td>
                    	</tr>
                    	
                        
                    	<tr style="display:none;background-color:#ffffff;" class=" business_list_dropdown login2<?php echo $teachers->teacher_id; ?>">
                            <td colspan="6"> 
                            <?php 
                                $teacher_classes = get_teacher_teaching_classes($teachers->teacher_id);
                                if(count($teacher_classes) > 0)
                                {
                            ?>
                            <table>
                                <tr>
                                    <th><strong>Session Year</strong></th>
                                    <th><strong>Class Teacher</strong></th>
                                    <th><strong>Sub Teacher</strong></th> 
                                </tr>
                                <?php 
                                foreach($teacher_classes as $classes)
                    	        { 
                                ?>
                                <tr>
                                    <td><?php echo $classes->session_year; ?></td>
                                    <td><?php echo $classes->class_teacher_class_register_info; ?></td>
                                    <td><?php echo $classes->sub_class_name_sections; ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                            <?php  } else { ?>
                            <p style="color:red;text-align: center;"><strong>*** No teaching record found for this Teacher ***</strong></p>
                            <?php } ?>
                            </td>
                        </tr>
                	<?php } } else { ?>
                	<tr>
                		<td colspan="4" class="business_list_"> You have no teacher added. <a href="<?php echo base_url(); ?>/add-teacher">Click here</a> to add one.</td>
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
 
 
 
 <!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Teachers List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the Active Teachers, you have added to this application and working currently in the school.</li>
                  <li >These teachers can be assigned as Class-Teacher when creating Class-Registers. </li>
                  <li >These teachers can also be assigned as Subject-Teacher to any or all of the Active-Class-Registers.</li>
                  <li >If a teacher has left or terminated from school, Please EDIT the teacher's record and update TERMINATION-DATE and the REASON. It will make him/her INACTIVE in the application and won't be able to access Zumily-School app.</li>
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
  <script type="text/javascript">
function showhide2(id) {
$(".login2"+id).toggle();  
}
 
</script> 