# Kinnovis REST API

This is a Kinnovis REST API as a part of a coding assessment challenge.

## Demo endpoint

Demo API can be found here: [https://kinnovis.aspiria.si](https://kinnovis.aspiria.si)

For demo purposes you can send a POST request to endpoint `/api/v1/login` and pass along the following data:

```
{
	"email": "text@example.com",
	"password": "password123",
	"device_name": "Test device"
}
```

This will return a plain text api token which you can use for subsequent requests where you should pass it in the `Authorization` header as a `Bearer` token.

Also note that you should pass the `Accept: application/json` header to let Laravel know you need JSON responses.

## Authentication

As I am not sure in which situation the REST API will be used, I decided to go here with Laravel Sanctum as it offers authentication for SPAs, API token authentication and mobile app authentication out of the box. It is a secure and tested solution.

## API endpoints, versioning and caching

This REST API is versioned with v1, v2 etc. So all current api endpointes are prefixed with `/api/v1`.

The following endpoint is currently available:

- `/api/v1/login` <- Demo login for testing purposes
- `/api/v1/items/filters` <- Returns a JSON representation of available filters

Endpoint for item filters is cached to enable faster responses and also throttled by the default Laravel middleware to 60 requests per minute.


## Static analysis and code style

Larastan - wrapper around PHPStan - is used for static analysis and Laravel Pint is used for code style fixes.


## Localization

Localization is done using the `Accept-Language` header and using the default Laravel localization strategies. 

We make sure that only `en` and `de` are supported and fall back to `en`. 
