 
<style>
    [type="radio"]:not(:checked) + label, [type="radio"]:checked + label 
    { 
    font-size: 1.5rem!important; 
    margin-left: 0px!important;
    }
    .search-choice-close{
        display:none!important;
    }
</style>
 <style>
 .chosen-choices
 {
     height:250px!important;
 }
 .chosen-container-multi .chosen-choices li.search-choice .search-choice-close
 {
     background:url("chosen-sprite.png") -42px 1px no-repeat!important;
 }
</style>  
<link rel="stylesheet" href="https://www.zumily.com/multiselect/prism.css">
<link rel="stylesheet" href="https://www.zumily.com/multiselect/chosen.css"> 

<script>
$(document).ready(function(){ 
    $(".admin-user").click(function(){
        $(".admin-user .dropdown-menu").toggleClass("main");
    });
    $(".check1").click(function(){ 
        var memberids = $('#memberids').val();  
	   
      
        
        if(memberids =='')
        {
            $('#errorMsg').html("Please select student"); 
            $('#memberids').css("border","1px solid red");
    		$('#memberids').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
            $('#memberids').css("border","1px solid #c9c9c9");
        }  
        
    }); 
     
    });
    
</script>
 
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 style="font-size: 14px;"><?php if(@$student_info['student_id'] != '') { echo "Update Map"; }else { echo "Map";} ?> Student  </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/map-student-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  aautocomplete="off" onsubmit="return Validate(this);"> 
                        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo @$class_register_id; ?>"> 
                        <input type="hidden" name="totalstudent" id="totalstudent" value="<?php echo @$totalstudent; ?>"> 
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?></p>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="margin-top: 7px;">   
                                <select style="height:250px;" name="memberids[]" id="memberids" data-placeholder="Search and add students to this class" multiple class="chosen-select-no-results" tabindex="19" >
                                    <option value=""></option>
                                    
                                    <?php  foreach($class_register_student_lists as $class_register_student) { ?>
                                    <option value="<?php echo $class_register_student->student_id; ?>-1"  selected ><?php echo $class_register_student->first_name." ".$class_register_student->middle_name." ".$class_register_student->last_name." (".$class_register_student->father_name."  -  ".$class_register_student->parent_mobile_no.")"; ?></option>
                                    <?php } ?> 
                                    
                                    <?php  foreach($student_lists as $student) { ?>
                                    <option value="<?php echo $student->student_id; ?>-0" <?php if(in_array($student->student_id, @$class_student_lists)) { echo "selected=selected";} ?>><?php echo $student->first_name." ".$student->middle_name." ".$student->last_name." (".$student->father_name."  -  ".$student->parent_mobile_no.")"; ?></option>
                                    <?php } ?> 
                              </select> 
                            </div>
                        </div> 
                        <div class="col-md-12">  
                            <div class="row" style="margin-bottom:20px;margin-top:20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12  "  id="  class" name="update" value="Submit"> 
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
 
 
<script src="https://www.zumily.com/multiselect/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="https://www.zumily.com/multiselect/chosen.jquery.js" type="text/javascript"></script>
<script src="https://www.zumily.com/multiselect/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="https://www.zumily.com/multiselect/init.js" type="text/javascript" charset="utf-8"></script>
