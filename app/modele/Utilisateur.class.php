<?php
    class Utilisateur{
        private $eMail;
        private $MDP;
        private $pseudo;
        private $nom;
        private $prenom;
        private $Tel;
        private $addresse;


        function __construct($eMail, $MDP, $pseudo, $nom, $prenom, $Tel, $addresse){
            $this->eMail = $eMail;
            $this->MDP = $MDP;
            $this->pseudo = $pseudo;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->Tel = $Tel;
            $this->addresse = $addresse;
        }

        function __get($name){
            switch($name){
                case "eMail":
                    return $this->eMail;
                    break;
                case "pseudo":
                    return $this->pseudo;
                    break;
                case "nom":
                    return $this->nom;
                    break;
                case "prenom":
                    return $this->prenom;
                    break;
                case "Tel":
                    return $this->Tel;
                    break;
                case "addresse":
                    return $this->addresse;
                    break;
            }
        }

        function __set($name, $value){
            switch($name){
                case "eMail":
                    $this->eMail = $value;
                    break;
                case "pseudo":
                    $this->pseudo = $value;
                    break;
                case "nom":
                    $this->nom = $value;
                    break;
                case "prenom":
                    $this->prenom = $value;
                    break;
                case "Tel":
                    $this->Tel = $value;
                    break;
                case "addresse":
                    $this->addresse = $value;
                    break;
            }
        }
    }
?>