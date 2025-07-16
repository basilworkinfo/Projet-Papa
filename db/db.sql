drop table if exists Utilisateur ;

create table Utilisateur(
	eMail varchar(250) primary key,
    MDP varchar(250) not null,
    pseudo varchar(250) not null,
    nom varchar(250) not null,
    prenom varchar(250) not null,
    Tel varchar(250) not null,
    addresse varchar(250) not null
	 );
INSERT INTO Utilisateur(eMail, MDP, pseudo, nom, prenom, Tel, addresse)
VALUES ('admin@admin.admin', '2025', 'admin', 'admin', 'admin', '0455178334', 'Bodange');