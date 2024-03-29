CREATE SCHEMA IEC_DB;

CREATE TABLE Municipality(
  MunicipalityID varchar(45) NOT NULL,
  Name varchar(64),
  Type varchar(45) NOT NULL,
  PRIMARY KEY (MunicipalityID)
);

CREATE TABLE User(
  UserID int NOT NULL AUTO_INCREMENT,
  Type varchar(45) NOT NULL,
  Name varchar(45),
  Email varchar(45),
  PRIMARY KEY (UserID)
);

CREATE TABLE Staff(
  StaffID int NOT NULL AUTO_INCREMENT,
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

CREATE TABLE Voter(
  NationalID varchar(13) NOT NULL,
  Name varchar(45),
  Surname varchar(45),
  Password varchar(45),
  Email varchar(45),
  PhoneNr int,
  MunicipalityId varchar(45) NOT NULL,
  UserId int NOT NULL,
  has_voted BIT NOT NULL DEFAULT (0),
  PRIMARY KEY (NationalID),
  CONSTRAINT FK_MunicipalityIdVr FOREIGN KEY (MunicipalityId)
      REFERENCES Municipality(MunicipalityID),
  CONSTRAINT FK_VoterUserId FOREIGN KEY (UserId)
      REFERENCES User(UserID)
);

CREATE TABLE Party(
  PartyID varchar(10) NOT NULL,
  Name varchar(45) NOT NULL,
  PRIMARY KEY (PartyID)
);

CREATE TABLE Candidate(
  CandidateID int NOT NULL AUTO_INCREMENT,
  Name varchar(45),
  Surname varchar(45),
  PartyId varchar(10) NOT NULL,
  Type varchar(45),
  MunicipalityId varchar(45) NOT NULL,
  PRIMARY KEY (CandidateID),
  CONSTRAINT FK_MunicipalityIdC FOREIGN KEY (MunicipalityId)
      REFERENCES Municipality(MunicipalityID),
  CONSTRAINT FK_PartyId FOREIGN KEY (PartyId)
      REFERENCES Party(PartyID)
);

CREATE TABLE Votes(
  VoteID int NOT NULL AUTO_INCREMENT,
  Type varchar(45) NOT NULL,
  CandidateID int NOT NULL,
  PRIMARY KEY (VoteID),
  CONSTRAINT FK_CandidateID FOREIGN KEY (CandidateID)
      REFERENCES Candidate(CandidateID)
);

CREATE TABLE Results(
  ResultID int NOT NULL,
  MunicipalityId varchar(45) NOT NULL,
  PartyId varchar (10) NOT NULL,
  PRIMARY KEY (ResultID),
  CONSTRAINT FK_PartyIdR FOREIGN KEY (PartyId)
      REFERENCES Party(PartyID),
  CONSTRAINT FK_MunicipalityIdR FOREIGN KEY (MunicipalityId)
      REFERENCES Municipality(MunicipalityID)
);

INSERT INTO Municipality (MunicipalityID, Name, Type)
VALUES ('CPT', 'City of Cape Town Metropolitan Municipality','Metropolitan'),
       ('JHB', 'City of Johannesburg Metropolitan Municipality','Metropolitan'),
       ('TSH', 'City of Tshwane Metropolitan Municipality','Metropolitan'),
       ('ETH', 'eThekwini Metropolitan Municipality','Metropolitan'),
       ('MAN', 'Mangaung Metropolitan Municipality','Metropolitan'),
       ('NMA', 'Nelson Mandela Bay Metropolitan Municipality','Metropolitan'),
       ('DC1', 'West Coast District Municipality','District'),
       ('DC4', 'Garden Route District Municipality','District'),
       ('DC24', 'uMzinyathi District Municipality','District'),
       ('DC26', 'Zululand District Municipality','District'),
       ('DC35', 'Capricorn District Municipality','District'),
       ('DC40', 'Dr Kenneth Kaunda District Municipality','District'),
       ('DC48', 'West Rand District Municipality','District'),
       ('KZN238', 'Alfred Duma Local Municipality','Local'),
       ('KZN294', 'Maphumulo Local Municipality','Local'),
       ('WC053', 'Beaufort West Local Municipality','Local'),
       ('WC047', 'Bitou Local Municipality','Local'),
       ('LIM351', 'Blouberg Local Municipality','Local'),
       ('LIM345', 'Collins Chabane Local Municipality','Local'),
       ('MP306', 'Dipaleseng Local Municipality','Local'),
       ('MP305', 'Lekwa Local Municipality','Local'),
       ('NW384', 'Ditsobotla Local Municipality','Local'),
       ('EC101', 'Dr Beyers Naudé Local Municipality','Local'),
       ('NC073', 'Emthanjeni Local Municipality','Local'),
       ('NC062', 'Nama Khoi Local Municipality','Local'),
       ('LIM476', 'Fetakgomo Tubatse Local Municipality','Local'),
       ('LIM332', 'Greater Letaba Local Municipality','Local'),
       ('WC044', 'George Local Municipality','Local'),
       ('WC048', 'Knysna Local Municipality','Local'),
       ('NC074', 'Kareeberg Local Municipality','Local');

INSERT INTO User (Type, Name, Email)
VALUES ('Staff','Jane Doe', 'janedoe@gmail.com'),
       ('Staff','Mary Sue', 'marysue@gmail.com'),
       ('Staff','Kevin Smith', 'kevinsmith@gmail.com'),
       ('Voter','Taylor Adams', 'tayloradams@gmail.com'),
       ('Voter','John Johnson', 'johnjohnson@gmail.com'),
       ('Voter','Anne Anderson', 'anneanderson@gmail.com');


INSERT INTO Staff (UserID, Name, Surname, Password, Email, PhoneNr)
VALUES (1, 'Jane', 'Doe', 'password', 'janedoe@gmail.com', 0825194011),
       (2, 'Mary', 'Sue', '54321', 'marysue@gmail.com', 0723484019),
       (3, 'Kevin', 'Smith', '9999', 'kevinsmith@gmail.com', 0825299456);

INSERT INTO Voter (NationalID, Name, Surname, Password, Email, PhoneNr, MunicipalityId, UserId, has_voted)
VALUES ('1111111111111', 'Taylor','Adams', 'password1', 'tayloradams@gmail.com', 0126547890, 'DC35', 4, 0),
       ('9807536795313', 'John','Johnson', 'password2', 'johnjohnson@gmail.com', 0716783407, 'KZN238', 5, 0),
       ('7865093175490', 'Anne','Anderson', 'password3', 'anneanderson@gmail.com', 0115609835, 'JHB', 6, 0);

INSERT INTO Party (PartyID, Name)
VALUES ('ANC','African National Congress'),
       ('DA','Democratic Alliance'),
       ('IFP','Inkatha Freedom Party'),
       ('EFF','Economic Freedom Fighters'),
       ('INTP','International Party');

INSERT INTO Candidate (Name, Surname, PartyId, Type, MunicipalityId)
VALUES ('DINEO ZANDILE', 'MASIU', 'DA', 'Metropolitan', 'CPT'),
       ('KHANYISO', 'FODO', 'EFF', 'Metropolitan', 'CPT'),
       ('DMLAMLELI MORRIS', 'MTHINI', 'ANC', 'Metropolitan', 'CPT'),
       ('BLESSING NHLAKANIPHO', 'GUMEDE', 'EFF', 'Metropolitan', 'ETH'),
       ('VINCENT THOKOZANI', 'MALINGA', 'IFP', 'Metropolitan', 'ETH'),
       ('LUNGISANI CONRAD', 'SIKAKANE', 'ANC', 'Metropolitan', 'ETH'),
       ('SIBUSISO BLESSING', 'NGQULUNGA', 'ANC', 'Local', 'MP306'),
       ('THULANI GLADWIN', 'ZWANE', 'EFF', 'Local', 'MP306'),
       ('JACK STEVEN', 'SIMONS', 'DA', 'Local', 'WC047'),
       ('NKOSIKHONA THULISANI', 'NCENGWA', 'IFP', 'Local', 'KZN238'),
       ('SANDILE JOEL', ' MNGUNI', 'EFF', 'Local', 'KZN238'),
       ('MASHAO PRIME', 'MOKGOBI', 'EFF', 'Local', 'LIM351'),
       ('MPHALELWA SHADRACK', 'MOKHABUKHI', 'ANC', 'Local', 'LIM345'),
       ('LORRAINE VALERIE', 'OPPERMAN', 'ANC', 'Local', 'WC047');