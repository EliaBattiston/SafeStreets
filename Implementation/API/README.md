# SafeStreets API documentation

## Result codes

The response of every API endpoint, provided as json, has a _result_ field in its root.
The value of _result_ gives information about the status of the request and the content which can be found in the rest of the response.

| Code | Meaning                                        |
|------|------------------------------------------------|
| 200  | The request was successful                     |
| 4xx  | There was an error while executing the request |

### Code 200

If _result_ has a value of 200, the request has been succesfully elaborated.
The _content_ field will contain the results of the request.

#### Example
```
{
  "result": 200,
  "content": ...
}
```

### Code 4xx

A value of _result_ between 400 and 499 signals the presence of an error, and a _message_ field explaining what happened can be found in the root of the request.
The _message_ field will contain a description of the occurred error.

#### Example
```
{
  "result": 401,
  "message": "The username/password pair is incorrect"
  ...
}
```

#### Common error codes

Some error codes have a consistent interpretation in the whole API. These are reported in the following table:

| Code      | Error                                                   |
|-----------|---------------------------------------------------------|
| 400       | Generic error. Details will be provided in the message  |
| 401       | Username/password pair is incorrect                     |
| 402       | User suspended                                          |
| 403       | User not authorized                                     |
| 404       | Missing or invalid parameters                           |

Error codes not included in this table are code which assume a different meaning based on the called method.
Their meaning can be found in the section dedicated to the specific method.

# Accounts API methods

## Login

#### Endpoint and parameters
```
POST [endpoint]/accounts/login/
```

| Parameter | Type    | Required |
|-----------|---------|----------|
| username  | string  |    Y     |
| password  | string  |    Y     |

#### Successfull response
```
{
  "result":200,
  "content":{
    "fiscalCode":"0000000000000000",
    "firstName":"FirstName",
    "lastName":"LastName",
    "username":"username",
    "suspended":0,
    "roleCode":1,
    "roleDesc":"Regular"
  }
}
```

#### Specific error codes

| Code      | Error                               |
|-----------|-------------------------------------|
| 401       | Username/password pair is incorrect |
| 402       | User suspended                      |

## Signup

#### Endpoint and parameters
```
POST [endpoint]/accounts/signup/
```

| Parameter     | Type    | Required |
|---------------|---------|----------|
| username      | string  |    Y     |
| password      | string  |    Y     |
| firstName     | string  |    Y     |
| lastName      | string  |    Y     |
| email         | string  |    Y     |
| fiscalCode    | string  |    Y     |
| documentPhoto | string  |    Y     |

The _documentPhoto_ parameter is a string representing a base64-encoded `.jpg` picture.


#### Payload example
```
{
  "username":"newUserUsername",
  "password":"newUserPassword",
  "firstName":"newUserFirstName",
  "lastName":"newUserLastName",
  "email":"newUserEmail@provider.com",
  "fiscalCode":"ABCDEF12G34H567I",
  "documentPhoto":"_base64 encoded photo_"
}
```

#### Specific error codes

| Code      | Error                               |
|-----------|-------------------------------------|
| 405       | Fiscal code already registered      |
| 406       | Username already in use             |
| 407       | Error loading picture               |


# Mobile API methods

## Reports
Reports endpoint for insertion and retrieval

### Data retrieval
Response data only contains reports made by the calling user.

#### Endpoint and parameters
```
GET [endpoint]/web/reports/
```

| Parameter | Type    | Required |
|-----------|---------|----------|
| username  | string  |    Y     |
| password  | string  |    Y     |

#### Successfull response
```
{
  "result":200,
  "content": [
    {
      "username":"reporterUsername",
      "reportID":1,
      "timestamp":"2000-01-01 00:00:01",
      "address":"address",
      "latitude": 45.000000,
      "longitude": 8.000000,
      "licensePlate":"AA000AA",
      "violation":"violation",
      "notes":"notes",
      "pictures": [
        "https://safestreets.altervista.org/...",
        ...
      ]
    },
    ...
  ]
}
```

### Specific report retrieval
The response contains detailed information about the desired report. The request is succesful only if the report has been sent by the requesting user.

