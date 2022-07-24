 
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent" >
<div class="tz-2-com tz-2-main"> 
    <div id="snackbar">Teacher updated Successfully!</div>
    
	<div class="row" style="background: #d5d5d5;" >
		<div class="col-md-12 col-xs-12" > 
			<h4>Terminated Teachers List 
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
            <a href="<?php echo base_url(); ?>terminated-teachers-list-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
		    
			<a  style=" margin-right:10px;" class=" pull-right" href="<?php echo base_url();?>add-teacher"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a>
			<a  style="  margin: -5px;margin-left:10px;margin-right:10px;" class="btn btn-success dropdown-toggle height-36 pull-right" href="<?php echo base_url();?>teachers-list">Active Teachers </a>
			</h4>
		</div>
	</div>
        
	<div class="col-sm-12 fullWidth-tab">
		<div class="panel panel-bd lobidrag"> 
             
            <div class="panel-body" id="result"> 
            	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	<table class="table table-hover">
                    	<thead>
                        	<td  ><span ><a href="javascript:void(0)"  >Name </a></span></td>  
                        	<td ><span ><a href="javascript:void(0)"  >Mobile No. </a></span></td> 
                        	<td  ><span ><a href="javascript:void(0)"  >Designation </a></span></td>  
                        	<td  ><span ><a href="javascript:void(0)"  >Joining Date </a></span></td>  
                        	<td  ><span ><a href="javascript:void(0)"  >Termination Date </a></span></td>  
                        	<td  ><span ><a href="javascript:void(0)"  >Reason</a></span></td>   
                    	</thead>
                    	<tbody>
                    	<?php
                     	if(@$totalrecord > 0)
                    	{
                    	foreach($teacher_lists as $teachers)
                    	{
                    	?>
                
            	        <tr class=" "   >
                    		<td class="business_list_"><?php echo $teachers->first_name." ".$teachers->last_name; ?></td> 
                    		<td class="business_list_"><?php echo $teachers->mobile_no; ?></td> 
                    		<td class="business_list_"><?php echo $teachers->designation; ?></td>  
                    		<td class="business_list_"><?php echo date("D, M d, Y",strtotime(@$teachers->joining_date)) ; ?> </td>  
                    		<td class="business_list_"><?php echo date("D, M d, Y",strtotime(@$teachers->termination_date)) ; ?> </td> 
                    		<td class="business_list_"><?php echo $teachers->ternimation_reason; ?></td>   
                    	</tr> 
                	<?php } } else { ?>
                	<tr>
                		<td colspan="4" class="business_list_"> Currently, you have no terminated teachers in your school.</td>
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


 
 <!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Terminated Teachers List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the Terminated Teachers who have left the school or got terminated.</li>
                  <li >Terminated teachers cannot access Zumily-School app, means he/she cannot do any school activity on app. </li>
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
   