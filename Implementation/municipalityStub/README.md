# SafeStreets Municipality stub documentation

## Accidents and traffic tickets data retrieval

#### Endpoint and parameters
```
GET [municipality endpoint]/
```

| Parameter | Type    | Possible values              |
|-----------|---------|------------------------------|
| type      | string  | _accidents_/_trafficTickets_ |

#### Successfull response
*Accidents*
```
[
  {
    "plate":"AA000AA",
    "location": {
      "lat": 45.000000,
      "lon": 8.000000
    }
  },
  ...
]
```

*Traffic tickets*
```
[
  {
    "plate":"AA000AA",
    "type": 4,
    "location": {
      "lat": 45.000000,
      "lon": 8.000000
    }
  },
  ...
]
```
#### Specific error codes

| Code      | Error                              |
|-----------|------------------------------------|
| 422       | Missing parameters                 |



## Reports data sending

#### Endpoint and parameters
```
POST [municipality endpoint]/
```

| Parameter         | Type    | Required |
|-------------------|---------|----------|
| userFiscalCode    | string  |     Y    |
| plate             | char(7) |     Y    |
| violationType     | integer |     Y    |
| latitude          | float   |     Y    |
| longitude         | float   |     Y    |
| pictures          | string  |     Y    |

The _pictures_ parameter is a string representing a json array of base64-encoded `.jpg` pictures.

#### Endpoint work control
For proper function control, parameters passed to the last request to the API are written into _data.txt_ file.


#### Specific error codes

| Code      | Error                              |
|-----------|------------------------------------|
| 422       | Missing parameters                 |