#### Endpoint and parameters
```
GET [endpoint]/mobile/reports/
```

| Parameter | Type    | Required |
|-----------|---------|----------|
| username  | string  |    Y     |
| password  | string  |    Y     |
| reportID  | string  |    Y     |

#### Successfull response
```
{
  "result":200,
  "content": {
    "username":"reporterUsername",
    "reportID":1,
    "timestamp":"2000-01-01 00:00:01",
    "address":"address",
    "latitude": 45.000000,
    "longitude": 8.000000,
    "licensePlate":"AA000AA",
    "violation":"violation",
    "notes":"notes",
      "pictures": [
        "https://safestreets.altervista.org/...",
        ...
      ]
  }
}
```

### Insertion
Pictures will be saved in
```
[endpoint]/reportPictures/<reportID>/<reportID>-pic-<progressive number>
```

#### Endpoint and parameters
```
POST [endpoint]/mobile/reports/
```

| Parameter         | Type    | Required |
|-------------------|---------|----------|
| username          | string  |     Y    |
| password          | string  |     Y    |
| plate             | char(7) |     Y    |
| violationType     | integer |     Y    |
| latitude          | float   |     Y    |
| longitude         | float   |     Y    |
| pictures          | string  |     Y    |

The _pictures_ parameter is a string representing a json array of base64-encoded `.jpg` pictures.


#### Specific error codes

| Code      | Error                              |
|-----------|------------------------------------|
| 405       | Error loading pictures             |

## StreetSafety
The endpoint provides data about Street Safety.

#### Endpoint and parameters
```
GET [endpoint]/mobile/streetSafety/
```

#### Successfull response
```
{
  "result":200,
  "content": [
    {
      "address":"address",
      "latitude": 45.000000,
      "longitude": 8.000000,
      "severity":"High",
      "content":"violationDetails"
    },
    ...
  ]
}
```

# Web API methods

## Reports
Officer reports endpoint for retrieval of the whole data about users made reports.

### Data retrieval

#### Endpoint and parameters
```
GET [endpoint]/web/reports/
```

| Parameter | Type    | Required |
|-----------|---------|----------|
| username  | string  |    Y     |
| password  | string  |    Y     |

#### Successfull response
```
{
  "result":200,
  "content": [
    {
      "username":"reporterUsername",
      "reportID":1,
      "timestamp":"2000-01-01 00:00:01",
      "address":"address",
      "licensePlate":"AA000AA",
      "violation":"violation",
      "notes":"notes",
      "pictures": [
        "https://safestreets.altervista.org/...",
        ...
      ]
    },
    ...
  ]
}
```

### Specific report retrieval
The response contains detailed information about the desired report.

#### Endpoint and parameters
```
GET [endpoint]/mobile/reports/
```

| Parameter | Type    | Required |
|-----------|---------|----------|
| username  | string  |    Y     |
| password  | string  |    Y     |
| reportID  | string  |    Y     |

#### Successfull response
```
{
  "result":200,
  "content": {
    "username":"reporterUsername",
    "firstName":"reporterFirstName",
    "lastName":"reporterLastName",
    "reportID":1,
    "timestamp":"2000-01-01 00:00:01",
    "address":"address",
    "latitude": 45.000000,
    "longitude": 8.000000,
    "licensePlate":"AA000AA",
    "violation":"violation",
    "notes":"notes",
      "pictures": [
        "https://safestreets.altervista.org/...",
        ...
      ]
  }
}
```

## User creation

#### Limitations
This API can be used only by users with Officer or Administrator access level

#### Endpoint and parameters
```
POST [endpoint]/web/accounts/
```

| Parameter     | Type    | Required |
|---------------|---------|----------|
| username      | string  |    Y     |
| password      | string  |    Y     |
| newusername   | string  |    Y     |
| newpassword   | string  |    Y     |
| firstName     | string  |    Y     |
| lastName      | string  |    Y     |
| email         | string  |    Y     |
| fiscalCode    | string  |    Y     |
| documentPhoto | string  |    Y     |

While _newusername_ and _newpassword_ are related to new new user, _username_ and _password_ parameters refers to the Officer/Administrator who is creating the user.
The _documentPhoto_ parameter is a string representing a base64-encoded `.jpg` picture.

