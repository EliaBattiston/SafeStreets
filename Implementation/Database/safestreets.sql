CREATE DATABASE safestreets;

USE safestreets;

CREATE TABLE roles(
    name varchar(100) PRIMARY KEY
);

CREATE TABLE users(
    fiscalCode CHAR(16) PRIMARY KEY,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    passwordHash CHAR(64) NOT NULL,
    suspended BOOLEAN DEFAULT false NOT NULL,
    suspendedTimestamp TIMESTAMP NULL DEFAULT NULL,
    acceptedTimestamp TIMESTAMP NULL DEFAULT NULL,
    accepterAdmin CHAR(16) DEFAULT NULL,
    role varchar(100) NOT NULL,
    FOREIGN KEY (accepterAdmin) REFERENCES users(fiscalCode) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (role) REFERENCES roles(name) ON DELETE NO ACTION ON UPDATE CASCADE
);

/*
CREATE TABLE suggestionTypes(
    suggTypeID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) UNIQUE NOT NULL,
    description TEXT not null
);
*/

/*
CREATE TABLE severities(
    severityID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);
*/

/*
INSERT INTO severities (name)
VALUES
    ("Low"),
    ("Medium"),
    ("High");
*/

/*
*   The suggestions feature will not be implemented since only one of the advances functionalities
*   is required. Its database tables have been created anyay for consistency with the DD's ER diagram
*/

/*
CREATE TABLE suggestions(
    suggestionID BIGINT AUTO_INCREMENT PRIMARY KEY,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    suggType INT NOT NULL,
    severity INT NOT NULL,
    FOREIGN KEY (suggType) REFERENCES suggestionTypes(suggTypeID) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (severity) REFERENCES severities(severityID) ON DELETE NO ACTION ON UPDATE CASCADE
);
*/

CREATE TABLE violations(
    violationID INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL
);

INSERT INTO violations (description)
VALUES
    ("Other"),
    ("Double parking"),
    ("Parking in no parking area"),
    ("Traffic obstruction"),
    ("Parking disk over time"),
    ("Parking in paid area without receipt"),
    ("Abandoned car"),
    ("Left rear view mirror damaged or missing"),
    ("Parking on sidewalk"),
    ("Parking on bicycle or walkable lane");

CREATE TABLE streets(
    streetID BIGINT AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE reports(
    reportID BIGINT PRIMARY KEY,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    notes TEXT,
    licensePlate CHAR(7) NOT NULL,
    latitude FLOAT NOT NULL,
    longitude FLOAT NOT NULL,
    user CHAR(16) NOT NULL,
    violation INT NOT NULL,
    street BIGINT NOT NULL,
    FOREIGN KEY (user) REFERENCES users(fiscalCode) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (violation) REFERENCES violations(violationID) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (street) REFERENCES streets(streetID) ON DELETE NO ACTION ON UPDATE CASCADE
);

/*
CREATE TABLE suggestionReports(
    suggestionID BIGINT,
    reportID BIGINT,
    PRIMARY KEY (suggestionID, reportID),
    FOREIGN KEY (suggestionID) REFERENCES suggestions(suggestionID) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (reportID) REFERENCES reports(reportID) ON DELETE NO ACTION ON UPDATE CASCADE
);
*/

CREATE TABLE trafficTickets(
    ticketID BIGINT PRIMARY KEY,
    licensePlate CHAR(7) NOT NULL,
    violation INT NOT NULL,
    street BIGINT NOT NULL,
    FOREIGN KEY (violation) REFERENCES violations(violationID) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (street) REFERENCES streets(streetID) ON DELETE NO ACTION ON UPDATE CASCADE
);

/*
CREATE TABLE suggestionTickets(
    suggestionID BIGINT,
    ticketID BIGINT,
    PRIMARY KEY (suggestionID, ticketID),
    FOREIGN KEY (suggestionID) REFERENCES suggestions(suggestionID) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (ticketID) REFERENCES trafficTickets(ticketID) ON DELETE NO ACTION ON UPDATE CASCADE
);
*/

CREATE TABLE accidents(
    accidentID BIGINT PRIMARY KEY,
    licensePlate CHAR(7) NOT NULL,
    timestamp TIMESTAMP NOT NULL,
    street BIGINT NOT NULL,
    FOREIGN KEY (street) REFERENCES streets(streetID) ON DELETE NO ACTION ON UPDATE CASCADE
);

/*
CREATE TABLE suggestionAccidents(
    suggestionID BIGINT,
    accidentID BIGINT,
    PRIMARY KEY (suggestionID, accidentID),
    FOREIGN KEY (suggestionID) REFERENCES suggestions(suggestionID) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (accidentID) REFERENCES accidents(accidentID) ON DELETE NO ACTION ON UPDATE CASCADE
);
*/