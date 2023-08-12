## Bon Appetit

It's a simple app to create boxes of recipes.

## Requirements

- PHP 8.2 on your local machine
- Composer package manager
- Docker

## Getting Started

Please run the following command to initialise the app from the home directory. Please make sure that the docker is up and running on your system.

```
sh start.sh
```

Once you see the following, that means that we are good to go.

```
Pizza is ready! Bon appetit 🍕🎉
```

## Insights

Note, that we are using Laravel Sail behind the scenes which is a wrapper around Docket. We run the app in the detach mode here.

If you wish to terminate all the processes, please run the following command

```
sail down
```

## How to use

You may go to the browser and log on the following link:

http://localhost/

You should be able to see homepage with "Bon Appetit".

### Endpoints

All the endpoints are mentioned below.

1. Create an Ingredient

```
Type: POST
Endpoint: /api/ingredients
```

**Payload**

| Key      | Description                  |
|----------|------------------------------|
| name     | Name of the item             |
| measure  | Measurement unit of the item |
| supplier | Name of the Supplier         |

**Example**
```
{
    "name": "Bread",
    "measure": "pieces",
    "supplier": "lulu"
}
```

2. List the Ingredients

```
Type: GET
Endpoint: /api/ingredients
```

**Filters**

| Key      | Description          |
|----------|----------------------|
| supplier | Name of the supplier |

**Example**
```
http://localhost/api/ingredients?filters[supplier]=lulu
```

3. Create a Recipe
```
Type: POST
Endpoint: /api/recipes
```

**Payload**

| Key         | Description                                        |
|-------------|----------------------------------------------------|
| name        | Name of the Recipe                                 |
| description | Details about the Recipe                           |
| ingredients | Array of ingredients with their `id` and `amount`  |

**Example**
```
{
    "name": "Toast",
    "description": "This is a toast",
    "ingredients": [
        {
            "id": 1,
            "amount": 10.00
        }
    ]
}
```

4. List the Recipes

```
Type: GET
Endpoint: /api/recipes
```

5. Create a Box
```
Type: POST
Endpoint: /api/box
```

**Payload**

| Key           | Description                      |
|---------------|----------------------------------|
| delivery_date | Date of the delivery             |
| recipes       | Array of recipes with their `id` |

**Example**
```
{
    "delivery_date": "2023-10-01",
    "recipes": [
        {
            "id": 1
        }
    ]
}
```

6. List all Boxes
```
Type: GET
Endpoint: /api/box
```

**Filters**

| Key           | Description                                 |
|---------------|---------------------------------------------|
| delivery_date | Filters boxes based on the `delivery_date`  |

7. Ingredients required based on orders placed
```
Type: GET
Endpoint: /api/ingredients-required
```
**Filters**

| Key           | Description                                                       |
|---------------|-------------------------------------------------------------------|
| delivery_date | Filters ingredients based on the date when the orders were placed |


## Testing

```
sail artisan test
```
