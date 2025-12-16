<?php
class Trend_analytic_model extends CI_Model {

    
    public function get_chart_data($param, $feedBackList, $setupList) {
        $questionPara = [];
    
        // Collect relevant shortkeys based on the provided parameter
        foreach ($setupList as $row) {
            if ($row->type === $param) {
                $questionPara[] = $row->shortkey;
            }
        }
    
        // Initialize feedback rating array with default values
        $feedbackRating = array_fill(1, 5, 0);
    
        // Process feedback list and update feedback rating counts
        foreach ($feedBackList as $row) {
            $dataSet = json_decode($row->dataset, true); // Decode to associative array
            foreach ($questionPara as $para) {
                if (isset($dataSet[$para])) {
                    $rating = $dataSet[$para];
                    if (isset($feedbackRating[$rating])) {
                        $feedbackRating[$rating]++;
                    }
                }
            }
        }
    
        // Return feedback ratings in the required format
        return array_values($feedbackRating);
    }
    
    public function get_relative_performance($param, $feedBackList, $setupList) {
        $questionPara = [];
        $y = date('Y');
        $days = $_SESSION['days'];
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
    
        // Collect relevant shortkeys based on the provided parameter
        foreach ($setupList as $row) {
            if ($row->type === $param) {
                $questionPara[] = $row->shortkey;
            }
        }
    
        $feedbackRating = [];
    
        // Process feedback list and update feedback rating counts
        foreach ($feedBackList as $row) {
            $dataSet = json_decode($row->dataset, true); // Decode to associative array
    
            // Define the time period formatting (weekly, daily, or monthly) based on days
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {
                $mon = date("d", strtotime($row->datetime)) . '-' . date("F", strtotime($row->datetime));
            } else {
                $mon = date("F", strtotime($row->datetime));
            }
    
            foreach ($questionPara as $para) {
                if (isset($dataSet[$para]) && $dataSet[$para] * 1 > 0) {
                    $rating = $dataSet[$para];
                    if (isset($feedbackRating[$mon]['count'])) {
                        $feedbackRating[$mon]['count']++;
                        $feedbackRating[$mon]['total'] += $rating;
                    } else {
                        $feedbackRating[$mon]['count'] = 1;
                        $feedbackRating[$mon]['total'] = $rating;
                    }
                } else {
                    if (!isset($feedbackRating[$mon]['count'])) {
                        $feedbackRating[$mon]['count'] = 0;
                        $feedbackRating[$mon]['total'] = 0;
                    }
                }
            }
        }
    
        $i = 0;
        $result = [];
    
        foreach ($feedbackRating as $key => $row) {
            // Calculate the percentage and handle NaN, converting it to 0
            if ($row['count'] > 0) {
                $value = round(($row['total'] / ($row['count'] * 5)) * 100);
            } else {
                $value = 0;
            }
    
            // If the result is NaN or invalid, force it to 0
            $result['value'][$i] = is_nan($value) ? 0 : $value;
            $result['label'][$i] = $key;
            $i++;
        }
    
        // Uncomment for debugging purposes
        // print_r($result); exit;
    
        return $result;
    }

    
    public function get_response_count($param, $feedBackList, $setupList){
         $questionPara = [];
        $y = date('Y');
        $days = $_SESSION['days'];
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
    
        // Collect relevant shortkeys based on the provided parameter
        foreach ($setupList as $row) {
            if ($row->type === $param) {
                $questionPara[] = $row->shortkey;
            }
        }
    
        $feedbackRating = [];
    
        // Process feedback list and update feedback rating counts
        foreach ($feedBackList as $row) {
            $dataSet = json_decode($row->dataset, true); // Decode to associative array
    
            // Define the time period formatting (weekly, daily, or monthly) based on days
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {
                $mon = date("d", strtotime($row->datetime)) . '-' . date("F", strtotime($row->datetime));
            } else {
                $mon = date("F", strtotime($row->datetime));
            }
    
            foreach ($questionPara as $para) {
                if (isset($dataSet[$para]) && $dataSet[$para] * 1 > 0) {
                    $rating = $dataSet[$para];
                    if (isset($feedbackRating[$mon]['count'])) {
                        $feedbackRating[$mon]['count']++;
                        $feedbackRating[$mon]['total'] += $rating;
                    } else {
                        $feedbackRating[$mon]['count'] = 1;
                        $feedbackRating[$mon]['total'] = $rating;
                    }
                } else {
                    if (!isset($feedbackRating[$mon]['count'])) {
                        $feedbackRating[$mon]['count'] = 0;
                        $feedbackRating[$mon]['total'] = 0;
                    }
                }
            }
        }
    
        $i = 0;
        $result = [];
    
        foreach ($feedbackRating as $key => $row) {
            // Calculate the percentage and handle NaN, converting it to 0
            if ($row['count'] > 0) {
                $value = $row['count'];
            } else {
                $value = 0;
            }
    
            // If the result is NaN or invalid, force it to 0
            $result['value'][$i] = is_nan($value) ? 0 : $value;
            $result['label'][$i] = $key;
            $i++;
        }
    
        // Uncomment for debugging purposes
        // print_r($result); exit;
    
        return $result;
                    
    }
    
