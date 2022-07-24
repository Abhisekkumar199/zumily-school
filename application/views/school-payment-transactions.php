  
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent" >
    <div class="tz-2-com tz-2-main"> 
         
    	<div class="row" style="background: #d5d5d5;" >
    		<div class="col-md-12 col-xs-12" > 
    			<h4>Payment Transactions 
    			    <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
    		    <?php if($this->input->cookie('is_payble',true) == 1) { ?>
    		    
    		        <?php if($this->input->cookie('is_paid',true) == 1) { ?>
    			        <a  style="  margin: -5px;margin-right:10px;" class="btn btn-success dropdown-toggle height-36 pull-right disabled" href="#">Invoice Payment </a>
    			       
    			<?php } else { ?> 
    			         <a  style="  margin: -5px;margin-right:10px;" class="btn btn-success dropdown-toggle height-36 pull-right" href="<?php echo base_url();?>add-school-payment">Invoice Payment </a>
    			    
    			<?php } } ?>
    			</h4>
    		</div>
    	</div> 
    	<div class="col-sm-12 fullWidth-tab">
    	    <?php if($this->input->cookie('is_payble',true) == 1) { ?>
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
                    
                    
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                    	<table class="table table-hover">
                        	<thead> 
                            	<td ><span ><a href="javascript:void(0)" style="margin-left:40px;"  >Invoice No.</a></span></td> 
                            	<td  ><span ><a href="javascript:void(0)"  >Amount</a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Transaction Date</a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Valid Until</a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Status</a></span></td> 
                            	<td  ><span ><a href="javascript:void(0)"  >Verified Date</a></span></td>  
                            	<td class="text-right">Action</td>
                        	</thead>
                        	<tbody>
                        	<?php
                         	if(@$totalrecord > 0)
                        	{
                        	foreach($payment_lists as $payment)
                        	{
                        	?> 
                	        <tr class=" "   >
                        	 
                        		<td class="business_list_"><?php echo $payment->school_payment_transaction_id; ?></td> 
                        		<td class="business_list_"><?php echo $payment->amount_paid; ?></td> 
                        		<td class="business_list_"><?php if($payment->transaction_date!= ''){echo date("D, M d, Y",strtotime($payment->transaction_date)); } ?></td> 
                        		<td class="business_list_"><?php if($payment->valid_until!= ''){echo date("D, M d, Y",strtotime($payment->valid_until)); } ?></td>   
                        		<td class="business_list_"><?php echo $payment->is_verified; ?></td> 
                        		<td class="business_list_"><?php if($payment->verified_datetime!= ''){echo date("D, M d, Y",strtotime($payment->verified_datetime)); } ?></td>   
                        		<td class="text-right">  
                        			<a href="<?php echo base_url(); ?>update-student/<?php echo $payment->school_payment_transaction_id; ?>"   title="edit"  ><i class="fa fa-edit" style="font-size:20px;"></i></a>
                        		 
                        		</td>
                        	</tr>
                    
                    	<?php } } else { ?>
                    	<tr>
                    		<td colspan="4" class="business_list_"> You have no payment transactions to list. </td>
                    	</tr>
                    	<?php } ?>
                    	</tbody>
                    	</table>
                	</div>
                	
            	</div> 
    		</div>
    		<?php } else { ?>
                	<p class="text-center" style="color:red;font-size:20px;margin-top:60px;"><strong>*** Congratulations!!! ***</strong></p>
                	<p class="text-center" style="color:red;font-size:16px;margin-bottom:60px;">You have Owner granted LIFE-TIME FREE memebreship</p>
        	<?php } ?>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - School Payment Transactions</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the Payment-Transactions, school has paid to use Zumily-School application.</li>
                  <li >If you have any questions, call repersentative or Zumily-Office. </li>
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
