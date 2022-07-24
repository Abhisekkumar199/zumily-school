<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home'; 
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// school sign up and login process
$route['signup'] = 'school/signup';   
$route['signup-process'] = 'school/signupProcess';  
$route['verify-school/(:any)'] = 'school/verifySchool/$i'; 
$route['verify-mobile'] = 'school/verifyMobile';  
$route['verify-mobileno-process'] = 'school/verifyMobileProcess'; 
$route['verify-forgot-password-mobile'] = 'school/verifyForgetPasswordOtp'; 
$route['forgot-password'] = 'school/forgotPassword';  
$route['forgot-password-process'] = 'school/forgotPasswordProcess';  
$route['verify-account'] = 'school/verifyMobileLogin'; 
$route['verify-user/(:any)'] = 'user/verifyUser/$i'; 
$route['check-school-email'] = 'school/checkSchoolEmail';  
$route['school-login'] = 'school/schoolLogin';   
$route['login'] = 'school/login'; 

//school info and update
$route['school-info'] = 'school/schoolInfo'; 
$route['school-information'] = 'school/schoolUpdate'; 
$route['update-school-process'] = 'school/updateSchoolInfo'; 
$route['crop-school-image'] = 'school/cropSchoolImage';   
$route['change-password'] = 'school/changePassword'; 
$route['change-password-process'] = 'school/changePasswordProcess';   
$route['set-new-mobile'] = 'school/SetNewPassword';   
$route['set-new-password-process'] = 'school/SetNewPasswordProcess';  
$route['reset-subscription-status'] = 'school/resetSubscriptionStatus';  
$route['logout'] = 'school/logout';  

// school payment page
$route['school-payments-transactions'] = 'schoolpayments/schoolPaymentTransactions'; 
$route['add-school-payment'] = 'schoolpayments/addPayment';  
$route['add-school-payment-process'] = 'schoolpayments/addSchoolPaymentProcess';
  
 // dashboard page 
$route['dashboard'] = 'dashboard/dashboard';  

// subject page
$route['check-subjectname'] = 'subject/checkSubjectname';   
$route['subjects-list'] = 'subject/subjectList';  
$route['add-subject'] = 'subject/addSubject';   
$route['add-subject-process'] = 'subject/addSubjectProcess';  
$route['update-subject/(:any)'] = 'subject/editSubject/$i';  
$route['enable-subject/(:any)'] = 'subject/enableSubject/$i';  
$route['disable-subject/(:any)'] = 'subject/disableSubject/$i';
$route['delete-subject'] = 'subject/delete_subject';  
$route['subject-pdf'] = 'subject/create_subject_pdf';


// class page
$route['check-classname'] = 'classes/checkClassname';   
$route['classes-list'] = 'classes/classList';  
$route['add-class'] = 'classes/addClass';   
$route['add-class-process'] = 'classes/addClassProcess';  
$route['update-class/(:any)'] = 'classes/editClass/$i';  
$route['enable-class/(:any)'] = 'classes/enableClass/$i';  
$route['disable-class/(:any)'] = 'classes/disableClass/$i';
$route['delete-class'] = 'classes/delete_class';   
$route['class-pdf'] = 'classes/create_class_pdf'; 
 
 
// session page
$route['check-session'] = 'sessionyear/checkSession';   
$route['sessions-list'] = 'sessionyear/sessionlist'; 
$route['add-session'] = 'sessionyear/addSession';  
$route['add-session-process'] = 'sessionyear/addSessionProcess';  
$route['update-session/(:any)'] = 'sessionyear/editSession/$i';  
$route['enable-session/(:any)'] = 'sessionyear/enableSession/$i';  
$route['disable-session/(:any)'] = 'sessionyear/disableSession/$i';  
$route['check-session-start-date'] = 'sessionyear/checkSessionStartDate';
$route['session-pdf'] = 'sessionyear/create_session_pdf';


