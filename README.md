```shell
composer require istok/router
```

# Basic router

- matching given `Request` (essentially `array<string,string>`) to `mixed $handler`
- comes with implementation suitable for http request
- Support variables, like `/post/{id}/`
- build to play with `istok/container`
- (I hope) it can be easily extended to route something else than `http` (console, queue)

## Usage (currently no sugar provided)

Working example in `example.com`, don't forget to install dependencies first.

```php
use Istok\Router\Router;
use Istok\Router\Route;
use Istok\Router\Http\HttpTemplate;
use Istok\Router\Http\HttpRequest;

// define single router entry
$route = new Route(
    // provide template interface
    new HttpTemplate('/post/{id}', 'GET', '{user}.example.com'),
    // provide handler
    fn($id, $user) => print "User: $user, id: $id"
);

// setup router, add our single route
$router = new Router();
$router->add($route);

// special http-oriented implementation of Request interface
$request = new HttpRequest('/post/abc', 'GET', 'user1.example.com');

// match route to request
$result = $router->find($request);

// execute result,
// $result->arguments contains ['user' => 'user1', 'id' => 'abc']  
($result->route->handler)(...$result->arguments); // User: user1, id: abc 

```
