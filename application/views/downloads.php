<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->
<?php

$ip_download_overall_pdf = base_url('ipd/overall_pdf_report?fdate');
$ip_download_overall_excel = base_url('ipd/overall_excel_report?fdate');
$ip_download_patient_excel = base_url('ipd/overall_patient_report?fdate');
$ip_download_department_excel = base_url('ipd/overall_department_excel?fdate');
$ip_download_satisfied_list = base_url('ipd/download_satisfied_list?fdate');
$ip_download_unsatisfied_list = base_url('ipd/download_unsatisfied_list?fdate');
$ip_download_promoter_list = base_url('ipd/download_promoter_list?fdate');
$ip_download_passive_list = base_url('ipd/download_passive_list?fdate');
$ip_download_detractor_list = base_url('ipd/download_detractor_list?fdate');
$ip_downloadcomments = base_url('ipd/downloadcomments?fdate');
$ip_download_alltickets = base_url('ipd/download_alltickets?fdate');
$ip_download_opentickets = base_url('ipd/download_opentickets?fdate');
$ip_download_capa_report = base_url('ipd/download_capa_report?fdate');
$ip_download_staff_list = base_url('ipd/download_staff_list?fdate');

$pdf_download_overall_pdf = base_url('post/overall_pdf_report?fdate');
$pdf_download_overall_excel = base_url('post/overall_excel_report?fdate');
$pdf_download_patient_excel = base_url('post/overall_patient_report?fdate');
$pdf_download_department_excel = base_url('post/overall_department_excel?fdate');
$pdf_download_satisfied_list = base_url('post/download_satisfied_list?fdate');
$pdf_download_unsatisfied_list = base_url('post/download_unsatisfied_list?fdate');
$pdf_download_promoter_list = base_url('post/download_promoter_list?fdate');
$pdf_download_passive_list = base_url('post/download_passive_list?fdate');
$pdf_download_detractor_list = base_url('post/download_detractor_list?fdate');
$pdf_downloadcomments = base_url('post/downloadcomments?fdate');
$pdf_download_alltickets = base_url('post/download_alltickets?fdate');
$pdf_download_opentickets = base_url('post/download_opentickets?fdate');
$pdf_download_capa_report = base_url('post/download_capa_report?fdate');
$pdf_download_staff_list = base_url('post/download_staff_list?fdate');

$op_download_overall_pdf = base_url('opf/overall_pdf_report?fdate');
$op_download_overall_excel = base_url('opf/overall_excel_report?fdate');
$op_download_patient_excel = base_url('opf/overall_patient_report?fdate');
$op_download_department_excel = base_url('opf/overall_department_excel?fdate');
$op_download_satisfied_list = base_url('opf/download_satisfied_list?fdate');
$op_download_unsatisfied_list = base_url('opf/download_unsatisfied_list?fdate');
$op_download_promoter_list = base_url('opf/download_promoter_list?fdate');
$op_download_passive_list = base_url('opf/download_passive_list?fdate');
$op_download_detractor_list = base_url('opf/download_detractor_list?fdate');
$op_downloadcomments = base_url('opf/downloadcomments?fdate');
$op_download_alltickets = base_url('opf/download_alltickets?fdate');
$op_download_opentickets = base_url('opf/download_opentickets?fdate');
$op_download_capa_report = base_url('opf/download_capa_report?fdate');

$adf_download_overall_pdf = base_url('admissionfeedback/overall_pdf_report?fdate');
$adf_download_overall_excel = base_url('admissionfeedback/overall_excel_report?fdate');
$adf_download_patient_excel = base_url('admissionfeedback/overall_patient_report?fdate');
$adf_download_department_excel = base_url('admissionfeedback/overall_department_excel?fdate');
$adf_download_satisfied_list = base_url('admissionfeedback/download_satisfied_list?fdate');
$adf_download_unsatisfied_list = base_url('admissionfeedback/download_unsatisfied_list?fdate');
$adf_download_promoter_list = base_url('admissionfeedback/download_promoter_list?fdate');
$adf_download_passive_list = base_url('admissionfeedback/download_passive_list?fdate');
$adf_download_detractor_list = base_url('admissionfeedback/download_detractor_list?fdate');
$adf_downloadcomments = base_url('admissionfeedback/downloadcomments?fdate');
$adf_download_alltickets = base_url('admissionfeedback/download_alltickets?fdate');
$adf_download_opentickets = base_url('admissionfeedback/download_opentickets?fdate');
$adf_download_capa_report = base_url('admissionfeedback/download_capa_report?fdate');
$adf_download_staff_list = base_url('admissionfeedback/download_staff_list?fdate');

