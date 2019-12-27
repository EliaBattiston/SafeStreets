USE safestreets;

/* The password for all test users is "test" */
INSERT INTO users (fiscalCode, firstName, lastName, username, passwordHash, suspended, acceptedTimestamp, accepterAdmin, role)
VALUES
    (
        "ABCABCABCA000000",
        "Name",
        "Surname",
        "regularUser",
        "64adb780ea98d46b53605c3044c14f164f753f97f7f828888e65881a2dafc9ea",
        false,
        CURRENT_TIMESTAMP,
        "0000000000000000",
        1
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
        2
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
        3
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
        4
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
        1
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
        1
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
        1
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

INSERT INTO streets(name)
VALUES
    ("Test street");

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