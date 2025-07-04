<?php
    include_once("../modele/Utilisateur.class.php");
    include_once("../modele/Exceptions/UtilisateurInexistantException.class.php");
    include_once("../modele/Exceptions/UtilisateurDejaExistantException.class.php");
    include_once("../modele/Competition.class.php");
    include_once("../modele/Exceptions/CompetitionInexistanteException.class.php");
    include_once("../modele/Exceptions/EvenementInexistanteException.class.php");
    include_once("../modele/Exceptions/EvenementExistanteException.class.php");
    include_once("../modele/Exceptions/TrancheHoraireInexistanteEception.class.php");
    include_once("../modele/TrancheHoraire.class.php");
    include_once("../modele/Exceptions/MotDePasseIncorrectException.class.php");
    include_once("../modele/Commande.class.php");
    include_once("../modele/ProduitCommande.class.php");
    include_once("../modele/Evenement.class.php");
    include_once("../modele/UtilisateurTrancheHoraire.class.php");
    include_once("../modele/Benevole.class.php");
    include_once("../modele/Exceptions/BenevoleException.class.php");
    include_once("../modele/Exceptions/BenevoleInexistantException.class.php");
    include_once("../modele/Exceptions/pasDarticlesDansBDExeption.class.php");
    include_once("../modele/Exceptions/ProduitInexistanteException.class.php");
    include_once("../modele/Benevoletranchehoraire.class.php");
    
    

    class AccessBD{
        //Début code lénaic
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $db = "scoor";
        private $connexion;

        function __construct(){
            $this->connexion = new mysqli($this->host, $this->user, $this->pass, $this->db);
        }

        function obtenirUtilisateur($email){
            $sql = "SELECT * FROM Utilisateur WHERE eMail = '$email'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }

            if($rowcount > 0){
                $result = mysqli_fetch_assoc($result);
                $utilisateur = new Utilisateur($result['motDePasse'], $result['nom'], $result['prenom'], $result['eMail'], $result['NumeroTelephone'], $result['DateNaissance'], $result['type'], (int)$result['points']);
                return $utilisateur;
            }
            else{
                throw new UtilisateurInexistantException();
            }
        }

        function obtenirUtilisateurs(){
            $sql = "SELECT * FROM Utilisateur";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $utilisateurs = array();
                while($row = mysqli_fetch_assoc($result)){
                    $utilisateur = new Utilisateur($row['motDePasse'], $row['nom'], $row['prenom'], $row['eMail'], $row['NumeroTelephone'], $row['DateNaissance'], $row['type'], (int)$row['points']);
                    array_push($utilisateurs, $utilisateur);
                }
                return $utilisateurs;
            }
            else{
                throw new UtilisateurInexistantException();
            }
        }

        function obtenirUtilisateurParRecherche($recherche){
            $sql = "SELECT * FROM Utilisateur WHERE nom LIKE '%$recherche%' OR prenom LIKE '%$recherche%' OR eMail LIKE '%$recherche%'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $utilisateurs = array();
                while($row = mysqli_fetch_assoc($result)){
                    $utilisateur = new Utilisateur($row['motDePasse'], $row['nom'], $row['prenom'], $row['eMail'], $row['NumeroTelephone'], $row['DateNaissance'], $row['type'], (int)$row['points']);
                    array_push($utilisateurs, $utilisateur);
                }
                return $utilisateurs;
            }
            else{
                throw new UtilisateurInexistantException();
            }
        }

        function obtenirUtilisateurEnAttente(){
            $sql = "SELECT * FROM benevoletranchehoraire WHERE Estvalide = 0";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $benevolesTrancheHoraire = array();
                while($row = mysqli_fetch_assoc($result)){
                    $benevoleTrancheHoraire = new Benevoletranchehoraire($row['ID_Ben'], $row['ID_Tra'], 0, $row['Commentaire']);
                    array_push($benevolesTrancheHoraire, $benevoleTrancheHoraire);
                }
                return $benevolesTrancheHoraire;
            }
            else{
                throw new UtilisateurInexistantException();
            }
        }

        function obtenirBenevoleParID($id){
            $sql = "SELECT * FROM Benevole WHERE ID_Ben = '$id'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $result = mysqli_fetch_assoc($result);
                $benevole = new Benevole($result['nom'], $result['prenom'], $result['eMail'], $result['ID_Ben']);
                return $benevole;
            }
            else{
                throw new BenevoleInexistantException();
            }
        }

        function validerBenevole($ID_Ben, $ID_Tra){
            try{
                $verif = $this->obtenirBenevoleTrancheHoraire($ID_Ben, $ID_Tra);
                $sql = "UPDATE benevoletranchehoraire SET Estvalide = 1 WHERE ID_Ben = '$ID_Ben' AND ID_Tra = '$ID_Tra'";
                $this->connexion->query($sql);
                return true;
            }
            catch(BenevoleInexistantException $e){
                throw new BenevoleInexistantException();
            }
        }

        function obtenirBenevoleTrancheHoraire($ID_Ben, $ID_Tra){
            $sql = "SELECT * FROM benevoletranchehoraire WHERE ID_Ben = '$ID_Ben' AND ID_Tra = '$ID_Tra'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                return true;
            }
            else{
                throw new BenevoleInexistantException();
            }
        }

        function obtenirTrancheHoraireParID($id){
            $sql = "SELECT * FROM tranchehoraire WHERE ID_Tra = '$id'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $result = mysqli_fetch_assoc($result);
                $trancheHoraire = new TrancheHoraire($result['description'], $result['points'], $result['date'], $result['ID_Eve'], $result['ID_Tra']);
                return $trancheHoraire;
            }
            else{
                throw new TrancheHoraireInexistanteEception();
            }
        }

        function obtenirEvenementParId($id){
            $sql = "SELECT * FROM evenement WHERE ID_Eve = '$id'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $result = mysqli_fetch_assoc($result);
                $evenement = new Evenement($result['nom'], $result['Date'], $result['lieu'], $result['images'], $result['ID_Eve']);
                return $evenement;
            }
            else{
                throw new EvenementInexistanteException();
            }
        }

        function obtenirBenevoleValide(){
            $sql = "SELECT * FROM benevoletranchehoraire WHERE Estvalide = 1";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $benevolesTrancheHoraire = array();
                while($row = mysqli_fetch_assoc($result)){
                    $benevoleTrancheHoraire = new Benevoletranchehoraire($row['ID_Ben'], $row['ID_Tra'], 1, $row['Commentaire']);
                    array_push($benevolesTrancheHoraire, $benevoleTrancheHoraire);
                }
                return $benevolesTrancheHoraire;
            }
            else{
                throw new UtilisateurInexistantException();
            }
        }

        function changerAdmin($email){
            try{
                $utilisateur = $this->obtenirUtilisateur($email);
                if($utilisateur->type == 0){
                    $sql = "UPDATE utilisateur SET type = 1 WHERE eMail = '$email'";
                }
                else{
                    $sql = "UPDATE utilisateur SET type = 0 WHERE eMail = '$email'";
                }
                $this->connexion->query($sql);
            }
            catch(UtilisateurInexistantException $e){
                throw new UtilisateurInexistantException();
            }
        }
        //Fin code Lénaïc
        //Début code Ferre 
        function creerUtilisateur($Utilisateur){
            $eMail = $Utilisateur->email;
            $motDePasse = $Utilisateur->code;
            $nom = $Utilisateur->nom;
            $prenom = $Utilisateur->prenom;
            $points = 0;
            $type = $Utilisateur->type;
            $numTel = $Utilisateur->numTel;
            $dateNaissance = $Utilisateur->dateNaissance;
            $sql = "INSERT INTO utilisateur(eMail, motDePasse, nom, prenom, points, `type`, NumeroTelephone, DateNaissance) VALUES('$eMail', '$motDePasse', '$nom', '$prenom', '$points', '$type', '$numTel', '$dateNaissance')";
            $this->connexion->query($sql);
        }
        function recevoirCommandeComplete(){
            try {
                $sql = "SELECT * FROM commande";
                $result = $this->connexion->query($sql);

                $commande = array();
                if ($result = mysqli_query($this->connexion,$sql)){
                    $rowcount = mysqli_num_rows($result);
                }
                if($rowcount > 0){
                    while($row = mysqli_fetch_assoc($result)){
                         $commande = new Commande($row['dateAchat'], $row['eMail'],$row['id_com']);
                    }
                    $date = $commande->dateAchat;
                    $leResteDesInfosCommande = obtenirProduitCommande();
                    $nomProduit = $leResteDesInfosCommande->Produit;
                    $prix = $leResteDesInfosCommande->prix;
                    $quantite = $leResteDesInfosCommande->quantite;

                    array_push($commande, $date , $nomProduit, $prix, $quantite);

                    return $commande;
                }
                else{
                    throw new PasDeCommandesException();
                }
            } catch (PasDeCommandeException $e) {
                throw new PasDeCommandesException();
            }
            
        }
        function obtenirProduitCommande(){
            $sql = "SELECT * FROM produitcommande";
            $result = $this->connexion->query($sql);
            if ($result = mysqli_query($this->connexion,$sql)){
                $rowcount = mysqli_num_rows($result);
            }
            $commande = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $produitCommande = new produitCommande($row['Produit'], $row['prix'],$row['quantite']);
                    array_push($commande, $produitCommande);
                }
            return $commande;  
            }else{
                throw new PasDeCommandeException();
            }
        }
        function obtenirArticles(){
            $sql = "SELECT * FROM produit";
            $result = $this->connexion->query($sql);
            if ($result = mysqli_query($this->connexion,$sql)){
                $rowcount = mysqli_num_rows($result);
            }
            $produits = array();
            $nbProduitsDifferents = 0;
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $produit = new produit($row['nom'], $row['prix']);//si besoin de plus d'infos (description, image, ...) rajouter en "$row¨['nomvariable']" et les rajouter à la classe produit
                    array_push($produits, $produit);
                    $nbProduitsDifferents++;
                }
                return [$produits, $nbProduitsDifferents];
            }else {
                throw new pasDarticlesDansBDExeption();
            }

        }
        //Fin code Ferre

        //Début code Lenaic
        function obtenirCompetitions(){
            $sql = "SELECT * FROM competition";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            $competitions = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $competition = new Competition($row['nom'], $row['date'],$row['lieu'], /*$row['description'],*/ $row['points'], $row['images'], $row['code'],  $row['ID_Com']);
                    array_push($competitions, $competition);
                }
                return $competitions;
            }
            else{
                throw new CompetitionInexistanteException();
            }
        }

        function obtenirCompetitionsParticipées($email){
            $sql = "SELECT * FROM competition C WHERE C.ID_Com NOT IN(SELECT c.ID_Com FROM utilisateurcompetition UC, competition C WHERE UC.ID_Com = C.ID_Com AND UC.eMail = '".$email."')";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            $competitions = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $competition = new Competition($row['nom'], $row['date'],$row['lieu'], /*$row['description'],*/ $row['points'], $row['images'], $row['code'],  $row['ID_Com']);
                    array_push($competitions, $competition);
                }
                return $competitions;
            }
            else{
                throw new CompetitionInexistanteException();
            }
        }

        function ajouterPoints($email, $points){
            $sql = "UPDATE utilisateur SET points = points + $points WHERE eMail = '$email'";
            $this->connexion->query($sql);
        }

        function ajouterCompetitionParticipé($id, $email){
            $sql = "INSERT INTO utilisateurcompetition(ID_Com, eMail) VALUES('$id', '$email')";
            $this->connexion->query($sql);
        }

        //Fin code Lenaic
        //Début code Basil 
        function obtenirCompetition($nomCompetition){
            $sql = "SELECT * FROM competition WHERE nom = '$nomCompetition'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $row = mysqli_fetch_assoc($result);
                $competition = new Competition($row['nom'], $row['date'],$row['lieu'], /*$row['description'],*/ $row['points'],  $row['images'], $row['code'], $row['ID_Com']);
               
                return $competition;
            }
            else{
                throw new CompetitionInexistanteException();
            }
        }
        function obtenirEvenement($nomEvenement){
            $sql = "SELECT * FROM evenement WHERE nom = '$nomEvenement'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $row = mysqli_fetch_assoc($result);
                $evenement = new Evenement($row['nom'], $row['Date'],$row['lieu'], $row['images'], $row['ID_Eve']);
                return $evenement;
            }
            else{
                throw new EvenementInexistanteException();
            }
        }
        function obtenirEvenements(){
            $sql = "SELECT * FROM evenement";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            $evenements = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $evenement = new Evenement($row['nom'], $row['Date'],$row['lieu'], $row['images'], $row['ID_Eve']);
                    array_push($evenements, $evenement);
                }
                return $evenements;
            }
            else{
                throw new EvenementInexistanteException();
            }
        }
        function obtenirEvenementsBenevole(){
            $sql = "SELECT * FROM evenement";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            $evenements = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $evenement = new Evenement($row['nom'], $row['Date'],$row['lieu'], $row['images'], $row['ID_Eve']);
                    array_push($evenements, $evenement);
                }
                return $evenements;
            }
            else{
                throw new EvenementInexistanteException();
            }
        }
        function obtenirTrancheHoraire($TH){
            $sql = "SELECT * FROM tranchehoraire WHERE description = '$TH->Description' and ID_Eve ='$TH->ID_Eve'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $row = mysqli_fetch_assoc($result);
                $trancheHoraire = new TrancheHoraire($row['description'],$row['points'],$row['date'],$row['ID_Eve'],$row['ID_Tra']);
                return $trancheHoraire;
            }
            else{
                throw new TrancheHoraireInexistanteException();
            }
        }
        function obtenirTrancheHoraires ($ID_Eve){
            $sql = "SELECT * FROM tranchehoraire WHERE ID_Eve = '$ID_Eve'";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            $THS = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $TH = new TrancheHoraire($row['description'], $row['points'],$row['date'],$row['ID_Eve'], $row['ID_Tra']);
                    array_push($THS, $TH);
                }
                return $THS;
            }
            else{
                throw new TrancheHoraireInexistanteException("NAN");
            }
        }
        function obtenirTrancheHorairesNonParticiper ($ID_Eve,$eMail){
            $sql = "SELECT * FROM tranchehoraire WHERE ID_Tra NOT IN(SELECT TH.ID_TRA FROM UtilisateurTrancheHoraire UT, tranchehoraire TH WHERE UT.ID_TRA = TH.ID_TRA AND UT.eMail = '$eMail')AND ID_Eve = '$ID_Eve'";
            //var_dump($sql);
            $result = $this->connexion->query($sql);
            if ($result){
                //var_dump($result);
                $rowcount=mysqli_num_rows($result);
            }
            $THS = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $TH = new TrancheHoraire($row['description'], $row['points'],$row['date'],$row['ID_Eve'], $row['ID_Tra']);
                    array_push($THS, $TH);
                }
                return $THS;
            }
            else{
                throw new TrancheHoraireInexistanteException("NAN");
            }
        }
        function obtenirTrancheHorairesNonParticiperBenevole ($ID_Eve,$ID_Ben){
            $sql = "SELECT * FROM tranchehoraire WHERE ID_Tra NOT IN(SELECT TH.ID_TRA FROM BenevoleTrancheHoraire UT, tranchehoraire TH WHERE UT.ID_TRA = TH.ID_TRA AND UT.ID_Ben = '$ID_Ben')AND ID_Eve = '$ID_Eve'";
            //var_dump($sql);
            $result = $this->connexion->query($sql);
            if ($result){
                //var_dump($result);
                $rowcount=mysqli_num_rows($result);
            }
            $THS = array();
            if($rowcount > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $TH = new TrancheHoraire($row['description'], $row['points'],$row['date'],$row['ID_Eve'], $row['ID_Tra']);
                    array_push($THS, $TH);
                }
                return $THS;
            }
            else{
                throw new TrancheHoraireInexistanteException("NAN");
            }
        }
        function obtenirBenevole ($bene){
            $sql = "SELECT * FROM benevole WHERE nom = '$bene->nom' and prenom = '$bene->prenom' ";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $row = mysqli_fetch_assoc($result);
                $bene = new Benevole ($row['nom'], $row['prenom'],$row['eMail'], $row['ID_Ben']);
               
                return $bene;
            }
            else{
                throw new BenevoleInexistantException();
            }
        }
        function obtenirBenevoles ($eMail){
            $sql = "SELECT * FROM benevole WHERE eMail = '$eMail' ";
            $result = $this->connexion->query($sql);
            if ($result=mysqli_query($this->connexion,$sql)){
                $rowcount=mysqli_num_rows($result);
            }$benes=array();
            if($rowcount > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $bene = new Benevole ($row['nom'], $row['prenom'],$row['eMail'], $row['ID_Ben']);
                    array_push($benes, $bene);
                }
                
               
                return $benes;
            }
            else{
                throw new BenevoleInexistantException();
            }
        }
        function creerCompetition($nouvelleCompetition){
          
            $sql = "INSERT INTO competition (ID_Com,nom,lieu,`date`, points, code, images) VALUES(null, '$nouvelleCompetition->nom', '$nouvelleCompetition->lieu', '$nouvelleCompetition->date', '$nouvelleCompetition->points',' $nouvelleCompetition->code', '$nouvelleCompetition->images')";
            $this->connexion->query($sql);
        }
        function creerEvenement($nouvelBenevole){
            $sql = "INSERT INTO evenement (ID_Eve,nom,Date,lieu, images) VALUES(null, '$nouvelBenevole->nom', '$nouvelBenevole->date', '$nouvelBenevole->lieu', '$nouvelBenevole->images')";
            $this->connexion->query($sql);
            return $this->connexion->insert_id;
        }
        function creerTrancheHoraire($nouvelleTrancheHoraire){
            $sql = "INSERT INTO TrancheHoraire (ID_Tra,description,points,date,ID_Eve) VALUES(null, '$nouvelleTrancheHoraire->Description', '$nouvelleTrancheHoraire->points', '$nouvelleTrancheHoraire->Date', '$nouvelleTrancheHoraire->ID_Eve')";
            $this->connexion->query($sql);
        }
        function creerUtilisateurTrancheHoraire($ID_TH){
            $eMail=$_SESSION['email'];
            
                $sql = "INSERT INTO UtilisateurTrancheHoraire (ID_Tra,eMail,Estvalide) VALUES('$ID_TH','$eMail', 0 )";
                $this->connexion->query($sql);
            
        }
        function creerBenevoleTrancheHoraire($THB,$ID_Ben){
            $sql = "INSERT INTO BenevoleTrancheHoraire ( ID_Ben, ID_Tra,Estvalide,Commentaire) VALUES('$ID_Ben','$THB','false','No comment')";
             $this->connexion->query($sql);
        }
        function creerBene($bene){
            
            $sql = "INSERT INTO Benevole (ID_Ben,nom,prenom,eMail) VALUES(null,'$bene->nom', '$bene->prenom','$bene->eMail' )";
            //var_dump($sql);
            $this->connexion->query($sql);
        }
        function obtenirProduit($produit){
            $sql = "SELECT * FROM produit WHERE nom = '$produit->nom'";
            $result = $this->connexion->query($sql);
            if ($result = mysqli_query($this->connexion,$sql)){
                $rowcount = mysqli_num_rows($result);
            }
            if($rowcount > 0){
                $row = mysqli_fetch_assoc($result);
                $produit = new Produit($row['nom'], $row['prix']);
                return $produit;
            }
                
            else {
                throw new ProduitInexistanteException();
            }

        }
        function creerProduit($produit){
            $sql = "INSERT INTO Produit ( nom, prix,image,description,nomCategorie,sousCategorie) VALUES('$produit->nom','$produit->prix','null','null','null','null')";
             $this->connexion->query($sql);
        }
        //Fin code Basil
    }
    
?>