$pcf_download_alltickets = base_url('pc/download_alltickets?fdate');
$pcf_download_opentickets = base_url('pc/download_opentickets?fdate');
$pcf_download_capa_report = base_url('pc/download_capa_report?fdate');

$isr_download_alltickets = base_url('isr/download_alltickets?fdate');
$isr_download_opentickets = base_url('isr/download_opentickets?fdate');
$isr_download_capa_report = base_url('isr/download_capa_report?fdate');

$incident_download_alltickets = base_url('incident/download_alltickets?fdate');
$incident_download_opentickets = base_url('incident/download_opentickets?fdate');
$incident_download_capa_report = base_url('incident/download_capa_report?fdate');

$grievance_download_alltickets = base_url('grievance/download_alltickets?fdate');
$grievance_download_opentickets = base_url('grievance/download_opentickets?fdate');
$grievance_download_capa_report = base_url('grievance/download_capa_report?fdate');

//Main Heading for all modules
$ip_feedback_module = "IP discharge feedback module";
$pdf_feedback_module = "Post discharge feedback module";
$adf_feedback_module = "Admission feedback module";
$op_feedback_module = "Outpatient feedback module";
$pcf_comaplaint_module = "Patient complaints & requests module";
$esr_request_module = "Internal service request module";
$incident_module = "Incident management module";
$grievance_module = "Staff grievance module";

//ip
$ip_overall_feedback_report = "IP overall feedback report";
$ip_patient_wise_report = "IP patient wise report";
$ip_department_wise_report = "IP department wise report";
$ip_satisfied_patient_list = "IP satisfied patient list";
$ip_unsatisfied_patient_list = "IP unsatisfied patient list";
$ip_promoter_list = "IP promoter list";
$ip_passive_list = "IP passive list";
$ip_detractor_list = "IP detractor list";
$ip_recent_comment_list = "IP recent comment list";
$ip_all_tickets_list = "IP all tickets list";
$ip_open_tickets_list = "IP open tickets list";
$ip_closed_tickets = "IP closed tickets list";
$ip_capa_report = "IP CAPA report";
$ip_staff_recognition_report = "IP staff recognition report";

//pdf
$pdf_overall_feedback_report = "PDF overall feedback report";
$pdf_patient_wise_report = "PDF patient wise report";
$pdf_department_wise_report = "PDF department wise report";
$pdf_satisfied_patient_list = "PDF satisfied patient list";
$pdf_unsatisfied_patient_list = "PDF unsatisfied patient list";
$pdf_promoter_list = "PDF promoter list";
$pdf_passive_list = "PDF passive list";
$pdf_detractor_list = "PDF detractor list";
$pdf_recent_comment_list = "PDF recent comment list";
$pdf_all_tickets_list = "PDF all tickets list";
$pdf_open_tickets_list = "PDF open tickets list";
$pdf_closed_tickets = "PDF closed tickets list";
$pdf_capa_report = "PDF CAPA report";
$pdf_staff_recognition_report = "PDF staff recognition report";

