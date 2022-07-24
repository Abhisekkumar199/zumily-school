 
<!--CENTER SECTION-->
 <div class="tz-2 mainContant" style="background-color:#ffffff;">
<div class="tz-2-com tz-2-main">   
	<div class="row" style="background: #d5d5d5;" >
		<div class="col-md-12 col-xs-126" > 
			<h4>Classes List
			<a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
			<a href="<?php echo base_url(); ?>class-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
			<a  style=" margin-right: 10px;" class=" pull-right" href="<?php echo base_url();?>add-class"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a>
			</h4>
		</div> 
	</div>
        
	<div class="col-sm-12 fullWidth-tab">
		<div class="panel panel-bd lobidrag"> 
            <div class="panel-body" id="result"> 
            	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	<table class="table table-hover">
                    	<thead>
                        	<td class="col-md-3"><span ><a href="javascript:void(0)" name="order" class="button" column_value="flyer_name" link_value="desc"  value="delivery">Class Name </a></span></td> 
                        	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Section</a></span>  </td>  
                        	<td class="text-right">Action</td>
                    	</thead>
                    	<tbody>
                    	<?php
                     	if(@$totalrecord > 0)
                    	{
                    	foreach($class_lists as $class)
                    	{
                    	?>
                
            	        <tr class=" "   >
                    		<td class="business_list_"><?php echo $class->class_name; ?></td>
                    
                    		<td class="business_list_"><?php echo $class->section; ?></td> 
                    		<td class="text-right">  
                    		    <?php if($class->total_class_connected == 0) { ?>
                    		    <a href="javascript:void(0)" title="Delete this Class" onclick = "delete_class(<?php echo $class->class_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;color:#151f31;"></i></a>&nbsp;
                    			<a href="<?php echo base_url(); ?>update-class/<?php echo base64_encode($class->class_id); ?>"   title="Edit this Class"  ><i class="fa fa-pencil" style="font-size:20px;color:#151f31;"></i></a>
                    		    <?php } ?>
                    			<!--<?php if($class->displayflag == 1 ) { ?>
                    			<a href="<?php echo base_url(); ?>disable-class/<?php echo $class->class_id; ?>" title="disable"  ><i class="fa fa-ban" style="color:green;" style="font-size:25px;"></i></a>
                    			<?php } else { ?> 
                    			<a href="<?php echo base_url(); ?>enable-class/<?php echo $class->class_id; ?>"   title="enable"  ><i class="fa fa-ban" style="color:red;" style="font-size:25px;"></i></a>
                    			<?php } ?> -->
                    		</td>
                    	</tr>
                
                	<?php } } else { ?>
                	<tr>
                		<td colspan="4" class="business_list_"> You have no class added. <a href="<?php echo base_url(); ?>/add-class">Click here</a> to add one.</td>
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
function delete_class(val1)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to remove this class?", function (e) 
    { 
        if (e) 
        { 
        	var pass_data = {class_id: val1};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-class",
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Classes List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the Classes and Sections, you have added to this application.</li>
                  <li >You can Edit/Delete these Classes only if not being assigned to any Class-Register. </li>
                  <li >Once you assign a Class to a Class-Register, Zumily-School application won't let you Edit and/or delete for your safety.</li>
                  <li >This is one time setup to add all the classes. However, you can always add one if missed out.</li>           
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