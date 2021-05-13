CREATE SCHEMA uxxxxxxxx_municipal_elections;


CREATE TABLE User(
		UserID int NOT NULL,
		Type varchar(45) NOT NULL,
		Name varchar(45),
		PRIMARY KEY (UserID)
	);

CREATE TABLE Staff(
		StaffID int NOT NULL,
		UserId int NOT NULL,
		Name varchar(45),
		Surname varchar(45),
		Password varchar(45),
		Email varchar(45),
		PhoneNr int,
		PRIMARY KEY (StaffID),
		CONSTRAINT FK_UserIdS FOREIGN KEY (UserId)
    		REFERENCES User(UserID)
	);

CREATE TABLE Municipality(
		MunicipalityID int NOT NULL,
		Type varchar(45) NOT NULL,
		Name varchar(45),
		PRIMARY KEY (MunicipalityID)
	);

CREATE TABLE Municipalities_District(
		DistrictMunicipalityID int NOT NULL,
		MunicipalityId int NOT NULL,
		PRIMARY KEY (DistrictMunicipalityID),
		CONSTRAINT FK_MunicipalityId FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID)
	); 

CREATE TABLE Municipalities_Metro(
		MetroMunicipalityID int NOT NULL,
		MunicipalityId int NOT NULL,
		Name varchar(45) NOT NULL,
		PRIMARY KEY (MetroMunicipalityID),
		CONSTRAINT FK_MunicipalityIdM FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID)
	); 

CREATE TABLE Municipalities_Local(
		LocalMunicipalityID int NOT NULL,
		MunicipalityId int NOT NULL,
		DistrictMunicipalityId int NOT NULL,
		Name varchar(45) NOT NULL,
		FOREIGN KEY (DistrictMunicipalityId) REFERENCES Municipalities_District(DistrictMunicipalityID),
		PRIMARY KEY (LocalMunicipalityID),
		CONSTRAINT FK_MunicipalityIdL FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID),
		CONSTRAINT FK_DistrictMunicipalityId FOREIGN KEY (DistrictMunicipalityId)
    		REFERENCES Municipalities_District(DistrictMunicipalityID)
	);

CREATE TABLE Party(
		PartyID int NOT NULL,
		Name varchar(45) NOT NULL,
		PRIMARY KEY (PartyID)
	);

CREATE TABLE Candidate(
		CandidateID int NOT NULL,
		Name varchar(45),
		Surname varchar(45),
		PartyId int NOT NULL,
		Type varchar(45),
		MunicipalityId int NOT NULL,
		PRIMARY KEY (CandidateID),
		CONSTRAINT FK_MunicipalityIdC FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID),
		CONSTRAINT FK_PartyId FOREIGN KEY (PartyId)
    		REFERENCES Party(PartyID)
	);

CREATE TABLE Votes(
		VoteID int NOT NULL,
		Type varchar(45) NOT NULL,
		PRIMARY KEY (VoteID)
	);


CREATE TABLE Votes_District(
		DistrictVoteID int NOT NULL,
		VoteID int NOT NULL,
		VotCastOn datetime,
		PartyId int NOT NULL,
		CandidateId int NOT NULL,
		MunicipalityId int NOT NULL,
		LocalVoteId int NOT NULL,
		PRIMARY KEY (DistrictVoteID)
		CONSTRAINT FK_VoteIDD FOREIGN KEY (VoteID)
    		REFERENCES Votes(VoteID),
		CONSTRAINT FK_PartyIdD FOREIGN KEY (PartyId)
    		REFERENCES Party(PartyID),
		CONSTRAINT FK_MunicipalityIdD FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID),
		CONSTRAINT FK_CandidateIdD FOREIGN KEY (CandidateId)
    		REFERENCES Candidate(CandidateID)
	);


CREATE TABLE Votes_Local(
		LocalVoteID int NOT NULL,
		VoteID int NOT NULL,
		Type varchar(45) NOT NULL,
		VoteCastOn datetime NOT NULL,
		PartyId int NOT NULL,
		CandidateId int NOT NULL,
		MunicipalityId int NOT NULL,
		DistrictVoteId int,
		PRIMARY KEY (LocalVoteID),
		CONSTRAINT FK_VoteIDL FOREIGN KEY (VoteID)
    		REFERENCES Votes(VoteID),
		CONSTRAINT FK_PartyIdL FOREIGN KEY (PartyId)
    		REFERENCES Party(PartyID),
		CONSTRAINT FK_MunicipalityIdVL FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID),
		CONSTRAINT FK_CandidateIdL FOREIGN KEY (CandidateId)
    		REFERENCES Candidate(CandidateID),
		CONSTRAINT FK_DistrictVoteIdL FOREIGN KEY (DistrictVoteId)
    		REFERENCES Votes_District(DistrictVoteID)
	);

CREATE TABLE Voter(
		NationalID int NOT NULL,
		Name varchar(45),
		Surname varchar(45),
		Password varchar(45),
		Email varchar(45),
		PhoneNr int,
		MunicipalityId int NOT NULL,
		VoteId int NOT NULL,
		UserId int NOT NULL,
		PRIMARY KEY (NationalID),
		CONSTRAINT FK_VoteIDVr FOREIGN KEY (VoteID)
    		REFERENCES Votes(VoteID),
		CONSTRAINT FK_MunicipalityIdVr FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID),
		CONSTRAINT FK_UserIdS FOREIGN KEY (UserId)
    		REFERENCES User(UserID)
	);

CREATE TABLE Results(
		ResultID int NOT NULL,
		MunicipalityId int NOT NULL,
		PartyId int NOT NULL,
		CONSTRAINT FK_PartyIdR FOREIGN KEY (PartyId)
    		REFERENCES Party(PartyID),
		CONSTRAINT FK_MunicipalityIdR FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID),
		PRIMARY KEY (ResultID)
	);