//adf
$adf_overall_feedback_report = "ADF overall feedback report";
$adf_patient_wise_report = "ADF patient wise report";
$adf_department_wise_report = "ADF department wise report";
$adf_satisfied_patient_list = "ADF satisfied patient list";
$adf_unsatisfied_patient_list = "ADF unsatisfied patient list";
$adf_promoter_list = "ADF promoter list";
$adf_passive_list = "ADF passive list";
$adf_detractor_list = "ADF detractor list";
$adf_recent_comment_list = "ADF recent comment list";
$adf_all_tickets_list = "ADF all tickets list";
$adf_open_tickets_list = "ADF open tickets list";
$adf_closed_tickets = "ADF closed tickets list";
$adf_capa_report = "ADF CAPA report";
$adf_staff_recognition_report = "ADF staff recognition report";

//op
$op_overall_feedback_report = "OP overall feedback report";
$op_patient_wise_report = "OP patient wise report";
$op_department_wise_report = "OP department wise report";
$op_satisfied_patient_list = "OP satisfied patient list";
$op_unsatisfied_patient_list = "OP unsatisfied patient list";
$op_promoter_list = "OP promoter list";
$op_passive_list = "OP passive list";
$op_detractor_list = "OP detractor list";
$op_recent_comment_list = "OP recent comment list";
$op_all_tickets_list = "OP all tickets list";
$op_open_tickets_list = "OP open tickets list";
$op_closed_tickets = "OP closed tickets list";
$op_capa_report = "OP CAPA report";


//pcf
$pcf_all_tickets_list = "PC all complaints list";
$pcf_open_tickets_list = "PC open complaints list";
$pcf_closed_tickets = "PC closed complaints list";
$pcf_capa_report = "PC CAPA report";

//isr 
$esr_all_tickets_list = "ISR all requests list";
$esr_open_tickets_list = "ISR open requests list";
$esr_closed_tickets = "ISR closed requests list";
$esr_capa_report = "ISR CAPA report";

//incident
$incident_all_tickets_list = "INC all incidents list";
$incident_open_tickets_list = "INC open incidents list";
$incident_closed_tickets = "INC closed incidents list";
$incident_capa_report = "INC CAPA report";

//grievance
$grievance_all_tickets_list = "SG all grievances list";
$grievance_open_tickets_list = "SG open grievances list";
$grievance_closed_tickets = "SG closed grievances list";
$grievance_capa_report = "SG CAPA report";



//ip download page tooltip message 
$ip_overall_feedback_report_download_tooltip = "Download the comprehensive report of inpatient discharge feedback.";
$ip_patient_wise_report_download_tooltip = "Download the comprehensive raw patient feedback report, which comprises individual patient feedback data collected during the selected period.";
$ip_department_wise_report_download_tooltip = "Download the department-wise report, which provides insights into relative performance, distribution of negative experiences among various departments, and evaluates the efficiency of their responses.";
$ip_satisfied_patient_list_download_tooltip = "Download the list of satisfied inpatients—those who have rated above average and have not highlighted any negative experiences.";
$ip_unsatisfied_patient_list_download_tooltip = "Download the list of unsatisfied inpatients— those who have highlighted atleast one negative experience.";
$ip_promoter_list_download_tooltip = "Download the list of promoters: patients who gave a score of 9 or 10 when asked about recommending the hospital, indicating high satisfaction and loyalty.";
$ip_passive_list_download_tooltip = "Download the list of passives: patients scoring 7 or 8, indicating general satisfaction but not as high as promoters.";
$ip_detractor_list_download_tooltip = "Download the list of detractors: patients with scores from 0 to 6, indicating dissatisfaction, who may express negative opinions or experiences to others.";
$ip_recent_comment_list_download_tooltip = "Download the list of recent comments received along with the IP feedback forms during the selected period.";
$ip_all_tickets_list_download_tooltip = "Download the list of tickets received with Inpatient feedbacks, indicating the total number of negative ratings received by inpatients during the selected period.";
$ip_open_tickets_list_download_tooltip = "Download the list of open tickets/ negative experiences from inpatients. This indicates the total number of tickets yet to be addressed or closed.";
$ip_closed_tickets_list_download_tooltip = "Download the list of closed tickets. This indicates the total number of tickets closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$ip_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of negative experiences, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing tickets or addressing negative experiences raised by inpatients.";
$ip_staff_recognition_report_download_tooltip = "Download the staff appreciation list, featuring staff members who have been recognized, recommended, or appreciated by inpatients.";



