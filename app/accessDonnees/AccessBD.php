<?php
    class AccessBD{
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $db = "db-ludo";
        private $connexion;

        function __construct(){
            $this->connexion = new mysqli($this->host, $this->user, $this->pass, $this->db);
        }
    }
    
?>