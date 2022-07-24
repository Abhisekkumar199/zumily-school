 
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent" >
    <div class="tz-2-com tz-2-main"> 
        <div id="snackbar">Batch updated Successfully!</div> 
    	<div class="row" style="background: #d5d5d5;" >
    		<div class="col-md-12 col-xs-12" > 
    			<h4>Batch List <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4>
    		</div> 
    	</div> 
    	<div class="col-sm-12 fullWidth-tab">
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                    	<table class="table table-hover">
                        	<thead>
                            	<td  ><span ><a href="javascript:void(0)"  >Batch Id </a></span></td> 
                            	<td class="col-md-3"><span ><a href="javascript:void(0)"  >Total Students </a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Successful Processed</a></span></td> 
                            	<td  ><span ><a href="javascript:void(0)"  >Total Errors </a></span></td> 
                            	<td class="pull-right">Action</td>
                        	</thead>
                        	<tbody>
                        	<?php
                         	if(@$totalrecord > 0)
                        	{
                        	foreach($batch_lists as $batchs)
                        	{
                        	?> 
                	        <tr class=" "   > 
                        		<td class="business_list_"><?php echo $batchs->batch_id; ?></td> 
                        		<td class="business_list_"><?php echo $batchs->total_students; ?></td>  
                        		<td class="business_list_"><?php echo $batchs->successful_processed; ?></td>
                        		<td class="business_list_"><?php echo $batchs->total_errors; ?></td> 
                        		<td class="pull-right">  
                        		 
                        		</td>
                        	</tr>
                    
                    	<?php } } else { ?>
                    	<tr>
                    		<td colspan="4" class="business_list_"> You have no batch created.</td>
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
  