//pdf download page tooltip message 
$pdf_overall_feedback_report_download_tooltip = "Download the comprehensive report of inpatient discharge feedback.";
$pdf_patient_wise_report_download_tooltip = "Download the comprehensive raw patient feedback report, which comprises individual patient feedback data collected during the selected period.";
$pdf_department_wise_report_download_tooltip = "Download the department-wise report, which provides insights into relative performance, distribution of negative experiences among various departments, and evaluates the efficiency of their responses.";
$pdf_satisfied_patient_list_download_tooltip = "Download the list of satisfied inpatients—those who have rated above average and have not highlighted any negative experiences.";
$pdf_unsatisfied_patient_list_download_tooltip = "Download the list of unsatisfied inpatients— those who have highlighted atleast one negative experience.";
$pdf_promoter_list_download_tooltip = "Download the list of promoters: patients who gave a score of 9 or 10 when asked about recommending the hospital, indicating high satisfaction and loyalty.";
$pdf_passive_list_download_tooltip = "Download the list of passives: patients scoring 7 or 8, indicating general satisfaction but not as high as promoters.";
$pdf_detractor_list_download_tooltip = "Download the list of detractors: patients with scores from 0 to 6, indicating dissatisfaction, who may express negative opinions or experiences to others.";
$pdf_recent_comment_list_download_tooltip = "Download the list of recent comments received along with the IP feedback forms during the selected period.";
$pdf_all_tickets_list_download_tooltip = "Download the list of tickets received with Inpatient feedbacks, indicating the total number of negative ratings received by inpatients during the selected period.";
$pdf_open_tickets_list_download_tooltip = "Download the list of open tickets/ negative experiences from inpatients. This indicates the total number of tickets yet to be addressed or closed.";
$pdf_closed_tickets_list_download_tooltip = "Download the list of closed tickets. This indicates the total number of tickets closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$pdf_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of negative experiences, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing tickets or addressing negative experiences raised by inpatients.";
$pdf_staff_recognition_report_download_tooltip = "Download the staff appreciation list, featuring staff members who have been recognized, recommended, or appreciated by inpatients.";


//adf download page tooltip message
$adf_overall_feedback_report_download_tooltip = "Download the comprehensive report of admission feedback.";
$adf_patient_wise_report_download_tooltip = "Download the comprehensive raw patient feedback report, which comprises individual patient feedback data collected during the selected period.";
$adf_department_wise_report_download_tooltip = "Download the department-wise report, which provides insights into relative performance, distribution of negative experiences among various departments, and evaluates the efficiency of their responses.";
$adf_satisfied_patient_list_download_tooltip = "Download the list of satisfied patients—those who have rated above average and have not highlighted any negative experiences.";
$adf_unsatisfied_patient_list_download_tooltip = "Download the list of unsatisfied patients— those who have highlighted atleast one negative experience.";
$adf_promoter_list_download_tooltip = "Download the list of promoters: patients who gave a score of 9 or 10 when asked about recommending the hospital, indicating high satisfaction and loyalty.";
$adf_passive_list_download_tooltip = "Download the list of passives: patients scoring 7 or 8, indicating general satisfaction but not as high as promoters.";
$adf_detractor_list_download_tooltip = "Download the list of detractors: patients with scores from 0 to 6, indicating dissatisfaction, who may express negative opinions or experiences to others.";
$adf_recent_comment_list_download_tooltip = "Download the list of recent comments received along with the admission feedback forms during the selected period.";
$adf_all_tickets_list_download_tooltip = "Download the list of tickets received with admission feedbacks, indicating the total number of negative ratings received by patients during the selected period.";
$adf_open_tickets_list_download_tooltip = "Download the list of open tickets/ negative experiences from patients. This indicates the total number of tickets yet to be addressed or closed.";
$adf_closed_tickets_list_download_tooltip = "Download the list of closed tickets. This indicates the total number of tickets closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$adf_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of negative experiences, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing tickets or addressing negative experiences raised by patients.";
$adf_staff_recognition_report_download_tooltip = "Download the staff appreciation list, featuring staff members who have been recognized, recommended, or appreciated by patients.";



