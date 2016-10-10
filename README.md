# laravel-api-skeleton
This is package provide laravel skeleton api, includes BaseController, Request and json format response

# Installation

### Composer require

```
savich/laravel-api-skeleton
```

### Register Service Provider

```
'providers' => [
...
Savich\ApiSkeleton\Providers\ApiServiceProvider::class,
```

### Register Middleware

```
protected $routeMiddleware = [
...
'api.auth' => \Savich\ApiSkeleton\Middleware\Auth::class,
```

# Usage

### Controller

```
use Savich\ApiSkeleton\Controllers\ApiController;

class YourController extends ApiController
```

### Routes

On your routes file specify middleware for route group that provide checking if user is authenticated via api

```
// on routes file

Route::group(['middleware' => 'api.auth'], function () {
    // your routes ...
});
```

### Request

All api requests should inherit ApiRequest for making one errors format

```
use Savich\ApiSkeleton\Requests\ApiRequest;

class YourRequest extends ApiRequest
```

# Features

### Response

To making response of the api just call in your controller method `send()` of ApiController that provide convenient way of response representation

```
use Savich\ApiSkeleton\Controllers\ApiController;
use Savich\ApiSkeleton\Response\ResponseInterface;

class YourController extends ApiController
{
    public function index()
        {
            return $this->send(/* params */); 
        }
```

The response looks like:

```
{
  "status": 1,
  "message": null,
  "token": null,
  "result": null // here will be your `params`
}
```

### Auth

The package provide simple work with auth via api.
You just need to use TokenTrait that makes login easy and nice.

Example.

```
use Savich\ApiSkeleton\Controllers\ApiController;
use Savich\ApiSkeleton\Controllers\Mixins\TokenTrait;
use Savich\ApiSkeleton\Response\ResponseInterface;

class AuthController extends ApiController
{
    use TokenTrait;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * API Login, on success return JWT Auth token
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request) // you can make your own request
    {
        $user = $this->getUser($request->only('email', 'password'));

        if (!$user) {
            $this->addError('Invalid credentials');

            return $this->send();
        }

        return $this->attemptToken($user);
    }
}

```