// holiday page
$route['check-holiday'] = 'holiday/checkHoliday';   
$route['holidays-list'] = 'holiday/holidayList'; 
$route['add-holiday'] = 'holiday/addHoliday'; 
$route['add-holiday-process'] = 'holiday/addHolidayProcess';  
$route['update-holiday/(:any)'] = 'holiday/editHoliday/$i';  
$route['enable-holiday/(:any)'] = 'holiday/enableHoliday/$i';  
$route['disable-holiday/(:any)'] = 'holiday/disableHoliday/$i';  
$route['delete-holiday/(:any)'] = 'holiday/deleteHoliday/$i';  
$route['holiday-pdf'] = 'holiday/create_holiday_pdf'; 


// teacher page
$route['check-teacher-email'] = 'teacher/checkTeacherEmail';  
$route['check-teacher-mobile'] = 'teacher/checkTeacherMobile';   
$route['teachers-list'] = 'teacher/teacherList';     
$route['terminated-teacher'] = 'teacher/terminatedTeacherList';  
$route['add-teacher'] = 'teacher/addTeacher';   
$route['add-teacher-process'] = 'teacher/addTeacherProcess';  
$route['update-teacher/(:any)'] = 'teacher/editTeacher/$i';  
$route['enable-teacher/(:any)'] = 'teacher/enableTeacher/$i';  
$route['disable-teacher/(:any)'] = 'teacher/disableTeacher/$i'; 
$route['teacher-pdf'] = 'teacher/create_teacher_pdf';


// student page
$route['students-list'] = 'student/studentList'; 
$route['add-student'] = 'student/addStudent';  
$route['add-student-process'] = 'student/addStudentProcess';  
$route['update-student/(:any)'] = 'student/editStudent/$i';  
$route['enable-student/(:any)'] = 'student/enableStudent/$i';  
$route['disable-student/(:any)'] = 'student/disableStudent/$i';
$route['check-if-student-exist'] = 'student/checkIfStudentExist'; 
$route['check-student-mobile'] = 'student/checkStudentMobile'; 
$route['student-pdf'] = 'student/create_student_pdf'; 
$route['batch-lists'] = 'batch/batchList';  
$route['import-student'] = 'student/importStudent'; 
$route['import-student-process'] = 'student/importStudentProcess';    
$route['process-batch'] = 'student/processBatch'; 
$route['process-batch-process'] = 'student/processBatchProcess'; 
$route['get-student-details'] = 'student/get_student_details';  

// class register page
$route['classes-register-list'] = 'classregister/classregisterList';  
$route['get-unallocated-classes'] = 'classregister/getUnallocatedClasses'; 
$route['add-class-register'] = 'classregister/addClassregister';  
$route['add-classregister-process'] = 'classregister/addClassregisterProcess';  
$route['update-class-register/(:any)'] = 'classregister/editClassregister/$i';  
$route['enable-class-register/(:any)'] = 'classregister/enableClassregister/$i';  
$route['disable-class-register/(:any)'] = 'classregister/disableClassregister/$i';   
$route['delete-class-register'] = 'classregister/delete_class_register';  
$route['map-student/(:any)'] = 'classregister/mapStudent/$i';  
$route['map-student-process'] = 'classregister/mapStudentProcess';
$route['class-students/(:any)'] = 'classregister/classStudent/$i';  
$route['class-subject-teachers/(:any)'] = 'classregister/classSubjectTeacher/$i';
$route['add-class-register-students'] = 'classregister/add_class_register_student';
$route['add-class-register-subject-teacher/(:any)'] = 'classregister/add_class_register_subject_teacher/$i';
$route['update-class-register-student/(:any)'] = 'classregister/updateClassRegisterStudent/$i';  
$route['update-class-register-stream'] = 'classregister/update_class_register_stream';  
$route['add-student-to-class/(:any)'] = 'classregister/add_student_to_class/$i';
$route['add-student-to-class-process'] = 'student/add_student_to_class_process';   



