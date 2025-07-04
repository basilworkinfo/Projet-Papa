<?php
    
    include_once("../modele/Utilisateur.class.php");
    include_once("../modele/Produit.class.php");
    include_once("../modele/Exceptions/UtilisateurInexistantException.class.php");
    include_once("../accessDonnees/AccessBD.php");
    include_once("../modele/Exceptions/UtilisateurDejaExistantException.class.php");
    include_once("../modele/Exceptions/CompetitionInexistanteException.class.php");
    include_once("../modele/UtilisateurCompetition.class.php");
    include_once("../modele/Exceptions/EvenementExistanteException.class.php");
    include_once("../modele/Exceptions/PasDeCommandesException.class.php");
    include_once("../modele/TrancheHoraire.class.php");
    include_once("../modele/Exceptions/TrancheHoraireInexistanteEception.class.php");
    include_once("../modele/Exceptions/MotDePasseIncorrectException.class.php");
    include_once("../modele/Commande.class.php");
    include_once("../modele/ProduitCommande.class.php");
    include_once("../modele/Exceptions/TrancheHoraireInexistanteEception.class.php");
    include_once("../modele/UtilisateurTrancheHoraire.class.php");
    include_once("../modele/Benevole.class.php");
    include_once("../modele/Exceptions/BenevoleException.class.php");
    include_once("../modele/Exceptions/BenevoleInexistantException.class.php");
    include_once("../modele/Exceptions/pasDarticlesDansBDExeption.class.php");
    include_once("../modele/Exceptions/ProduitInexistanteException.class.php");
    include_once("../modele/Exceptions/pasAssezDePointsExeption.class.php");
    
   
    

    class Logic{
        private $accessBD;

        function __construct(){
            $this->accessBD = new AccessBD();
        }
        //Début code lénaic
        function obtenirUtilisateur($email){
            if($email != 0){
                try{
                    $user = $this->accessBD->obtenirUtilisateur($email);
                }
                catch(UtilisateurInexistantException $e){
                    throw new UtilisateurInexistantException();
                }
                return $user;
            }
            else{
                throw new UtilisateurInexistantException();
            }
        }
        
        function obtenirUtilisateurs(){
            try{
                $utilisateurs = $this->accessBD->obtenirUtilisateurs();
            }
            catch(UtilisateurInexistantException $e){
                throw new UtilisateurInexistantException();
            }
            return $utilisateurs;
        }

        function obtenirUtilisateurParRecherche($recherche){
            if($recherche != 0){
                try{
                    $utilisateurs = $this->accessBD->obtenirUtilisateurParRecherche($recherche);
                }
                catch(UtilisateurInexistantException $e){
                    throw new UtilisateurInexistantException();
                }
            }
            else{
                $utilisateurs = $this->obtenirUtilisateurs();
            }
            return $utilisateurs;
        }

        function obtenirUtilisateurEnAttente(){
            try{
                $utilisateurs = $this->accessBD->obtenirUtilisateurEnAttente();
            }
            catch(UtilisateurInexistantException $e){
                throw new UtilisateurInexistantException();
            }
            return $utilisateurs;
        }

        function obtenirBenevoleParID($id){
            try{
                $benevole = $this->accessBD->obtenirBenevoleParID($id);
            }
            catch(BenevoleInexistantException $e){
                throw new BenevoleInexistantException();
            }
            return $benevole;
        }

        function validerBenevole($ID_Ben, $ID_Tra){
            try{
                $this->accessBD->validerBenevole($ID_Ben, $ID_Tra);
            }
            catch(BenevoleInexistantException $e){
                throw new BenevoleInexistantException();
            }
        }

        function obtenirTrancheHoraireParID($id){
            try{
                $trancheHoraire = $this->accessBD->obtenirTrancheHoraireParID($id);
            }
            catch(TrancheHoraireInexistanteEception $e){
                throw new TrancheHoraireInexistanteEception();
            }
            return $trancheHoraire;
        }

        function obtenirEvenementParId($id){
            try{
                $evenement = $this->accessBD->obtenirEvenementParId($id);
            }
            catch(EvenementInexistanteException $e){
                throw new EvenementInexistanteException();
            }
            return $evenement;
        } 

        function obtenirBenevoleValide(){
            try{
                $benevoles = $this->accessBD->obtenirBenevoleValide();
            }
            catch(BenevoleInexistantException $e){
                throw new BenevoleInexistantException();
            }
            return $benevoles;
        }

        function changerAdmin($email){
            try{
                $this->accessBD->changerAdmin($email);
            }
            catch(UtilisateurInexistantException $e){
                throw new UtilisateurInexistantException();
            }
        }
        //fin code lénaic
        //Début code Ferre 
        function creerCompte($email, $code, $nom, $prenom, $numTelephone, $dateNaissance){
            try{
                $user = $this->accessBD->obtenirUtilisateur($email);
                throw new UtilisateurDejaExistantException();
            }
            catch(UtilisateurInexistantException $e){
                $nouvelUtilisateur =  new Utilisateur($code, $nom, $prenom, $email, $numTelephone, $dateNaissance);
                $this->accessBD->creerUtilisateur($nouvelUtilisateur);
            }
        }
        function recevoirCommande(){           
            $commande = $this->accessBD->recevoirCommandeComplete();
            if($commande = PasDeCommandesException()){
                throw new PasDeCommandesException();
            }else {
                return $commande;  
            }
        }
        function testCompte($email, $code){
            try {
                $mdpCompte = $this->obtenirUtilisateur($email)->code;
                var_dump($mdpCompte);
                if ($mdpCompte == $code) {
                    return true;
                }else{
                    throw new MotDePasseIncorrectException();
                }
            } catch(UtilisateurInexistantException $e) {
                throw new UtilisateurInexistantException();
            }
            
        }/*
        function commande(){
            //fonction pour ajouter des commandes
        }*/
        function obtenirArticles(){
            try{
                $infos = $this->accessBD->obtenirArticles();
                return $infos;
            }catch(pasDarticlesDansBDExeption $e){
                throw new pasDarticlesDansBDExeption();
            }
        }
        function achat($pointsAchat, $email){
            $utilisateur = obtenirUtilisateur($email);
            if($utilisateur->points > $pointsAchat){
                $pointsActuels = $utilisateur->points;
                $pointsActuels = $pointsActuels - $pointsAchat;
        
                $utilisateur->points = $pointsActuels; 
              }else {
                throw new pasAssezDePointsExeption();
              }
        }
        //Fin code Ferre
        

        //Début code Lenaic
        function obtenirCompetitions(){
            try{
                $competitions = $this->accessBD->obtenirCompetitions();
                return $competitions;
            }
            catch (CompetitionInexistanteException $e){
                throw new CompetitionInexistanteException();
            }
        }

        function ajouterPoints($points, $email, $id){
            $utilisateur = $this->obtenirUtilisateur($email);
            $this->accessBD->ajouterPoints($email, $points);
            $this->ajouterCompetitionParticipé($id, $email);
            $utilisateur->ajouterPoints($points);
        }

        function ajouterCompetitionParticipé($id, $email){
            $this->accessBD->ajouterCompetitionParticipé($id, $email);
            new UtilisateurCompetition($id, $email);
        }

        function obtenirCompetition($nom){
            $competition = $this->accessBD->obtenirCompetition($nom);
            return $competition;
        }

        function obtenirCompetitionsParticipées($email){
            $competitions = $this->accessBD->obtenirCompetitionsParticipées($email);
            return $competitions;
        }
        //fin code Lenaic
        //Début code Basil
        function creerCompetition($nouvelCompetition){
           
            try{
                 $creer = $this->accessBD->obtenirCompetition($nouvelCompetition->nom);
                 
            }
            catch(CompetitionInexistanteException $e){
                $creer = $this->accessBD->creerCompetition($nouvelCompetition); 
            }
        }
        function creerEvenement($nouvelBenevole){
           
            try{
                $creer = $this->accessBD->obtenirEvenement($nouvelBenevole->nom);
                throw new EvenementExistanteException();
                
            }
            catch(EvenementInexistanteException){
                $creer = $this->accessBD->creerEvenement($nouvelBenevole);
                return $creer;
            }
            
        }
        function creerTrancheHoraire($TH){
            try{
                $creer = $this->accessBD->obtenirTrancheHoraire($TH);
                throw new EvenementExistanteException();
                
            }
            catch(TrancheHoraireInexistanteException){
                 $this->accessBD->creerTrancheHoraire($TH);
            }
            
        }
        function obtenirTHS($ID_Eve){
            try{
                $THS = $this->accessBD->obtenirTrancheHoraires($ID_Eve);
                return $THS;
            }
            catch(TrancheHoraireInexistanteException $e){
                throw new TrancheHoraireInexistanteException();
            }
        }
        function obtenirTHSNonParticiper($ID_Eve,$eMail){
            try{
                $THS = $this->accessBD->obtenirTrancheHorairesNonParticiper($ID_Eve,$eMail);
                return $THS;
            }
            catch(TrancheHoraireInexistanteException $e){
                throw new TrancheHoraireInexistanteException();
            }
        }
        function obtenirEvenements(){
            try{
                $Benevoles = $this->accessBD->obtenirEvenements();
                return $Benevoles;
            }
            catch(EvenementInexistanteException $e){
                throw new EvenementInexistanteException();
            }
        }

       
        function genererChaineAleatoire($longueur = 6){
           $caracteres = '0123456789';
          $longueurMax = strlen($caracteres);
            $chaineAleatoire = '';
        for ($i = 0; $i < $longueur; $i++)
          {
          $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
          }
          
          return $chaineAleatoire;
        }
        function creerUtilisateurTrancheHoraire($ID_TH){
            try{
                $TH=$this->accessBD->creerUtilisateurTrancheHoraire($ID_TH);
            }
            catch(UtilisateurTrancheHoraire $e){
                
            }
        }
        function creerBenevole($benevole){
            try{
                $creer = $this->accessBD->obtenirBenevole($benevole);
                throw new BenevoleException();
            }
            catch(BenevoleInexistantException $e){
                $this->accessBD->creerBene($benevole);
            } 
        }
        function obtenirBenevole($bene){
            try{
                $bene = $this->accessBD->obtenirBenevole($bene);
                return $bene;
            }
            catch(BenevoleInexistantException $e){
                throw new BenevoleInexistantException();
            } 
        }
        function obtenirBenevoles($eMail){
            try{
                $benes = $this->accessBD->obtenirBenevoles($eMail);
                return $benes;
            }
            catch(BenevoleInexistantException $e){
                throw new BenevoleInexistantException();
            } 
        }
        function obtenirTHSNonParticiperBenevole($ID_Eve,$ID_Ben){
            try{
                $THS = $this->accessBD->obtenirTrancheHorairesNonParticiperBenevole($ID_Eve,$ID_Ben);
                return $THS;
            }
            catch(TrancheHoraireInexistanteException $e){
                throw new TrancheHoraireInexistanteException();
            }
        }
        function creerBenevoleTrancheHoraire($THB,$ID_Ben){
            try{
                $THB=$this->accessBD->creerBenevoleTrancheHoraire($THB,$ID_Ben);
            }
            catch(UtilisateurTrancheHoraire $e){
                
            }
        }
        function CreerProduit($produit){
             try{
                 $creer = $this->accessBD->obtenirProduit($produit);
                 
            }
            catch(ProduitInexistanteException $e){
                $creer = $this->accessBD->creerProduit($produit); 
            }
        }
        //Fin code Basil
    }
?>