<?php   
    include_once("../accessDonnees/AccessBD.php");
    class Logic{
        private $accessBD;

        function __construct(){
            $this->accessBD = new AccessBD();
        }
    }
?>