$route['update-class-register-student-process'] = 'classregister/updateClassRegisterStudentProcess';  
$route['delete-student-document'] = 'classregister/delete_student_document';  
$route['delete-class-register-student'] = 'classregister/delete_class_student';  
$route['delete-class-register-sub-teacher'] = 'classregister/delete_subject_teacher';  
$route['delete-class-register-sub-teacher/(:any)'] = 'classregister/delete_subject_teacher';  
$route['class-register-pdf'] = 'classregister/create_class_register_pdf'; 
$route['class-register-pdf'] = 'classregister/create_class_register_pdf'; 
$route['class-register-students-pdf/(:any)'] = 'classregister/create_class_register_students_pdf/$i'; 
$route['class-register-teachers-pdf/(:any)'] = 'classregister/create_class_register_teachers_pdf/$i'; 

// attendance page
$route['attendance'] = 'dashboard/attendance'; 
$route['student-attendance/(:any)'] = 'classregister/studentAttendance/$i';
$route['student-attendance-process'] = 'classregister/studentAttendanceProcess';
$route['get-student-attendance'] = 'classregister/getStudentAttendance'; 

// message page
$route['messages-list'] = 'message/messageList'; 
$route['add-message'] = 'message/addMessage';  
$route['message-image-order/(:any)'] = 'message/messageImageOrder/$i'; 
$route['delete-message-image/(:any)'] = 'message/deleteMessageImage/$i'; 
$route['message-image-order-process'] = 'message/messageImageOrderProcess'; 
$route['add-message-process'] = 'message/addMessageProcess';
$route['message-details'] = 'message/messageDetails';
$route['delete-message/(:any)'] = 'message/deleteMessage/$i'; 
$route['message-pdf'] = 'message/message_pdf';  

// event page
$route['events-list'] = 'event/eventList'; 
$route['add-event'] = 'event/addEvent'; 
$route['add-event-process'] = 'event/addEventProcess';
$route['update-event/(:any)'] = 'event/updateEvent/$i';
$route['update-event-process'] = 'event/updateEventProcess'; 
$route['upload-event-images/(:any)'] = 'event/uploadEventImages/$i'; 
$route['delete-event/(:any)'] = 'event/deleteEvent/$i';  
$route['event-image-order/(:any)'] = 'event/eventImageOrder/$i'; 
$route['delete-event-image/(:any)'] = 'event/deleteEventImage/$i'; 
$route['event-image-order-process'] = 'event/eventImageOrderProcess'; 
$route['event-details'] = 'event/eventDetails';
$route['events-pdf'] = 'event/event_pdf';  
    
// leave request page     
$route['leave-request-list'] = 'leave_request/leave_request_list';   
$route['update-leave-request'] = 'leave_request/update_leave_request';  
$route['delete-leave-request/(:any)'] = 'leave_request/delete_leave_request/$i';  
$route['leave-request-details/(:any)'] = 'leave_request/leave_request_details/$i'; 
$route['leave-request-approval/(:any)'] = 'leave_request/leave_request_approval/$i'; 
$route['leave-request-pdf'] = 'leave_request/leave_request_pdf';  
$route['leave-request-pdf/(:any)'] = 'leave_request/leave_request_pdf/$i';  

// homework page
$route['homework'] = 'homework/homework_list'; 
$route['homework/(:any)'] = 'homework/homework_list/$i';  
$route['add-homework'] = 'homework/add_homework';  
$route['update-homework/(:any)'] = 'homework/update_homework'; 
$route['homework-document-order/(:any)'] = 'homework/homework_document_order/$i'; 
$route['delete-homework-document/(:any)'] = 'homework/delete_homework_document/$i'; 
$route['homework-document-order-process'] = 'homework/homework_document_order_process'; 
$route['add-homework-process'] = 'homework/add_homework_process';
$route['homework-details'] = 'homework/homework_details';
$route['homework-students/(:any)'] = 'homework/homework_student_list/$i';
$route['delete-homework/(:any)'] = 'homework/delete_homework/$i';  
$route['student-homework-details/(:any)'] = 'homework/student_homework_details/$i';
$route['update-student-homework-status'] = 'homework/update_student_homework_status';
$route['get-teacher-classes'] = 'homework/get_teacher_classes'; 
$route['homework-pdf'] = 'homework/create_homework_pdf'; 
$route['homework-pdf/(:any)'] = 'homework/create_homework_pdf/$i';  


