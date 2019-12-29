# SafeStreets - <sub><sup>Software Engineering 2 project A.Y. 2019/20</sup></sub>

## Group members
- ###   10522850    Aspesi Andrea ([@AndreaAspesiPoli](https://github.com/AndreaAspesiPoli))<br>andrea.aspesi@mail.polimi.it
- ###   10522687    Battiston Elia ([@EliaBattiston](https://github.com/EliaBattiston))<br>elia.battiston@mail.polimi.it
- ###   10518898    Carabelli Alessandro ([@AleCarabelli](https://github.com/AleCarabelli))<br>alessandro2.carabelli@mail.polimi.it

## Implementation
[![Test results](https://github.com/EliaBattiston/AspesiBattistonCarabelli/workflows/API%20Tests/badge.svg)](https://github.com/EliaBattiston/AspesiBattistonCarabelli/actions)
[![Deploy results](https://github.com/EliaBattiston/AspesiBattistonCarabelli/workflows/API%20&%20WebClient%20Deploy/badge.svg)](https://github.com/EliaBattiston/AspesiBattistonCarabelli/actions)

Details of the implementation and most of its documentation can be found in README files located in the [Implementation](Implementation) directory and its subdirectories.

Using Github Actions (Github's CI/CD platform), tests are performed at every commit. If succesful, APIs from the `master` branch are automatically deployed to the `https://safestreets.altervista.org/api` endpoint.
The web client is deployed to `https://safestreets.altervista.org/web`.

### Private deployment instructions
#### Database
To deploy the database, import `Implementation/Database/safestreets.sql` in your preferred DBMS.

#### APIs
To deploy APIs, upload the `Implementation/API` folder to the desired web hosting.
You can configure the database parameters by editing `config.php`, placed in the root of the uploaded folder.

#### Web client
To deploy the Web client, upload the `Implementation/WebClient` folder to the desired web hosting.
You can configure the API endpoint by editing `src/config.php`, placed in the root of the uploaded folder.