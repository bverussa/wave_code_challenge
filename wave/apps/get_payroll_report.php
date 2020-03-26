<?php
    
    include_once 'payroll.class.php';

    // Response Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
      
    $payroll = new payroll();
    $response = $payroll->get_payroll_report();

    // Body
    http_response_code($response['http_response_code']);
    echo json_encode([
        'message' => $response['message']
    ]);

?>