// student fee type page
$route['fee-types-list'] = 'feetypes/fee_types_list';  
$route['add-fee-type'] = 'feetypes/add_fee_type';   
$route['add-fee-type-process'] = 'feetypes/add_fee_type_process';  
$route['update-fee-type/(:any)'] = 'feetypes/edit_fee_type/$i';  
$route['enable-fee-type/(:any)'] = 'feetypes/enable_fee_type/$i';  
$route['disable-fee-type/(:any)'] = 'feetypes/disable_fee_type/$i';
$route['delete-fee-type'] = 'feetypes/delete_fee_type'; 
$route['create-fee-type-pdf'] = 'feetypes/create_fee_type_pdf'; 

// class register fee page
$route['class-register-fee'] = 'classregisterfee/classregisterList';
$route['class-register-additional-fee/(:any)'] = 'classregisterfee/class_register_additional_fee/$i';
$route['class-register-additional-fee-process'] = 'classregisterfee/class_register_additional_fee_process';  
$route['update-class-register-additional-fee/(:any)'] = 'classregisterfee/update_class_register_additional_fee/$i';
$route['update-class-register-additional-fee-process'] = 'classregisterfee/update_class_register_additional_fee_process';  
$route['class-register-fee-details/(:any)'] = 'classregisterfee/class_register_fee_details/$i';
$route['class-register-fee-process'] = 'classregisterfee/class_register_fee_process';  
$route['get-month-schoolfee'] = 'classregisterfee/get_month_schoolfee';  
$route['create-class-register-fee-pdf/(:any)'] = 'classregisterfee/create_class_register_fee_pdf/$i'; 


// student fee concession page
$route['fee-concessions'] = 'feeconcession/fee_concession';  
$route['add-fee-concession-process'] = 'feeconcession/add_fee_concession_process';   
$route['disable-fee-concession'] = 'feeconcession/disable_fee_concession';
$route['disable-fee-concession/(:any)'] = 'feeconcession/disable_fee_concession/$i';
$route['fee-concessions/(:any)'] = 'feeconcession/fee_concession/$i';   
$route['student-search-for-fee-concession'] = 'global_controller/student_result_for_fee_concession';  
$route['fee-concession-pdf/(:any)'] = 'feeconcession/create_fee_concession_pdf/$i'; 
  
  
// school fee payment page 
$route['school-fee-payment'] = 'studentfeepayment/classregisterList';  
$route['class-register-students/(:any)'] = 'studentfeepayment/class_register_students/$i'; 
$route['update-class-register-student-fee/(:any)'] = 'studentfeepayment/update_class_register_student_fee/$i';  
$route['update-class-register-student-fee-process'] = 'studentfeepayment/update_class_register_student_fee_process'; 
$route['school-fee-payment-process'] = 'studentfeepayment/school_fee_payment_process';  
$route['get-month-fee-amount'] = 'studentfeepayment/get_month_fee_amount';  
$route['class-register-student-fee-pdf/(:any)'] = 'studentfeepayment/create_class_register_Student_fee_pdf/$i';
$route['late-fee-reminder-list'] = 'studentfeepayment/late_fee_reminder_list';  
$route['late-fee-reminder-students-list'] = 'studentfeepayment/late_fee_students_list';  
$route['school-late-fee-reminder-process'] = 'studentfeepayment/late_fee_reminder_process';  
$route['late-fee-reminder-students-list-pdf/(:any)'] = 'studentfeepayment/create_class_register_student_list_for_latefee_reminder_pdf/$i';
$route['late-fee-reminder-pdf/(:any)'] = 'studentfeepayment/create_latefee_reminder_pdf/$i';

