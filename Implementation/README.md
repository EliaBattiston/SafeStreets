# SafeStreets implementation

This folder of the repository containts all the components of the project's implementation.

## [Database](Database)

The database is provided as a SQL file which can be imported in the desired DBMS.
Tables needed for the _suggestions_ advanced functionality are included but commented in the file for consistency with the ER model described in the DD document.

## [API](API)
[![Test results](https://github.com/EliaBattiston/AspesiBattistonCarabelli/workflows/API%20Tests/badge.svg)](https://github.com/EliaBattiston/AspesiBattistonCarabelli/actions)

RESTful APIs for Accounts, Mobile application and Web client are developed in PHP.
Full documentation on endpoints, parameters and return codes can be found in the folder's [README](API/README.md) file.

### Testing
APIs are tested with [PHPUnit](https://phpunit.de/).

All tests can be found in the [API/tests](API/tests) folder. Their results are checked with Github Actions (Github's CI/CD platform) every time new commits are pushed and can be found [here](https://github.com/EliaBattiston/AspesiBattistonCarabelli/actions).