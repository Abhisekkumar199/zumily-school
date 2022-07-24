 <!--CENTER SECTION-->
 <div class="tz-2 mainContant" style="background-color:#ffffff;">
<div class="tz-2-com tz-2-main"> 
	<div class="row" style="background: #d5d5d5;" >
		<div class="col-md-12 col-xs-12" > 
			<h4>Fee Types List
			    <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
			    <a href="<?php echo base_url(); ?>create-fee-type-pdf" target="_blank"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
			    <a  style=" margin-right: 10px;" class=" pull-right" href="<?php echo base_url();?>add-fee-type"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a> 
			</h4> 
		</div>
	</div> 
	<div class="col-sm-12 fullWidth-tab">
		<div class="panel panel-bd lobidrag"> 
             
            <div class="panel-body" id="result"> 
            	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	<table class="table table-hover">
                    	<thead>
                        	<td class="col-md-3"><span ><a href="javascript:void(0)" name="order" class="button" column_value="flyer_name" link_value="desc"  value="delivery">Fee Type </a></span></td> 
                        	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Description</a></span>  </td>  
                        	<td class="text-right">Action</td>
                    	</thead>
                    	<tbody>
                    	<?php
                     	if(@$totalrecord > 0)
                    	{
                    	foreach($fee_types_lists as $fee_type)
                    	{
                    	?>
                
            	        <tr class=" "   >
                    		<td class="business_list_"><?php echo $fee_type->fee_type; ?></td>
                    
                    		<td class="business_list_"><?php echo $fee_type->description; ?></td> 
                    		
                    		<td class="text-right" >   
                    		   <!-- <a href="javascript:void(0)" title="Delete this Subject" onclick = "delete_fee_type(<?php echo $fee_type->students_fee_type_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;"></i></a>&nbsp;
                    		    <a href="<?php echo base_url(); ?>update-fee-type/<?php echo $fee_type->students_fee_type_id; ?>"   title="Edit this Subject"  ><i class="fa fa-edit" style="font-size:20px;"></i></a>
                    		   -->
                    			<!--<?php if($fee_type->displayflag == 1 ) { ?>
                    			<a href="<?php echo base_url(); ?>disable-subject/<?php echo $fee_type->students_fee_type_id; ?>" title="disable"  ><i class="fa fa-ban" style="color:green;" style="font-size:25px;"></i></a>
                    			<?php } else { ?> 
                    			<a href="<?php echo base_url(); ?>enable-subject/<?php echo $fee_type->students_fee_type_id; ?>"   title="enable"  ><i class="fa fa-ban" style="color:red;" style="font-size:25px;"></i></a>
                    			<?php } ?> --> 
                    		</td>
                    	</tr>
                
                	<?php } } else { ?>
                	<tr>
                		<td colspan="4" class="business_list_"> You have no fee type added. <a href="<?php echo base_url(); ?>/add-fee-type">Click here</a> to add one.</td>
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
 
<script>  
function delete_fee_type(val1)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to remove this record?", function (e) 
    { 
        if (e) 
        { 
        	var pass_data = {fee_type_id: val1};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-fee-type",
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


<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Fee-Types List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the FEE-TYPES, you have created so far.</li>
                  <li >All Fee Types are displayed in alphabetical order. </li>
                  <li >These FEE-TYPES will be used when you setup Class-Register-Fee for each month for all 12 months for a session-year.</li>
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
