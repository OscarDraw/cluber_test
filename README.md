
## API Reference

#### Get all movies

```http
  GET /api/
``` 
#### Get movies filtered by type

```http
  GET /api/type/${type}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `type`      | `int` | **Required**. Id of type to filter |

##### Types

    0. New movies
    1. Normal movies
    2. Old movies 


#### create new invoice

```http
  POST /api/invoice/
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `body`      | `json` | **Required**. data to create the invoice |

##### Body structure:

```json
{
    "costumer_id" : 2,
    "date" : "2021-12-14 08:59:00",
    "movies" : [
        {
            "movie_id" : 3,
            "return_date" : "2021-12-23 08:59:00"
        },
        {
            "movie_id" : 6,
            "return_date" : "2021-12-18 08:59:00"
        }
    ]
}
```
#### get a customer's loyalty points

```http
  GET /api/loyalty/${customer_id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `customer_id`      | `int` | **Required**. customer id to show loyalty points |
