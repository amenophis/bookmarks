COLOR_RESET   = \033[0m
COLOR_SUCCESS = \033[32m
COLOR_ERROR   = \033[31m
COLOR_COMMENT = \033[33m

define log
	echo "[$(COLOR_COMMENT)$(shell date +"%T")$(COLOR_RESET)][$(COLOR_COMMENT)$(@)$(COLOR_RESET)] $(COLOR_COMMENT)$(1)$(COLOR_RESET)"
endef

define log_success
	echo "[$(COLOR_SUCCESS)$(shell date +"%T")$(COLOR_RESET)][$(COLOR_SUCCESS)$(@)$(COLOR_RESET)] $(COLOR_SUCCESS)$(1)$(COLOR_RESET)"
endef

define log_error
	echo "[$(COLOR_ERROR)$(shell date +"%T")$(COLOR_RESET)][$(COLOR_ERROR)$(@)$(COLOR_RESET)] $(COLOR_ERROR)$(1)$(COLOR_RESET)"
endef

FIXUID := $(shell id -u)
FIXGID := $(shell id -g)

DOCKER_COMPOSE := docker-compose
PHP_RUN := $(DOCKER_COMPOSE) run --no-deps --rm php
PHP_EXEC := $(DOCKER_COMPOSE) exec -T php

.DEFAULT_GOAL := help
.PHONY: help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $$(echo '$(MAKEFILE_LIST)' | cut -d ' ' -f2) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

build: var/docker.build ## Build the docker stack
var/docker.build: docker/Dockerfile
	@$(call log,Building docker images ...)
	@$(DOCKER_COMPOSE) build
	touch var/docker.build
	@$(call log_success,Done)

.PHONY: pull
pull: ## Pulling docker images
	@$(call log,Pulling docker images ...)
	@$(DOCKER_COMPOSE) pull
	@$(call log_success,Done)

.PHONY: shell
shell: start ## Enter in the PHP container
	@$(call log,Entering inside php container ...)
	@$(DOCKER_COMPOSE) exec php ash

start: var/docker.up ## Start the docker stack
var/docker.up: var/docker.build vendor
	@$(call log,Starting the docker stack ...)
	@$(DOCKER_COMPOSE) up -d
	touch var/docker.up
	@$(call log_success,Done)

.PHONY: stop
stop: ## Stop the docker stack
	@$(call log,Stopping the docker stack ...)
	@$(DOCKER_COMPOSE) stop
	rm -rf var/docker.up
	@$(call log_success,Done)

.PHONY: clean
clean: stop ## Clean the docker stack
	@$(call log,Cleaning the docker stack ...)
	@$(DOCKER_COMPOSE) down
	rm -rf var/* vendor/*
	@$(call log_success,Done)

vendor: var/docker.build composer.json composer.lock ## Install composer dependencies
	@$(call log,Installing vendor ...)
	@$(PHP_RUN) composer install
	@$(call log_success,Done)

.PHONY: db
db: var/docker.up
	@$(call log,Preparing db ...)
	@$(PHP_RUN) waitforit -host=mysql -port=3306
	@$(PHP_RUN) bin/console -v -n doctrine:database:drop --if-exists --force
	@$(PHP_RUN) bin/console -v -n doctrine:database:create
	@$(PHP_RUN) bin/console -v -n doctrine:migration:migrate
	@$(call log_success,Done)

.PHONY: db-test
db-test: var/docker.up
	@$(call log,Preparing test db ...)
	@$(PHP_RUN) waitforit -host=mysql -port=3306
	@$(PHP_RUN) bin/console --env=test -v -n doctrine:database:drop --if-exists --force
	@$(PHP_RUN) bin/console --env=test -v -n doctrine:database:create
	@$(PHP_RUN) bin/console --env=test -v -n doctrine:migration:migrate
	@$(call log_success,Done)

.PHONY: qa
qa: php-cs-fixer-check phpstan unit-test func-test ## Run QA targets

.PHONY: php-cs-fixer-check
php-cs-fixer-check: vendor ## Check code style
	@$(call log,Running ...)
	@$(PHP_RUN) vendor/bin/php-cs-fixer fix --config=.php_cs.dist -v --dry-run --stop-on-violation
	@$(call log_success,Done)

.PHONY: php-cs-fixer-fix
php-cs-fixer-fix: vendor ## Auto fix code style
	@$(call log,Running ...)
	@$(PHP_RUN) vendor/bin/php-cs-fixer fix
	@$(call log_success,Done)

.PHONY: phpstan
phpstan: vendor ## Analyze code with phpstan
	@$(call log,Running ...)
	@$(PHP_RUN) vendor/bin/phpstan analyze
	@$(call log_success,Done)

.PHONY: unit-test
unit-test: vendor ## Run PhpUnit unit testsuite
	@$(call log,Running ...)
	@$(PHP_RUN) vendor/bin/phpunit -v --testsuite unit --testdox
	@$(call log_success,Done)

.PHONY: func-test
func-test: db-test ## Run PhpUnit func testsuite
	@$(call log,Running ...)
	$(PHP_EXEC) vendor/bin/phpunit -v --testsuite func --testdox
	@$(call log_success,Done)
