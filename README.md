# Bookmarks API

You only need `make`, `docker` and `docker-compose` installed to start the API development environment.

## Start the API

The following command will start the API.
You can browse the OpenAPI documentation at http://127.0.0.1:8000/ :

```bash
make start
```

## QA tools

Several Quality tools are configured in the project (PHP CS Fixer, PHPStan, PHPUnit).
You can execute them running this command: 
```bash
make qa
```

## Stop the API

You can stop the API running this command:
```bash
make stop
```

## Clean the development environment

You can clean the development environment (docker images, vendor, ...) running this command:
```bash
make clean
```

## Makefile targets

You can get available targets by running:
```bash
make
```

```bash
build                          Build the docker stack
pull                           Pulling docker images
shell                          Enter in the PHP container
start                          Start the docker stack
stop                           Stop the docker stack
clean                          Clean the docker stack
vendor                         Install composer dependencies
qa                             Run QA targets
php-cs-fixer-check             Check code style
php-cs-fixer-fix               Auto fix code style
phpstan                        Analyze code with phpstan
unit-test                      Run PhpUnit unit testsuite
func-test                      Run PhpUnit func testsuite
```

## Postman Collection

You can import the postman collection (`./postman_collection.json`) to play with the API locally in the file.
