 
<section id="content">
<div class="tz">
<div class="tz-l tz1sidebar" id="tz1sidebar"> 
    <div class="tz-l-2 left_panel_sec" > 
    <!-- sidebar menu --> 
        <div class="col-sm-12 mainMenu" style="display:none" ><i class="fa fa-bars"></i>Menu</div> 
        <ul class=" leftMenu  " style="max-height: 600px; overflow-y: scroll;"  >  
            <li class=""><a href="<?php echo base_url();?>dashboard"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/dashboard.png">Dashboard</a></li>  
            <li class=""><a href="<?php echo base_url();?>homework"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/homework.png">Homework</a></li>    
            <li class=""><a href="<?php echo base_url();?>attendance"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/attendance.png">Attendance</a></li>   
            <li class=""><a href="<?php echo base_url();?>messages-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/message.png">Messages</a></li>   
            <li class=""><a href="<?php echo base_url();?>events-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/event.png">Events</a></li>   
            <li class=""><a href="<?php echo base_url();?>leave-request-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/homework64kb.png">Leave Requests</a></li> 
            <div class="spacer-10" style="margin-bottom:3px; margin-top:3px"></div> 
            
            <li class="<?php if($this->uri->segment('1') == "school-info" or $this->uri->segment('1') == "subjects-list" or $this->uri->segment('1') == "classes-list" or $this->uri->segment('1') == "sessions-list" or $this->uri->segment('1') == "holidays-list" or $this->uri->segment('1') == "teachers-list" or $this->uri->segment('1') == "students-list" or $this->uri->segment('1') == "classes-register-list") { ?> open <?php } ?> parent_menu  " >
                <a class="dropdown" id="menu1"  data-toggle="dropdown" href="<?php echo base_url();?>classes-register-list" >
                    <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/setup.png">School Setup&nbsp;<i class="fa fa-caret-down pull-right" style="margin-top: 5px;" aria-hidden="true"></i>
                </a>    
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="position: relative!important;border:none;box-shadow: none;">
                    <li class="submenu"><a href="<?php echo base_url();?>school-info"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/school.png"   > School Info</a></li>
                    <li class="submenu"><a href="<?php echo base_url();?>subjects-list">  <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/books.png"   > Subjects</a></li>    
                    <li class="submenu"><a href="<?php echo base_url();?>classes-list">  <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/class.png"   > Classes</a></li>    
                    <li class="submenu" ><a href="<?php echo base_url();?>sessions-list">  <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/session.png"   > Sessions</a></li>  
                    <li class="submenu"><a href="<?php echo base_url();?>holidays-list">  <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/holiday.png"   > Holidays</a></li>  
                    <li class="submenu"><a href="<?php echo base_url();?>teachers-list">  <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/teacher.png"   > Teachers</a></li>  
                    <li class="submenu"><a href="<?php echo base_url();?>students-list"> <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/students.png"   > Students  </a></li>   
                    <li class="submenu"><a href="<?php echo base_url();?>classes-register-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/classes.png"   > Class Registers </a></li> 
                </ul> 
            </li>
            
            
            
            <div class="spacer-10" style="margin-bottom:3px; margin-top:3px"></div> 
            <li <?php if($this->uri->segment('1') == "fee-types-list" or $this->uri->segment('1') == "fee-concessions" or $this->uri->segment('1') == "class-register-fee" or $this->uri->segment('1') == "school-fee-payment" or $this->uri->segment('1') == "students-additional-fee") { ?> class="open" <?php } ?> >
                <a class="dropdown-toggle" id="menu2"  data-toggle="dropdown" href="<?php echo base_url();?>classes-register-list" >
                    <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/money.png">Student Fee Section<i class="fa fa-caret-down pull-right" style="margin-top: 5px;" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu2" style="position: relative!important;border:none;box-shadow: none;" >
                    <li ><a href="<?php echo base_url();?>fee-types-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/rupee64kb.png"   > Fee Types</a></li>
                    <li ><a href="<?php echo base_url();?>class-register-fee"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/rupee64kb.png"   > Class Register Fee</a></li>
                    <li ><a href="<?php echo base_url();?>fee-concessions"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/coupon.png"   >Fee Concession</a></li> 
                    <li ><a href="<?php echo base_url();?>students-additional-fee"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/web-site.png"   >Student Additional Fee</a></li> 
                    <li ><a href="<?php echo base_url();?>school-fee-payment"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/payment64kb.png"   >Student Fee Payment</a></li>  
                    <li ><a href="<?php echo base_url();?>late-fee-reminder-students-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/payment64kb.png"   >UnpaidFee Students List</a></li>   
                    <li ><a href="<?php echo base_url();?>late-fee-reminder-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/fee.png"   >Past Reminders</a></li>   
                </ul> 
            </li>
            
            <!--<div class="spacer-10" style="margin-bottom:3px; margin-top:3px"></div> 
            <li <?php if($this->uri->segment('1') == "report-card" or $this->uri->segment('1') == "transfer-certificate") { ?> class="open" <?php } ?> >
                <a class="dropdown-toggle" id="menu2"  data-toggle="dropdown" href="<?php echo base_url();?>classes-register-list" >
                    <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/documents.png">Students Documents<i class="fa fa-caret-down pull-right" style="margin-top: 5px;" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu2" style="position: relative!important;border:none;box-shadow: none;" >
                    <li ><a href="<?php echo base_url();?>report-card"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/reportcard.png"   >Report Card</a></li>
                    <li ><a href="<?php echo base_url();?>transfer-certificate"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/transfer.png"   >Transfer Certificate</a></li> 
                </ul> 
            </li>-->
            
            
            <div class="spacer-10" style="margin-bottom:3px; margin-top:3px"></div> 
            <li <?php if($this->uri->segment('1') == "report-card" or $this->uri->segment('1') == "transfer-certificate") { ?> class="open" <?php } ?> >
                <a class="dropdown-toggle" id="menu2"  data-toggle="dropdown" href="<?php echo base_url();?>classes-register-list" >
                    <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/documents.png">Report Cards<i class="fa fa-caret-down pull-right" style="margin-top: 5px;" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu2" style="position: relative!important;border:none;box-shadow: none;" >
                    <li ><a href="<?php echo base_url();?>grades-list"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/reportcard.png"   >Setup Grades</a></li> 
                    <li ><a href="<?php echo base_url();?>reporting-periods"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/reportcard.png"   >Reporting Periods</a></li> 
                    <li ><a href="<?php echo base_url();?>report-card-classes"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/reportcard.png"   >Report Card</a></li>
                </ul> 
            </li>
            
            
            <div class="spacer-10" style="margin-bottom:3px; margin-top:3px"></div> 
            <li <?php if($this->uri->segment('1') == "fee-collection" or $this->uri->segment('1') == "student-fee-receipt") { ?> class="open" <?php } ?> >
                <a class="dropdown-toggle" id="menu2"  data-toggle="dropdown" href="#" >
                    <img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/report.png">Reports<i class="fa fa-caret-down pull-right" style="margin-top: 5px;" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu2" style="position: relative!important;border:none;box-shadow: none;" >
                    <li ><a href="<?php echo base_url();?>fee-collection"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/money.png"   > Fee Collection</a></li> 
                    <li ><a href="<?php echo base_url();?>student-fee-receipt"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/receipt.png"   > Student Fee Receipt</a></li> 
                </ul> 
            </li>
            <li><a href="<?php echo base_url();?>school-payments-transactions"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/pay.png"   > School Payments</a></li>  
            
            <div class="spacer-10" style="margin-bottom:3px; margin-top:3px"></div> 
            <li><a href="<?php echo base_url();?>faq" target="_blank"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/faq64k.png"  > FAQ</a></li> 
            <li><a href="<?php echo base_url(); ?>change-password"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/pass.png"   > Change Password</a></li>  
            <li><a href="<?php echo base_url(); ?>logout"><img  style="width:28px;height:28px;" src="https://localhost/project/zumilyschool/assets/icons/logout.png"> Logout</a></li> 
        </ul> 
    </div>
</div>