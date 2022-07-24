 
<script src="jquery.min.js" type="text/javascript"></script>
<?php  
if(@$_REQUEST['showmsg'] == 'update') { ?>
<script>
$(document).ready(function(){
 var x = document.getElementById("snackbar"); 
    x.className = "show"; 
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}); 
</script>
<?php  }  ?>
<?php  
if(@$_REQUEST['showmsg'] == 'add') { ?>
<script>
$(document).ready(function(){
 var x = document.getElementById("snackbar"); 
    $('#snackbar').html('Flyer added Successfully!');
    x.className = "show"; 
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}); 
</script>
<?php  }  ?>

 
<div class="tz-2 mainContant" style="background-color:#ffffff;">
    <div class="tz-2-com tz-2-main">
<h4>Manage Profile</h4>
<div class="db-list-com tz-db-table">
<div id="snackbar">Profile updated Successfully!</div>    
<table class="responsive-table bordered" style="width:100%">
<tbody>
 
<tr> 
    <td><strong>Full Name</strong></td> 
    <td>:</td> 
    <td><?php echo $user_info['contact_person']; ?></td> 
</tr> 
<tr>
    <td><strong>Email</strong></td>
    <td>:</td>
    <td><?php echo $user_info['email_id']; ?></td>
</tr> 
<tr>
    <td><strong>Phone</strong></td>
    <td>:</td>
    <td><?php echo $user_info['phone']; ?></td>
</tr>  
<tr>
    <td><strong>Principle Name</strong></td> 
    <td>:</td> 
    <td><?php echo $user_info['principal_name']; ?></td> 
</tr>
<tr>
    <td><strong>Vice Principle Name</strong></td> 
    <td>:</td> 
    <td><?php echo $user_info['vice_principal_name']; ?></td> 
</tr>
 

</tbody>

</table>


<div class="db-mak-pay-bot col-md-6 col-md-offset-3">

 

<a href="<?php echo base_url();?>edit-my-profile" class="btn btn-primary form-control" >Edit my profile</a> 
</div>


</div>

</div> 
</div>
 