//op download page tooltip message
$op_overall_feedback_report_download_tooltip = "Download the comprehensive report of outpatient feedback.";
$op_patient_wise_report_download_tooltip = "Download the comprehensive raw patient feedback report, which comprises individual patient feedback data collected during the selected period.";
$op_department_wise_report_download_tooltip = "Download the department-wise report, which provides insights into relative performance, distribution of negative experiences among various departments, and evaluates the efficiency of their responses.";
$op_satisfied_patient_list_download_tooltip = "Download the list of satisfied patients—those who have rated above average and have not highlighted any negative experiences.";
$op_unsatisfied_patient_list_download_tooltip = "Download the list of unsatisfied patients— those who have highlighted atleast one negative experience.";
$op_promoter_list_download_tooltip = "Download the list of promoters: patients who gave a score of 9 or 10 when asked about recommending the hospital, indicating high satisfaction and loyalty.";
$op_passive_list_download_tooltip = "Download the list of passives: patients scoring 7 or 8, indicating general satisfaction but not as high as promoters.";
$op_detractor_list_download_tooltip = "Download the list of detractors: patients with scores from 0 to 6, indicating dissatisfaction, who may express negative opinions or experiences to others.";
$op_recent_comment_list_download_tooltip = "Download the list of recent comments received along with the outpatient feedback forms during the selected period.";
$op_all_tickets_list_download_tooltip = "Download the list of tickets received with outpatient feedbacks, indicating the total number of negative ratings received by patients during the selected period.";
$op_open_tickets_list_download_tooltip = "Download the list of open tickets/ negative experiences from patients. This indicates the total number of tickets yet to be addressed or closed.";
$op_closed_tickets_list_download_tooltip = "Download the list of closed tickets. This indicates the total number of tickets closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$op_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of negative experiences, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing tickets or addressing negative experiences raised by patients.";
$op_staff_recognition_report_download_tooltip = "Download the staff appreciation list, featuring staff members who have been recognized, recommended, or appreciated by patients.";

//pcf download page tooltip message
$pcf_all_tickets_list_download_tooltip = "Download the list of complaints received from patients, indicating the total number of complaints received during the selected period.";
$pcf_open_tickets_list_download_tooltip = "Download the list of open complaints from patients. This indicates the total number of complaints yet to be addressed or closed.";
$pcf_closed_tickets_list_download_tooltip = "Download the list of closed complaints. This indicates the total number of complaints closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$pcf_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of complaints, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing complaints raised by patients.";

//isr download page tooltip message
$esr_all_tickets_list_download_tooltip = "Download the list of service requests received from staffs, indicating the total number of service requests received during the selected period.";
$esr_open_tickets_list_download_tooltip = "Download the list of open service requests from staffs. This indicates the total number of service requests yet to be addressed or closed.";
$esr_closed_tickets_list_download_tooltip = "Download the list of closed service requests. This indicates the total number of service requests closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$esr_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of service requests, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing service requests raised by staffs.";

//incident download page tooltip message
$incident_all_tickets_list_download_tooltip = "Download the list of incidents received from staffs, indicating the total number of healthcare incidents registered during the selected period.";
$incident_open_tickets_list_download_tooltip = "Download the list of open incidents from staffs. This indicates the total number of healthcare incidents yet to be addressed or closed.";
$incident_closed_tickets_list_download_tooltip = "Download the list of closed incidents. This indicates the total number of healthcare incidents closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$incident_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of incidents, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing incidents registered by staffs.";


