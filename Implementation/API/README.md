# SafeStreets API documentation

## Result codes

The response of every API endpoint, provided as json, has a _result_ field in its root.
The value of _result_ gives information about the status of the request and the content which can be found in the rest of the response.

| Code | Meaning                                        |
|------|------------------------------------------------|
| 200  | The request was successful                     |
| 400  | There was an error while executing the request |

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

### Code 4x

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

Error codes not included in this table are code which assume a different meaning based on the method.
Their meaning can be found in the section dedicated to the specific method.

# Accounts API methods

## Login

#### Endpoint and parameters
```
POST [endpoint]/accounts/login.php
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
    "suspended":0
  }
}
```

#### Specific error codes

| Code      | Error                               |
|-----------|-------------------------------------|
| 401       | Username/password pair is incorrect |
| 402       | User suspended                      |

# Mobile API methods

## Reports
Reports endpoint for insertion and retrieval

### Data retrieval
Response data only contains reports made by the calling user.

#### Endpoint and parameters
```
GET [endpoint]/mobile/reports/
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
      "firstName":"reporterFirstName",
      "lastName":"reporterLastName",
      "reportID":1,
      "timestamp":"2000-01-01 00:00:01",
      "address":"address",
      "licensePlate":"AA000AA",
      "violation":"violation",
      "notes":"notes"
    },
    ...
  ]
}
```

### Specific report retrieval
The response contains detailed information about the desired report. The request is succesful only if the report has been sent by the requesting user.

#### Endpoint and parameters
```
GET [endpoint]/mobile/reports/report.php
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
    "licensePlate":"AA000AA",
    "violation":"violation",
    "notes":"notes"
  }
}
```

### Insertion
Pictures will be saved in ^/reportPictures/_reportID_/_reportID_-pic-_progressive number_

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
| pictureCount      | integer |     Y    |


#### Specific error codes

| Code      | Error                              |
|-----------|------------------------------------|
| 401       | Missing parameters                 |
| 402       | Invalid parameters                 |
| 403       | Error loading pictures             |