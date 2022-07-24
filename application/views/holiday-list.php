
<script>  
function deleteholiday(val1)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure, want to delete this holiday(s) from this Session Year?", function (e) 
    {
        if (e) 
        {
            var holiday_id = val1; 
        	var pass_data = {holiday_id: holiday_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-holiday/"+holiday_id,
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
    <div class="tz-2 mainContant" style="background-color:#ffffff;">
        <div class="tz-2-com tz-2-main"> 
        	<div class="row" style="background: #151f31;" >
        		<div class="col-md-4 col-xs-4" > 
        			<h4>Holidays List 
        			</h4>
        		</div>
        		<div class="col-md-8 col-xs-8" >
        		    <form method="get" action="<?php echo base_url(); ?>holidays-list" >
        		    <div class="row">
        		        <div class="col-md-6" >
        		            <?php    ?>
                		    <select id="session_year" class="form-control row1check" name="session_year" required="" onchange="this.form.submit()" style="border: 1px solid rgb(189, 185, 185);  margin: 7px; height: 30px;   width: 174px;">
                                <option value="">Select session year  </option> 
                                <?php foreach($session_years as $session_year) { ?>
                                <option value="<?php echo base64_encode($session_year->session_id); ?>" <?php if($selected_session == $session_year->session_id ) { ?>selected <?php } ?>  ><?php echo $session_year->session_year; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6" >
			                <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: 7px; margin-right: 11px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
			                <a href="<?php echo base_url(); ?>holiday-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: 7px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        			        <a  style="     margin-top: 10px; margin-right: 10px;" class=" pull-right" href="<?php echo base_url();?>add-holiday"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a>
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
                            	<thead> 
                                	<td style="width:220px;"><span ><a href="javascript:void(0)" name="order" class="button" column_value="flyer_name" link_value="desc"  value="delivery">Holiday Name </a></span></td>
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Holiday Start Date </a></span>  </td>
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Holiday End Date </a></span>  </td>
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="end_date" link_value="desc"  value="delivery"> Session</a></span></td>  
                                	<td>Action</td>
                            	</thead>
                            	<tbody>
                            	<?php
                             	if(@$totalrecord > 0)
                            	{
                            	foreach($holiday_lists as $holiday_list)
                            	{
                            	?>
                        
                    	        <tr class="  login<?php echo $holiday_list->session_year_id; ?>" onclick="showhide2('<?php echo $holiday_list->holiday_id; ?>');" >
                    	            
                            		<td class="business_list_"><?php echo $holiday_list->holiday_name; ?></td> 
                            		<td class="business_list_"><?php echo date("D, M d, Y",strtotime(@$holiday_list->holiday_start_date)) ; ?></td>
                            		<td class="business_list_"><?php if($holiday_list->holiday_end_date != '') { echo date("D, M d, Y",strtotime(@$holiday_list->holiday_end_date)) ;  } ?></td>
                            		<td class="business_list_"><?php echo  $holiday_list->session_year; ?></td>  
                            		<td>
                            		    <?php  if($holiday_list->is_active_session == 1) { ?> 
                            		    <?php  if($holiday_list->holiday_end_date >= date("Y-m-d")) { ?> 
                            			<a href="javascript:void(0)"   title="Delete this Holiday" onclick = "deleteholiday(<?php echo $holiday_list->holiday_id; ?>)" ><i class="fa fa-trash-o" style="font-size:20px;color:#151f31;"></i></a>
                            			<?php } ?>
                            			<?php } ?>
                            			<!--<?php if($holiday_list->displayflag1 == 1 ) { ?>
                            			<a href="<?php echo base_url(); ?>disable-holiday/<?php echo $holiday_list->holiday_id; ?>" title="disable"  ><i class="fa fa-ban" style="color:green;" style="font-size:25px;"></i></a>
                            			<?php } else { ?> 
                            			<a href="<?php echo base_url(); ?>enable-holiday/<?php echo $holiday_list->holiday_id; ?>"   title="enable"  ><i class="fa fa-ban" style="color:red;" style="font-size:25px;"></i></a>
                            			<?php } ?> -->
                            			&nbsp;&nbsp;
                            		</td>
                            	</tr>
                        
                        	<?php } } else { ?>
                        	<tr>
                        		<td colspan="4" class="business_list_"> You have no holiday added. <a href="<?php echo base_url(); ?>/add-holiday">Click here</a> to add one.</td>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Holidays List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the Holidays, you have added to this application for a specific Session-Year.</li>
                  <li >Make sure, to type correct name and dates before you save it because no EDIT allowed. </li>
                  <li >A holiday can be deleted only if it is in future date(s).</li>
                  <li >This is one time setup to add all the Holidays at the start of the Session-Year. However, you can always add one if missed out.</li>           
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
