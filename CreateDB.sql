CREATE SCHEMA IEC_DB;


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
		CONSTRAINT FK_StaffUserId FOREIGN KEY (UserId)
    		REFERENCES User(UserID)
	);

CREATE TABLE Municipality(
		MunicipalityID int NOT NULL,
		Name varchar(45),
		Type varchar(45) NOT NULL,
		PRIMARY KEY (MunicipalityID)
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
		Candidate varchar(45) NOT NULL,
		PRIMARY KEY (VoteID)
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
		has_voted BIT NOT NULL DEFAULT (0),
		PRIMARY KEY (NationalID),
		CONSTRAINT FK_VoteIDVr FOREIGN KEY (VoteID)
    		REFERENCES Votes(VoteID),
		CONSTRAINT FK_MunicipalityIdVr FOREIGN KEY (MunicipalityId)
    		REFERENCES Municipality(MunicipalityID),
		CONSTRAINT FK_VoterUserId FOREIGN KEY (UserId)
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

