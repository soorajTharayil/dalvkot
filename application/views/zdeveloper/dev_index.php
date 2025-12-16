<?php // require ' base_url("dashboard/welcome").php'; 
?>
<?php 

$dates = get_from_to_date();
$fdate = $dates['fdate'];
$tdate = $dates['tdate'];
$pagetitle = $dates['pagetitle'];
$fdate = date('Y-m-d', strtotime($fdate));
$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
$days = $dates['days'];

?>

<br>
<div class="content">
    <div class="row">
        <!--  table area -->
        <div class="col-sm-12">
            <div class="panel panel-default " style="height:auto ; overflow:none;">
                <div class="panel-heading">
                    <h3>DEVELOPMENT</h3>
                </div>
                <div class="panel-body">
                    <table class=" table table-striped table-bordered  no-footer dtr-inline ">
             
                            <tr>
                                <td class="title">ADF SETUP</td>
                                <td class="butt"><a href="#<?php //echo base_url("devcheck/ipquestions") ?>" class="btn btn-primary">Questions</a> </td>

                                <td class="butt"><a href="<?php echo base_url("devcheck/setupadf") ?>" class="btn btn-primary">ADD</a> </td>

                            </tr>
                     
                    
                            <tr>
                                <td class="title">IP SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/ipquestions") ?>" class="btn btn-primary">Questions</a> </td>

                                <td class="butt"><a href="<?php echo base_url("devcheck/setupip") ?>" class="btn btn-primary">ADD</a> </td>

                            </tr>
                            <tr>
                                <td class="title">PDF SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/ipquestions") ?>" class="btn btn-primary">Questions</a> </td>

                                <td class="butt"><a href="<?php echo base_url("devcheck/setuppdf") ?>" class="btn btn-primary">ADD</a> </td>

                            </tr>
                    
                            <tr>
                                <td class="title">OP SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/opquestions") ?>" class="btn btn-primary">Questions</a> </td>

                                <td class="butt"><a href="<?php echo base_url("devcheck/setupop") ?>" class="btn btn-primary">ADD</a> </td>
                            </tr>
                     
                            <tr>
                                <td class="title">PC SETUP </td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/pcquestions") ?>" class="btn btn-primary">Questions</a> </td>

                                <td class="butt"><a href="<?php echo base_url("devcheck/setupinterim") ?>" class="btn btn-primary">ADD</a> </td>
                            </tr>
                    
                            <tr>
                                <td class="title">ISR SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupesr") ?>" class="btn btn-primary" target="_blank">Questions</a> </td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupesr") ?>" class="btn btn-primary" target="_blank">ADD</a> </td>
                            </tr>
                      
                            <!-- <tr>
                                <td class="title">PSR SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setuppsr") ?>" class="btn btn-primary" target="_blank">Questions</a></td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setuppsr") ?>" class="btn btn-primary" target="_blank">ADD</a></td>
                            </tr>
                     
                            <tr>
                                <td class="title">EMPEX SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupexp") ?>" class="btn btn-primary" target="_blank">Questions</a></td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupexp") ?>" class="btn btn-primary" target="_blank">ADD</a></td>
                            </tr> -->
                    
                            <tr>
                                <td class="title">INCIDENT SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupincident") ?>" class="btn btn-primary" target="_blank">Questions</a></td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupincident") ?>" class="btn btn-primary" target="_blank">ADD</a></td>
                            </tr>
                  
                            <tr>
                                <td class="title">GRIEVANCE SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupgrievance") ?>" class="btn btn-primary" target="_blank">Questions</a></td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupgrievance") ?>" class="btn btn-primary" target="_blank">ADD</a></td>
                            </tr>
                            <tr>
                                <td class="title">SOCIAL SETUP</td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupgrievance") ?>" class="btn btn-primary" target="_blank">Questions</a></td>
                                <td class="butt"><a href="<?php echo base_url("devcheck/setupsocial") ?>" class="btn btn-primary" target="_blank">ADD</a></td>
                            </tr>
                      
                    </table>

                </div>
            </div>
        </div>
    </div>


</div>
<style>
    .butt.title {
        font-weight: bold;
    }

    .butt {
        text-align: center;
        align-items: center;
    }
</style>