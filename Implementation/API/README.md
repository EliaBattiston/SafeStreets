# SafeStreets API documentation

## Result codes

The response of every API endpoint, provided as json, has a _result_ field in its root.
The value of _result_ gives information about the status of the request and the content which can be found in the rest of the response.

| Code | Meaning                                        |
|------|------------------------------------------------|
| 200  | The request was successful                     |
| 400  | There was an error while executing the request |

### Code 200

If _result_ has a value of 200, the request has been elaborated.
The _content_ field will contain the results of the request.

#### Example
```
{
  "result": 200,
  "content": ...
}
```

### Code 400

If _result_ has a value of 400, a _message_ field can be found in the root of the request.
The _message_ field will contain a description of the occurred error.

#### Example
```
{
  "result": 400,
  "message": "The username/password pair does not exist"
  ...
}
```

### Code 4xx

4xx messages signals more detailed errors, as specified in the related messages.
Specifications about errors will be highlighted in the related APIs.

### Code 503

503 error message notifies invalid username/password or the missing of one or both parameters.

---

## Login

#### Endpoint and parameters
```
POST [endpoint]/accounts/login.php
```

| Parameter | Required |
|-----------|----------|
| username  |     Y    |
| password  |     Y    |

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

| Code      | Error                              |
|-----------|------------------------------------|
| 401       | Username and/or password not found |
| 402       | User suspended                     |

---

## Reports
Reports endpoint for user insertion and retrieval

### Data retrieval
Response data are related to reports made by the caller user.

#### Endpoint and parameters
```
GET [endpoint]/mobile/reports/
```

| Parameter | Required |
|-----------|----------|
| username  |     Y    |
| password  |     Y    |

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
It is possible to retrieve only reports made by the caller user.

#### Endpoint and parameters
```
GET [endpoint]/mobile/reports/report.php
```

| Parameter | Required |
|-----------|----------|
| username  |     Y    |
| password  |     Y    |
| reportID  |     Y    |

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