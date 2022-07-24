<script>
$(document).ready(function(){ 
    $(".admin-user").click(function(){
        $(".admin-user .dropdown-menu").toggleClass("main");
    });
    $(".check1").click(function(){ 
        var uploaded = $('#uploaded').val();   
        
        if(uploaded == '')
        {
            $('#errorMsg').html("Please select file");
            $('#uploaded').css("border","1px solid red");
    		$('#uploaded').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#uploaded').css("border","1px solid #c9c9c9");
        } 
    });  
}); 
</script> 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 style="font-size: 19px;"> Upload Student Data <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/import-student-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  aautocomplete="off" > 
                        <input type="hidden" name="studentId" id="studentId" value="<?php echo @$student_info['student_id']; ?>"> 
                        <div class="col-md-12"> 
                            <p> <a href="<?php echo base_url();?>/assets/Students_upload_template.csv" class="pull-right"><strong>Student Upload Sample template: </strong> <i class="fa fa-file-excel-o text-right" style="font-size:36px;" aria-hidden="true"></i></a></p>
                            <div class="clearfix"></div>
                            <p>Data should be in CSV format only</p>
                            <p><strong>PLEASE KEEP FIRST LINE AS HEADER, DO NOT DELETE</strong></p>
                            <p>File should be in same order as</p>
                            <p><strong>First Name, Middle Name,	Last Name, Reg No., Gender, Mobile No., Email Address, Father Name, Mother Name, Parent Mobile No.,	Parent Email, Address, Date of Birth</strong></p>
                             
                                <input name="uploaded" id="uploaded" type="file" accept=".csv" style="width: 100%;"  /> 
                             
                             <span id="errorMsg"></span>
                        </div> 
                        <div class="col-md-12">  
                            <div class="row" style="margin-bottom:20px;margin-top:20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12  "  id="  class" name="update" value="Upload"> 
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
 
 