//grievance download page tooltip message
$grievance_all_tickets_list_download_tooltip = "Download the list of grievances received from staffs, indicating the total number of staff grievances registered during the selected period.";
$grievance_open_tickets_list_download_tooltip = "Download the list of open grievances from staffs. This indicates the total number of staff grievances yet to be addressed or closed.";
$grievance_closed_tickets_list_download_tooltip = "Download the list of closed grievances. This indicates the total number of staff grievances closed by respective departments with Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA).";
$grievance_capa_report_download_tooltip = "Download the CAPA report for periodic reviews and compliance purposes. This report includes a list of staff grievances, along with the Root Cause Analysis (RCA) and Corrective and Preventive Actions (CAPA) provided by each department while closing grievances registered by staffs";


$welcometext = "This page offers a range of downloadable reports for your convenience, allowing you to utilize them during periodic reviews or for fulfilling mandatory reporting requirements in compliance with NABH/JCI standards.";



?>

<h2 class="typing-text" style="margin-left: 40px; font-size: 20px;"></h2>
<button onclick="speakWelcomeText()" style="float: right; margin-right: 30px; margin-bottom: 20px;">🔊 Listen to AI</button>



<div class="content">
    <div style="padding-left: 23px;">
        <div style="margin-bottom: 15px;margin-top: 15px;">

            <h4 style="font-size:18px;font-weight:normal;">
                <span class="typing-text"></span>
            </h4>

        </div>

        <?php if (ismodule_active('IP') === true) { ?>
            <h3><?php echo $ip_feedback_module; ?></h3>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_overall_feedback_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">

                                <div class="small" style="font-size: 16px;"><?php echo $ip_overall_feedback_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_overall_pdf; ?>" target="_blank"> <i class="fa fa-download"></i> Download (pdf) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_patient_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">

                                <div class="small" style="font-size: 16px;"><?php echo $ip_patient_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_overall_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel)</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_department_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_department_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_department_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_satisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_satisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_satisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_unsatisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_unsatisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_unsatisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_promoter_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_promoter_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_promoter_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_passive_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_passive_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_passive_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_detractor_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_detractor_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_detractor_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_recent_comment_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_recent_comment_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_downloadcomments; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $ip_staff_recognition_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $ip_staff_recognition_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $ip_download_staff_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ......................................................................................................................................... -->
            <hr>
        <?php } ?>
        <?php if (ismodule_active('ADF') === true) { ?>
            <h3><?php echo $adf_feedback_module; ?></h3>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_overall_feedback_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">

                                <div class="small" style="font-size: 16px;"><?php echo $adf_overall_feedback_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_overall_pdf; ?>" target="_blank"> <i class="fa fa-download"></i> Download (pdf) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_patient_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">

                                <div class="small" style="font-size: 16px;"><?php echo $adf_patient_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_overall_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel)</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_department_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_department_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_department_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_satisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_satisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_satisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_unsatisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_unsatisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_unsatisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_promoter_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_promoter_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_promoter_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_passive_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_passive_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_passive_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_detractor_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_detractor_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_detractor_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_recent_comment_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_recent_comment_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_downloadcomments; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $adf_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $adf_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $adf_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- ................................................................................................................................................ -->
            <hr>
        <?php } ?>
        <?php if (ismodule_active('OP') === true) { ?>
            <h3><?php echo $op_feedback_module; ?></h3>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_overall_feedback_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_overall_feedback_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_overall_pdf; ?>" target="_blank"> <i class="fa fa-download"></i> Download (pdf) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_patient_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_patient_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_overall_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_department_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_department_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_department_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_satisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_satisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_satisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_unsatisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_unsatisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_unsatisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_promoter_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_promoter_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_promoter_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_passive_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_passive_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_passive_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_detractor_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_detractor_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_detractor_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_recent_comment_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_recent_comment_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_downloadcomments; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $op_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $op_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $op_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ................................................................................................................................................ -->
            <hr>
        <?php } ?>
        <?php if (ismodule_active('PCF') === true) { ?>
            <h3><?php echo $pcf_comaplaint_module; ?></h3>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pcf_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pcf_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pcf_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pcf_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pcf_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pcf_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pcf_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pcf_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pcf_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pcf_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pcf_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pcf_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ................................................................................................................................................ -->
            <hr>
        <?php } ?>
        <?php if (ismodule_active('PDF') === true) { ?>
            <h3><?php echo $pdf_feedback_module; ?></h3>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_overall_feedback_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">

                                <div class="small" style="font-size: 16px;"><?php echo $pdf_overall_feedback_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_overall_pdf; ?>" target="_blank"> <i class="fa fa-download"></i> Download (pdf) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_patient_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">

                                <div class="small" style="font-size: 16px;"><?php echo $pdf_patient_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_overall_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel)</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_department_wise_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_department_wise_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_department_excel; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_satisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_satisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_satisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_unsatisfied_patient_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_unsatisfied_patient_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_unsatisfied_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_promoter_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_promoter_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_promoter_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_passive_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_passive_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_passive_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_detractor_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_detractor_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_detractor_list; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_recent_comment_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_recent_comment_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_downloadcomments; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $pdf_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $pdf_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $pdf_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- ......................................................................................................................................... -->
            <hr>
        <?php } ?>
        <?php if (ismodule_active('ISR') === true) { ?>
            <h3><?php echo $esr_request_module; ?></h3>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $esr_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $isr_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $esr_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $isr_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $esr_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $isr_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $esr_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $esr_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $isr_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ................................................................................................................................................ -->
            <hr>
        <?php } ?>
        <?php if (ismodule_active('INCIDENT') === true) { ?>

            <h3><?php echo $incident_module; ?></h3>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $incident_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $incident_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $incident_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $incident_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $incident_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $incident_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $incident_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $incident_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $incident_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ................................................................................................................................................ -->
            <hr>
        <?php } ?>
        <?php if (ismodule_active('GRIEVANCE') === true) { ?>
            <h3><?php echo $grievance_module; ?></h3>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_all_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $grievance_all_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $grievance_download_alltickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_open_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $grievance_open_tickets_list; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $grievance_download_opentickets; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_closed_tickets_list_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $grievance_closed_tickets; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $grievance_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip" title="<?php echo $grievance_capa_report_download_tooltip; ?>">
                            <div class="statistic-box" style="text-align: center;">
                                <div class="small" style="font-size: 16px;"><?php echo $grievance_capa_report; ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $totaltickect_tooltip; ?>"></i></a></div>
                                <a class="btn btn-dark" href="<?php echo $grievance_download_capa_report; ?>" target="_blank"> <i class="fa fa-download"></i> Download (excel) </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        <?php } ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var typed = new Typed(".typing-text", {
            strings: ["<?php echo $welcometext; ?>"],
            // delay: 10,
            loop: false,
            typeSpeed: 30,
            backSpeed: 5,
            backDelay: 1000,
        });
    });
</script>

<script>
    function speakWelcomeText() {
        const text = `<?php echo $welcometext; ?>`;
        const synth = window.speechSynthesis;

        let selectedVoice = null;

        const setVoiceAndSpeak = () => {
            // Try to find an Indian female voice
            const voices = synth.getVoices();
            selectedVoice = voices.find(voice =>
                (voice.lang === 'hi-IN' || voice.lang === 'kn-IN') && voice.name.toLowerCase().includes('female')
            );

            // Fallback: just get any Hindi/Kannada voice
            if (!selectedVoice) {
                selectedVoice = voices.find(voice => voice.lang === 'hi-IN' || voice.lang === 'kn-IN');
            }

            const msg = new SpeechSynthesisUtterance(text);
            msg.lang = selectedVoice ? selectedVoice.lang : 'en-IN';
            msg.voice = selectedVoice || null;
            msg.rate = 1;
            msg.pitch = 1;

            synth.cancel(); // stop any ongoing speech
            synth.speak(msg);
        };

        // Wait until voices are loaded
        if (synth.getVoices().length === 0) {
            synth.onvoiceschanged = setVoiceAndSpeak;
        } else {
            setVoiceAndSpeak();
        }
    }


</script>