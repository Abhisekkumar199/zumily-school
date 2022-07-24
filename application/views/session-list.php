<!--CENTER SECTION-->
 <div class="tz-2 mainContant" style="background-color:#ffffff;">
<div class="tz-2-com tz-2-main">
	<div class="row" style="background: #d5d5d5;" >
		<div class="col-md-12 col-xs-12" > 
			<h4>Sessions List 
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
			<a href="<?php echo base_url(); ?>session-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
			<a  style=" margin-right: 10px;" class=" pull-right" href="<?php echo base_url();?>add-session"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a>
			</h4>
		</div>
	 
	</div>
        
	<div class="col-sm-12 fullWidth-tab">
		<div class="panel panel-bd lobidrag"> 
                
            <div class="panel-body" id="result"> 
            	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	<table class="table table-hover">
                    	<thead>
                        	<td  style="width:146px;"><span ><a href="javascript:void(0)" name="order" class="button" column_value="flyer_name" link_value="desc"  value="delivery">Session </a></span></td>
                        
                        	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Starts from </a></span>  </td>
                        	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="end_date" link_value="desc"  value="delivery"> Ends on </a></span></td> 
                        	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="end_date" link_value="desc"  value="delivery"> Saturday off? </a></span></td> 
                        	<td>Action</td>
                    	</thead>
                    	<tbody>
                    	<?php
                     	if(@$totalrecord > 0)
                    	{
                    	foreach($session_lists as $session_list)
                    	{
                    	?>
                
            	        <tr class="  login<?php echo $session_list->session_year_id; ?>" onclick="showhide2('<?php echo $session_list->session_id; ?>');" >
            	            
                    		<td class="business_list_"><?php echo $session_list->session_year; ?></td> 
                    		<td class="business_list_"><?php echo date("D, M d, Y",strtotime(@$session_list->start_date)) ; ?></td>
                    		<td class="business_list_"><?php echo date("D, M d, Y",strtotime(@$session_list->end_date)) ; ?></td> 
                    		
                    		<td class="business_list_"><?php if($session_list->is_saturday_off == 0) { echo "No";} else { echo "Yes";} ?></td> 
                    		<td>
                    		    <?php if($session_list->session_is_active == '1' ) { ?>
                    		    <a href="<?php echo base_url(); ?>update-session/<?php echo base64_encode($session_list->session_id); ?>"   title="Edit this Session"  ><i class="fa fa-pencil" style="font-size:20px;color:#151f31;"></i></a>
                    			<?php } ?>
                    			&nbsp;&nbsp;&nbsp;
                    		 
                    		</td>
                    	</tr>
                
                	<?php } } else { ?>
                	<tr>
                		<td colspan="4" class="business_list_"> You have no session added. <a href="<?php echo base_url(); ?>add-session">Click here</a> to add one.</td>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Sessions List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the Sessions you have added to this application.</li>
                  <li >You can Edit/Delete a Session only if no Class-Register has been created for this Session-Year. </li>
                  <li >Session should be created at the start of each session year. </li>
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
