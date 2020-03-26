<?php

    switch ($_GET['endpoint']) {

        default:
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json; charset=UTF-8');
            http_response_code(404);
            echo json_encode([
                'message' => 'Failed: Endpoint not found'
            ]);
            break;
        case 'upload_payroll_data': include 'apps/upload_payroll_data.php'; break;
        case 'get_payroll_report': include 'apps/get_payroll_report.php'; break;
    }

?>