#### Payload example
```
username=officerUsername
&password=officerPassword
&newusername=newUserUsername
&newpassword=newUserPassword
&firstName=newUserFirstName
&lastName=newUserLastName
&email=newUserEmail@provider.com
&fiscalCode=ABCDEF12G34H567I
&documentPhoto="abc123v3be... (base64_encoded_photo)"
```


#### Specific error codes

| Code      | Error                               |
|-----------|-------------------------------------|
| 405       | Fiscal code already registered      |
| 406       | Username already in use             |
| 407       | Error loading picture               |


## Users data retrieval

#### Limitations
This API can be used only by users with Administrator access level

#### Endpoint and parameters
```
GET [endpoint]/web/accounts/
```

| Parameter | Type    | Required |
|-----------|---------|----------|
| username  | string  |    Y     |
| password  | string  |    Y     |

#### Successfull response
```
{
  "result":200,
  "content": [
    {
      "fiscalCode":"userFiscalCode",
      "firstName":"userFirstName",
      "lastName":"userLastName",
      "email":"userEmail@provider.com",
      "username":"userUsername",
      "acceptedTimestamp":"2000-01-01 00:00:01",
      "suspended":"false",
      "suspendedTimestamp":"2000-01-01 00:00:01",
      "role":"userRoleCode",
      "roleDesc":"userRoleDescription",
      "documentPhoto":"https://safestreets.altervista.org/..."
    },
    ...
  ]
}
```

## Single user data retrieval

#### Limitations
This API can be used only by users with Administrator access level

#### Endpoint and parameters
```
GET [endpoint]/web/accounts/
```

| Parameter      | Type    | Required |
|----------------|---------|----------|
| username       | string  |    Y     |
| password       | string  |    Y     |
| userFiscalCode | string  |    Y     |

#### Successfull response
```
{
  "result":200,
  "content": {
    "fiscalCode":"userFiscalCode",
    "firstName":"userFirstName",
    "lastName":"userLastName",
    "email":"userEmail@provider.com",
    "username":"userUsername",
    "suspended":"false",
    "suspendedTimestamp":"2000-01-01 00:00:01",
    "role":"userRoleCode",
    "roleDesc":"userRoleDescription",
    "accepterAdminFiscalCode":"adminFiscalCode",
    "acceptedTimestamp":"2000-01-01 00:00:01",
    "documentPhoto":"https://safestreets.altervista.org/..."
  }
}
```


## User suspension/restore

#### Limitations
This API can be used only by users with Administrator access level

#### Endpoint and parameters
```
POST [endpoint]/web/accounts/suspension/
```

| Parameter     | Type    | Required |
|---------------|---------|----------|
| username      | string  |    Y     |
| password      | string  |    Y     |
| suspendedUser | string  |    Y     |
| action        | string* |    Y     |

_suspendedUser_ parameter is the username of the user who has to be suspended or restored.
_action_ parameter must be *suspend* in case of suspention or *restore* for restoral.

#### Successfull response
```
{
  "result":200,
  "content": NULL
}
```

## User acceptance

#### Limitations
This API can be used only by users with Administrator access level

#### Endpoint and parameters
```
POST [endpoint]/web/accounts/acceptance/
```

| Parameter     | Type    | Required |
|---------------|---------|----------|
| username      | string  |    Y     |
| password      | string  |    Y     |
| acceptedUser  | string  |    Y     |

_acceptedUser_ parameter is the username of the user who has to be accepted.

#### Successfull response
```
{
  "result":200,
  "content": NULL
}
```

## User role changing

#### Limitations
This API can be used only by users with Administrator access level

#### Endpoint and parameters
```
POST [endpoint]/web/accounts/role/
```

| Parameter     | Type    | Required |
|---------------|---------|----------|
| username      | string  |    Y     |
| password      | string  |    Y     |
| roleUsername  | string  |    Y     |
| roleLevel     | integer |    Y     |

_acceptedUser_ parameter is the username of the user whose role has to be changed.
_roleLevel_ parameter is the new role level.

#### Successfull response
```
{
  "result":200,
  "content": NULL
}
```