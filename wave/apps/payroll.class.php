<?php

    // include_once _root . 'config/database.class.php';
    include_once '/Applications/MAMP/htdocs/wave/config/database.class.php';

    class payroll {

        // Database Connection
        private $conn;
        
        // Payroll Properties
        public $date;
        public $employee_id;
        public $hours_worked;
        public $job_group;
        
        // Wages by Job Group
        // job group A is paid $20/hr
        // job group B is paid $30/hr
        public $wages = [
            'A' => 20,
            'B' => 30
        ];

        // Currency formatter
        private $formatter;

        public function __construct () {

            $db = new database();
            $this->conn = $db->open_connection();
            $this->formatter = new NumberFormatter('en_CA', NumberFormatter::CURRENCY);
        }

        /**
         * Saves the payroll file to disk and log to the database
         * @param {string} csv data
         * @return {associative array} 
         *      {bool} status
         *      {int} http_response_code
         *      {string} message
         */
        public function upload_file ($file_name, $csv_data) {

            if (!empty($csv_data) AND isset($file_name)) {

                $rows = explode(PHP_EOL, $csv_data);

                if (isset($rows[1])) {

                    $columns = array_shift($rows);
                    $status = $this->upload_payroll_file($file_name, $csv_data);

                    if ($status['status']) {
                        if ($this->insert_payroll_data($rows)) {
                            return [
                                'status' => true,
                                'http_response_code' => 200,
                                'message' => 'Data received and saved to disk and database.'
                            ];
                        } else {
                            return [
                                'status' => false,
                                'http_response_code' => 404,
                                'message' => 'Failed: Error inserting data into the database.'
                            ];
                        }
                    }

                    return $status;
                } else {
                    return [
                        'status' => false,
                        'http_response_code' => 404,
                        'message' => 'Failed: File is empty.'
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'http_response_code' => 404,
                    'message' => 'Failed: Missing file and/or file name.'
                ];
            }
        }

        /**
         * Saves the payroll file to disk and log to the database
         * @param {string} file name
         * @param {string} csv data
         * @return {associative array} 
         *      {bool} status
         *      {int} http_response_code
         *      {string} message
         */
        public function upload_payroll_file ($file_name, $csv_data) {

            if (isset($file_name) AND strlen($csv_data) > 0) {
                
                $report_id = (explode('.', explode('-', $file_name)[2])[0]);

                if (!$this->get_report_status($report_id)) {
                    //TODO
                    $file_handler = fopen ('/Applications/MAMP/htdocs/wave/files/'.$file_name,'w');
                    
                    if ($file_handler) {
                        fwrite ($file_handler,$csv_data);
                        fclose ($file_handler);
                        $this->log_upload($file_name);

                        return [
                            'status' => true,
                            'http_response_code' => 200,
                            'message' => 'Data received and saved.'
                        ];
                    } else {
                        return [
                            'status' => false,
                            'http_response_code' => 404,
                            'message' => 'Failed: Error saving the file to disk.'
                        ];
                    }
                } else {
                    return [
                        'status' => false,
                        'http_response_code' => 404,
                        'message' => 'Duplicate: Report already uploaded.'
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'http_response_code' => 404,
                    'message' => 'Failed: Missing data.'
                ];
            }
        }

        /**
         * Log file uploaded to database
         * @param {string} file name
         * @param {string} csv data
         * @return {bool}
         */
        public function log_upload ($file_name) {

            $report_id = (explode('.', explode('-', $file_name)[2])[0]);

            $query = 'INSERT INTO `reports_uploaded`(`id`, `date`, `report_name`)
                VALUES (?,NOW(),?)';

            $execute = [
                $report_id,
                $file_name
            ];

            if ($stmt = $this->conn->prepare($query)
                AND $stmt->execute($execute)) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Insert payroll data into the database
         * @param {string} payroll data
         * @return {bool}
         */
        public function insert_payroll_data ($data) {

            $query = 'INSERT INTO `timekeeping`(`date`, `employee_id`, `hours_worked`,
                `job_group`) 
                VALUES (?,?,?,?)';

            if ($stmt = $this->conn->prepare($query)) {

                $saved_ids =[];

                foreach ($data as $key => $row) {
                    
                    $value = explode(',', $row);
                    $timestamp = str_replace('/', '-', $value[0]);
                    $date = date('Y-m-d', strtotime($timestamp));
                    
                    $execute = [
                        $date,
                        $value[2],
                        $value[1],
                        $value[3],
                    ];
                    
                    if ($stmt->execute($execute)) {
                        $saved_ids[] = $this->conn->lastInsertId();
                        continue;
                    } else {

                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        }

        /**
         * Returns a pay range for a given date
         * @param {string} date
         * @return {associative array} 
         *      {string} start_date
         *      {string} end_date
         */
        private function get_pay_period ($date) {

            $date_obj = DateTime::createFromFormat("Y-m-d", $date);

            if ($date_obj->format('d') <= 15) {

                $start_date = $date_obj->modify('first day of this month')->format('Y-m-d');
                $end_date = $date_obj->format('Y-m-15');
            } else {
                $start_date = $date_obj->format('Y-m-16');
                $end_date = $date_obj->format('Y-m-t');
            }

            return [
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];

        }

        /**
         * Returns the daily amount for an employee
         * @param {int} hours_worked
         * @param {string} job_group
         * @return {int} daily amount
         */
        private function calculate_daily_amount ($hours_worked, $job_group) {

            return $hours_worked * $this->wages[strtoupper($job_group)];
        }

        /**
         * Returns all of the data across all of the uploaded time reports
         * @param NONE
         * @return {array} raw payroll data
         */
        private function get_payroll_data () {

            $query = 'SELECT *
            FROM `timekeeping`
            ORDER BY employee_id, date';

            if ($stmt = $this->conn->prepare($query)
                AND $stmt->execute([])
                AND $data = $stmt->fetchAll(PDO::FETCH_ASSOC)) {

                return $data;
            } else {
                return false;
            }
        }

        /**
         * Returns all payroll data available
         * @param NONE
         * @return {associative array} 
         *      {bool} status
         *      {int} http_response_code
         *      {string} message
         */
        public function get_payroll_report () {

            $status = false;
            $data = $this->get_payroll_data();

            foreach ($data as $key => $value) {
                
                $pay_period = $this->get_pay_period($value['date']);
                $amount_paid = $this->calculate_daily_amount($value['hours_worked'],
                    $value['job_group']);

                $draft[$value['employee_id']][$pay_period['start_date']]['payPeriod'] =
                    $pay_period;

                if (!isset($draft[$value['employee_id']][$pay_period['start_date']]['amount'])) {
                    $draft[$value['employee_id']][$pay_period['start_date']]['amount'] = 0;
                }

                $draft[$value['employee_id']][$pay_period['start_date']]['amount'] +=
                    $amount_paid;
            }

            foreach ($draft as $employee => $dates) {
                
                foreach ($dates as $date => $value) {
                  
                    $employees_data[] = [
                        'employeeId' => $employee,
                        'payPeriod' => $value['payPeriod'],
                        'amountPaid' => $this->formatter->formatCurrency($value['amount'], 'CAD')
                    ];
                }
            }

            if (isset($employees_data)) {
                $report = [
                    'payrollReport' => [
                        'employeeReports' => $employees_data
                    ]
                ];
                $status = true;
            }

            return [
                'status' => $status,
                'http_response_code' => ($status ? 200 : 404),
                'message' => ($status ? $report : 'Failed: No data available.')
            ];
        }

        /**
         * Returns report status
         * @param {int} report_id
         * @return {array} raw report status data
         */
        private function get_report_status ($report_id) {

            $query = 'SELECT *
            FROM `reports_uploaded`
            WHERE id = ?';

            $execute = [
                $report_id
            ];

            if ($stmt = $this->conn->prepare($query)
                AND $stmt->execute($execute)
                AND $data = $stmt->fetch(PDO::FETCH_ASSOC)) {

                return $data;
            } else {
                
                return false;
            }
        }
    }

?>