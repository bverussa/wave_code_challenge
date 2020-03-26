<?php

    class database {

        // Database Settings
        private $host = '127.0.0.1';
        private $database = 'wave';
        private $port = '8889';
        private $user = 'root';
        private $passwd = 'root';
        private $dsn;
        private $connection;

        public function __construct () {

            $this->dsn = 'mysql:host='.$this->host.';dbname='.$this->database.';port='.$this->port;
        }

        // Open database cnnection
        public function open_connection() {

            try {
                
                $this->connection = new PDO($this->dsn, $this->user, $this->passwd);
                return $this->connection;
            } catch(PDOException $e) {
                
                error_log($e->getMessage(), 0);
                return false;
            }
        }

        // Close database connection
        public function close_connection() {
            $this->connection = null;
        }
    }

?>