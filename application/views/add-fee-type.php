 
<script>
$(document).ready(function(){  
    $(".check1").click(function(){  
        var name = $('#fee_type_name').val(); 
        var description = $('#elm1').val(); 
        var editors = textboxio.get('#elm1');
        var editor = editors[0];
        var flyer_desc = editor.content.get();  
        var flyer_desc1 = flyer_desc.replace(/&nbsp;/g,''); 
        var flyer_desc2 = flyer_desc1.replace(/ /g,'');    
        var linebreak = flyer_desc2.indexOf("<p><br/></p>");
     
      
        if(name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter fee type name</div>");
            $('#fee_type_name').css("border","1px solid red");
    		$('#fee_type_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#fee_type_name').css("border","1px solid #c9c9c9");
        }
        
        
        if(flyer_desc == '<p><br /></p>' || flyer_desc2 == '<p></p>' || flyer_desc2 == '' || linebreak >= 0)
        { 
            $('#errorMsg').html("<div class='alert alert-danger'>Please add the description</div>");
            $('#elm1').css("border","1px solid red");
        	 $('#elm1').focus();
	        return false; 
        } 
        else
        {
            $('#errorMsgImage').html("");
             $('#elm1').css("border","1px solid #c9c9c9");  
        }
          
        $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit(); 
    });
     
       
    });
    
</script>
 
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$fee_type_info['subject_id'] != '') { echo "Edit"; }else { echo "Add New";} ?> Fee Type  
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-fee-type-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  autocomplete="off" onsubmit="return Validate(this);"> 
                        <input type="hidden" name="fee_type_id" id="fee_type_id" value="<?php echo @$fee_type_info['students_fee_type_id']; ?>"> 
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <input type="text" class="form-control   test" id="fee_type_name"  name="fee_type_name" placeholder="Fee Type Name" value="<?php echo @$fee_type_info['fee_type'];  ?>" data-toggle="tooltip" data-placement="top" title="Fee Type name" required="true" autocomplete="off" >
                            </div>
                            <div class="form-group"> 
                                <textarea rows="3"   name="description" id="elm1" placeholder="Enter description..." class=" widgEditor nothing" style="width: 100%; height: 250px;"><?php echo @$fee_type_info['description']; ?></textarea> 
                            </div>  
                            <div class="row" style="margin-bottom:20px;margin-top: 20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12  "  id="  signup" name="update" value="Submit"> 
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
 
 

<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add New Fee-Type</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Here you add all the FEE-TYPES, you are going to use to collect from STUDENTS.</li>
                  <li >Once you create a FEE-TYPE, it cannot be modified so you need to be careful before saving it. </li>
                  <li >These FEE-TYPES will be used when you create Class-Register-Fee for each month for all 12 months for the session-year.</li>
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
