<?php

    include_once 'payroll.class.php';

    // Response Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');

    $file_name = $_GET['var'].'.csv';
    $csv_data = file_get_contents('php://input');
    $payroll = new payroll();    
    $response = $payroll->upload_file($file_name, $csv_data);
    
    // Body
    http_response_code($response['http_response_code']);
    echo json_encode([
        'message' => $response['message']
    ]);

?>