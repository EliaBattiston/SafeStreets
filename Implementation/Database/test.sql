USE safestreets;

/* The password for all test users is "test" */
INSERT INTO users (fiscalCode, firstName, lastName, username, passwordHash, suspended, acceptedTimestamp, accepterAdmin, role, email)
VALUES
    (
        "ABCABCABCA000000",
        "Name",
        "Surname",
        "regularUser",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        NULL,
        "0000000000000000",
        1,
        "regularUser@safestreets.org"
    ),
    (
        "ABCABCABCA000001",
        "Name",
        "Surname",
        "officerUser",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        2,
        "officerUser@safestreets.org"
    ),
    (
        "ABCABCABCA000002",
        "Name",
        "Surname",
        "administratorUser",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        3,
        "administratorUser@safestreets.org"
    ),
    (
        "ABCABCABCA000003",
        "Name",
        "Surname",
        "systemUser",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        4,
        "systemUser@safestreets.org"
    ),
    (
        "ABCABCABCA000004",
        "Name",
        "Surname",
        "userWithReports1",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        1,
        NULL
    ),
    (
        "ABCABCABCA000005",
        "Name",
        "Surname",
        "userWithReports2",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        1,
        NULL
    ),
    (
        "ABCABCABCA000006",
        "Name",
        "Surname",
        "userWithoutReports",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        1,
        NULL
    );

INSERT INTO users (fiscalCode, firstName, lastName, username, passwordHash, suspended, suspendedTimestamp, acceptedTimestamp, accepterAdmin, role)
VALUES
    (
        "ABCABCABCA000007",
        "Name",
        "Surname",
        "suspendedUser",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        true,
        CURRENT_TIMESTAMP,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        1
    );

INSERT INTO streets (streetID, name) 
VALUES
    (
        1, 
        'via Monte Bernasco, Varese'
    ),
    (
        2, 
        'via Dante Alighieri, Samarate'
    ),
    (
        3, 
        'via Bonacalza, Oggiona con Santo Stefano'
    ),
    (
        4, 
        'via Saffi, Varese'
    );

INSERT INTO reports (notes, licensePlate, latitude, longitude, user, violation, street)
VALUES
    (
        "Test notes of user 1",
        "AB123DE",
        45.431180,
        9.125840,
        "ABCABCABCA000004",
        1,
        1
    ),
    (
        "Test notes of user 1",
        "AB123DE",
        45.431180,
        9.125840,
        "ABCABCABCA000004",
        1,
        1
    ),
    (
        "Test notes of user 2",
        "AB123DE",
        45.431180,
        9.125840,
        "ABCABCABCA000005",
        1,
        1
    ),
    (
        "Test notes of user 2",
        "AB123DE",
        45.431180,
        9.125840,
        "ABCABCABCA000005",
        1,
        1
    );

INSERT INTO accidents (`accidentID`, `licensePlate`, `timestamp`, `street`) 
VALUES
    (
        1, 
        'AA000BB', 
        '2019-12-27 16:01:51', 
        2
    ),
    (
        2, 
        'EN741VD', 
        '2019-12-27 16:02:01',
        4
    ),
    (
        47, 
        'CZ123BC', 
        '2019-12-27 16:47:17', 
        3
    );

INSERT INTO trafficTickets (ticketID, licensePlate, violation, street) VALUES
    (
        10, 
        'FN597PK', 
        7, 
        3
    ),
    (
        11, 
        'BF819ML', 
        9, 
        4
    ),
    (
        21, 
        'CC111DD', 
        1, 
        3
    ),
    (
        22, 
        'BB333EE', 
        3, 
        3
    );