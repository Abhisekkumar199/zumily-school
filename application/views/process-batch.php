 <div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 style="font-size: 14px;"><?php if(@$student_info['student_id'] != '') { echo " "; }else { echo " ";} ?> Batch Data  </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <?php
                    $success = $this->session->userdata('success'); 
                    if (!empty($success)) 
                    {
                        echo  $success;
                        $this->session->unset_userdata('success');
                    }  
                    ?>
                    <form id="formCheck" action="<?php echo base_url();?>/process-batch-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  aautocomplete="off" onsubmit="return Validate(this);"> 
                        
                        <input type="hidden" name="batch_id" id="batch_id" value="<?php echo $batch_id;  ?>"> 
                        <div class="col-md-12"> 
                        
                            <p><strong>Batch Id: </strong><?php echo $batch_id;  ?></p>
                            
                            <p><strong>Total Record: </strong><?php echo $total_batch_record;  ?></p>
                            
                           
                        </div> 
                        <div class="col-md-12">  
                            <div class="row" style="margin-bottom:20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="btn btn-success col-md-12  "  id="  class" name="update" value="Upload"> 
                                </div> 
                            </div>  
                        </div> 
                    </form>
                </div>  
            </div>
        </div>
    </div> 
</div> 
</div>
</div>
 
 
