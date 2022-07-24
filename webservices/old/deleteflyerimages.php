<?php
session_start();
require_once 'include/DB_Functions.php';
   
$imageId = $_REQUEST['imageId'];
$flyertype = $_REQUEST['imagetype']; 
if($flyertype !='1') 
{
    
    $sqlQueryDelete = mysqli_fetch_array(mysqli_query($conn,"select * from  flyer_images where flyer_image_id='".$imageId."'")); 
	$file = $sqlQueryDelete['flyer_image_name'];
	chmod("../mediaimage/".$file, 0644);
	if(unlink("../mediaimage/".$file))
	{ 
	    
	}
	else
	{
		
	}
     mysqli_query($conn,"delete from  flyer_images where flyer_image_id='".$imageId."'");
    
}
else
{
    
 
	$sqlQueryDelete = mysqli_fetch_array(mysqli_query($conn,"select * from  flyer where flyer_id='".$imageId."'")); 
	$file = $sqlQueryDelete['image'];
	chmod("../mediaimage/".$file, 0644);
	if(unlink("../mediaimage/".$file))
	{ 
	    
	}
	else
	{
		
	}
    mysqli_query($conn,"update  flyer set image='' where flyer_id='".$imageId."'");
}

 
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);  
 
    
 
?>