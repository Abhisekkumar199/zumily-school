<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
      .panel-body { 
    float: none; 
    width: 100%;
        background-color: #fff;
    padding: 17px;
}
  </style>
</head>
<body>
<div class="container" style="margin-top:70px;">
  <h2 class="text-center" style="text-decoration-line: underline;">FAQs/Help</h2>
   <div class="panel-group" id="accordion">  
    <?php
    $x = 1;
    $order = '';
    foreach($faq_lists as $faq_list)
    { 
       if($faq_list->heading_order != $order)
       {
    ?>   
    <h3  ><?php echo $faq_list->heading; ?></h3>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading" style="padding: 11px!important;">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $x; ?>"><strong>Q.</strong> <?php echo $faq_list->question; ?></a>
        </h4>
      </div>
      <div id="collapse<?php echo $x; ?>" class="panel-collapse collapse <?php if($x == 1) { ?> in <?php } ?>">
        <div class="panel-body">
            <?php echo nl2br($faq_list->answer); ?>
        </div>
      </div>
    </div>
   <?php $order =  $faq_list->heading_order; $x++; }  ?>
    
    </div>
</div>
</body>
</html>

 