$route['students-additional-fee'] = 'studentfeepayment/students_additional_fee_list'; 
$route['students-additional-fee/(:any)'] = 'studentfeepayment/students_additional_fee_list/$i';   
$route['add-additional-fee'] = 'studentfeepayment/add_additional_fee';    
$route['add-additional-fee-process'] = 'studentfeepayment/add_additional_fee_process';    
$route['student-search-for-additional-fee'] = 'global_controller/student_result_for_additional_fee'; 
 


$route['student-fee-receipt'] = 'studentfeepayment/student_fee_receipt'; 
$route['student-fee-receipt-pdf/(:any)'] = 'studentfeepayment/student_fee_receipt_pdf/$i';

$route['fee-collection'] = 'feecollection/school_fee_collection';
$route['fee-collection/(:any)'] = 'feecollection/school_fee_collection/$i';
$route['fee-collection-pdf/(:any)'] = 'feecollection/create_fee_collection_pdf/$i';
$route['monthly-fee-collection'] = 'feecollection/school_monthly_fee_collection'; 

// reprt cards section
$route['grades-list'] = 'Reportcard/grades_list'; 
$route['add-grade-process'] = 'Reportcard/add_grade_process';  
$route['check-if-grade-exist'] = 'Reportcard/check_if_grade_exist';  
$route['update-grade/(:any)'] = 'Reportcard/update_grade/$i';  
$route['delete-grade'] = 'Reportcard/delete_grade/$i';  
$route['reporting-periods'] = 'Reportcard/class_register_list'; 
$route['add-reporting-period/(:any)'] = 'Reportcard/add_reporting_period/$i'; 
$route['add-period-process'] = 'Reportcard/add_period_process';  
$route['report-card-classes'] = 'Reportcard/report_card_classes'; 
$route['report-card-class-students/(:any)'] = 'Reportcard/report_card_class_register_students/$i'; 
$route['update-class-register-student-report-card/(:any)'] = 'Reportcard/update_class_register_report_card/$i';
$route['update-class-register-student-report-card-process'] = 'Reportcard/update_class_register_report_card_process';
$route['get-reporting-class-period-subjects'] = 'Reportcard/get_reporting_class_period_subjects'; 
$route['class-register-student-report-card-pdf/(:any)'] = 'Reportcard/class_register_student_report_card_pdf/$i';

$route['update-reporting-period/(:any)'] = 'Reportcard/update_reporting_period/$i'; 
$route['update-period-process'] = 'Reportcard/update_period_process'; 


$route['report-card'] = 'studentdocument/report_card'; 
$route['transfer-certificate'] = 'studentdocument/transfer_certificate'; 




// school search
$route['ajax-auto-search'] = 'global_controller/get_search_result'; 
$route['student-search'] = 'global_controller/student_result'; 
$route['search-result'] = 'global_controller/search_result'; 
$route['search-result/(:any)'] = 'global_controller/search_result/$i';  
$route['teacher-search'] = 'global_controller/teacher_result';  

// static pages
$route['faq'] = 'pages/faq'; 
$route['privacy-policy'] = 'pages/privacyPolicy'; 
$route['terms-of-use'] = 'pages/termsOfuse';  
$route['contact-us'] = 'pages/contact_us';    
$route['contact-us-process'] = 'pages/contactUsProcess';   
 
 
// cron controllers
$route['system-created-account-signup-reminder'] = 'cron_controller/get_system_created_user'; 
$route['send-notification'] = 'cron_controller/send_notification'; 
$route['send-leave-request-notification-to-parent'] = 'cron_controller/send_leave_request_notification_to_parent'; 
$route['send-leave-request-notification-to-teacher'] = 'cron_controller/send_leave_request_notification_to_teacher'; 
$route['update-searchable-data'] = 'cron_controller/update_searchable_data'; 
$route['school-total-active-students'] = 'cron_controller/school_total_active_students'; 
$route['syncup-user-for-teacher-user-type'] = 'cron_controller/syncup_user_for_teacher_user_type'; 

//set current date time
$route['set-currentdate'] = 'global_controller/setCurrentdate'; 