    public function ticket_percentage($param, $ticketList, $setupList,$department){
        $activeDepartment = array();
        $y = date('Y');
        $days = $_SESSION['days'];
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        
        foreach($department as $row){
            if($row->setkey == $param){
                $activeDepartment[] = $row->dprt_id;
            }
        }
        
        $ticketPercentage = [];
        
        // Process feedback list and update feedback rating counts
        foreach ($ticketList as $row) {
            
    
            // Define the time period formatting (weekly, daily, or monthly) based on days
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->datetime, $fdate, $tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {
                $mon = date("d", strtotime($row->created_on)) . '-' . date("F", strtotime($row->created_on));
            } else {
                $mon = date("F", strtotime($row->created_on));
            }
    
            foreach ($activeDepartment as $para) {
                if ($row->departmentid == $para) {
                    if (isset($ticketPercentage[$mon]['count'])) {
                        $ticketPercentage[$mon]['count']++;
                        $ticketPercentage[$mon]['total']++;
                    } else {
                        $ticketPercentage[$mon]['count'] = 1;
                        $ticketPercentage[$mon]['total'] = 1;
                    }
                } else {
                    if (!isset($ticketPercentage[$mon]['count'])) {
                        $ticketPercentage[$mon]['count'] = 0;
                        $ticketPercentage[$mon]['total'] = 1;
                    }
                }
            }
        }
        //print_r($ticketPercentage); exit;
        $i = 0;
        $result = [];
    
        foreach ($ticketPercentage as $key => $row) {
            // Calculate the percentage and handle NaN, converting it to 0
            if ($row['count'] > 0) {
                $value = round(($row['count']/$row['total'])*100);
            } else {
                $value = 0;
            }
    
            // If the result is NaN or invalid, force it to 0
            $result['value'][$i] = is_nan($value) ? 0 : $value;
            $result['label'][$i] = $key;
            $i++;
        }
    
     
        return $result;
        
                    
    }
    
    public function ticket_count($param, $ticketList, $setupList,$department){
        $activeDepartment = array();
        $y = date('Y');
        $days = $_SESSION['days'];
        $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
        $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
        //   print_r($ticketList); exit;
        foreach($department as $row){
            if($row->setkey == $param){
                $activeDepartment[] = $row->dprt_id;
            }
        }
        //..print_r($activeDepartment); exit;
        
        $ticketPercentage = [];
    
        // Process feedback list and update feedback rating counts
        foreach ($ticketList as $row) {
            
    
            // Define the time period formatting (weekly, daily, or monthly) based on days
            if ($days > 10 && $days < 93) {
                $desdate = getStartAndEndDate($row->created_on, $fdate, $tdate);
                $mon = $desdate['week_start'] . '-' . $desdate['week_end'] . ' ' . $desdate['mon'];
            } elseif ($days <= 10) {
                $mon = date("d", strtotime($row->created_on)) . '-' . date("F", strtotime($row->created_on));
            } else {
                $mon = date("F", strtotime($row->created_on));
            }
            
            foreach ($activeDepartment as $para) {
                if ($row->departmentid == $para) {
                    if (isset($ticketPercentage[$mon]['count'])) {
                        $ticketPercentage[$mon]['count']++;
                        $ticketPercentage[$mon]['total']++;
                    } else {
                        $ticketPercentage[$mon]['count'] = 1;
                        $ticketPercentage[$mon]['total'] = 1;
                    }
                } else {
                    if (!isset($ticketPercentage[$mon]['count'])) {
                        $ticketPercentage[$mon]['count'] = 0;
                        $ticketPercentage[$mon]['total'] = 1;
                    }
                }
            }
        }
        //print_r($ticketPercentage); exit;
        $i = 0;
        $result = [];
    
        foreach ($ticketPercentage as $key => $row) {
            // Calculate the percentage and handle NaN, converting it to 0
            if ($row['count'] > 0) {
                $value =$row['count'];
            } else {
                $value = 0;
            }
    
            // If the result is NaN or invalid, force it to 0
            $result['value'][$i] = is_nan($value) ? 0 : $value;
            $result['label'][$i] = $key;
            $i++;
        }
    
     
        return $result;
                    
    }
    
    
}
