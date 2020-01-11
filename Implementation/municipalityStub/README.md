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

### Reports ticket generation
Reports acquired from SafeStreets can concur in ticket generation.
At every data request, past received reports are elaborated and included in the tickets list with a probability of 70%.

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
For proper function control, data about the report are saved into _data.txt_ file (except for the encoded pictures).
Every time data are acquired from SafeStreets for Street Safety computation, data about past reports are inserted in the traffic ticket part (with a probability of 70% to be included in the tickests list) and the file is cleaned.


#### Specific error codes

| Code      | Error                              |
|-----------|------------------------------------|
| 422       | Missing parameters                 |