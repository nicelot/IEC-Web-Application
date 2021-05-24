CREATE TABLE User(
                     UserID int NOT NULL,
                     Type varchar(45) NOT NULL,
                     Name varchar(45),
                     Email varchar(45),
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

CREATE TABLE Municipalities(
                               MunicipalityID varchar(6)  NOT NULL,
                               Name varchar(85),
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
                          MunicipalityId varchar(6) NOT NULL,
                          PRIMARY KEY (CandidateID),
                          CONSTRAINT FK_MunicipalityIdC FOREIGN KEY (MunicipalityId)
                              REFERENCES Municipalities(MunicipalityID),
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
                               VoteCastOn datetime,
                               PartyId int NOT NULL,
                               CandidateId int NOT NULL,
                               MunicipalityId varchar(6) NOT NULL,
                               PRIMARY KEY (DistrictVoteID),
                               CONSTRAINT FK_VoteIDD FOREIGN KEY (VoteID)
                                   REFERENCES Votes(VoteID),
                               CONSTRAINT FK_PartyIdD FOREIGN KEY (PartyId)
                                   REFERENCES Party(PartyID),
                               CONSTRAINT FK_MunicipalityIdD FOREIGN KEY (MunicipalityId)
                                   REFERENCES Municipalities(MunicipalityID),
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
                            MunicipalityId varchar(6) NOT NULL,
                            DistrictVoteId int,
                            PRIMARY KEY (LocalVoteID),
                            CONSTRAINT FK_VoteIDL FOREIGN KEY (VoteID)
                                REFERENCES Votes(VoteID),
                            CONSTRAINT FK_PartyIdL FOREIGN KEY (PartyId)
                                REFERENCES Party(PartyID),
                            CONSTRAINT FK_MunicipalityIdVL FOREIGN KEY (MunicipalityId)
                                REFERENCES Municipalities(MunicipalityID),
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
                      MunicipalityId varchar(6) NOT NULL,
                      VoteId int NOT NULL,
                      UserId int NOT NULL,
                      has_voted BIT(0),
                      PRIMARY KEY (NationalID),
                      CONSTRAINT FK_VoteIDVr FOREIGN KEY (VoteID)
                          REFERENCES Votes(VoteID),
                      CONSTRAINT FK_MunicipalityIdVr FOREIGN KEY (MunicipalityId)
                          REFERENCES Municipalities(MunicipalityID),
                      CONSTRAINT FK_UserIdVr FOREIGN KEY (UserId)
                          REFERENCES User(UserID)
);

CREATE TABLE Results(
                        ResultID int NOT NULL,
                        MunicipalityId varchar(6) NOT NULL,
                        PartyId int NOT NULL,
                        CONSTRAINT FK_PartyIdR FOREIGN KEY (PartyId)
                            REFERENCES Party(PartyID),
                        CONSTRAINT FK_MunicipalityIdR FOREIGN KEY (MunicipalityId)
                            REFERENCES Municipalities(MunicipalityID),
                        PRIMARY KEY (ResultID)
);



INSERT INTO Municipalities (MunicipalityID, Name, Type)
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
       ('WC053', 'Beaufort West Local Municipality','Local'),
       ('WC047', 'Bitou Local Municipality','Local'),
       ('LIM351', 'Blouberg Local Municipality','Local'),
       ('LIM345', 'Collins Chabane Local Municipality','Local'),
       ('MP306', 'Dipaleseng Local Municipality','Local'),
       ('NW384', 'Ditsobotla Local Municipality','Local'),
       ('EC101', 'Dr Beyers Naudé Local Municipality','Local'),
       ('NC073', 'Emthanjeni Local Municipality','Local'),
       ('LIM476', 'Fetakgomo Tubatse Local Municipality','Local'),
       ('WC044', 'George Local Municipality','Local'),
       ('NC074', 'Kareeberg Local Municipality','Local');