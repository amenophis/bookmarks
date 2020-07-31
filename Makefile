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

ifeq ($(IS_DOCKER),true)
	PHP_RUN := php
	PHP_EXEC := php
else
	PHP_RUN := ./dc run --no-deps php
	PHP_EXEC := ./dc exec php
endif

.DEFAULT_GOAL := help
.PHONY: help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $$(echo '$(MAKEFILE_LIST)' | cut -d ' ' -f2) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

.PHONY: build
build: ## Build the docker stack
ifeq ($(IS_DOCKER),true)
	@$(call log_error,Target must be run outside docker)
	exit 1;
endif
	@$(call log_success,Building the docker stack ...)
	@./dc build
	@$(call log_success,Done)

.PHONY: shell
shell: ## Enter in the PHP container
ifeq ($(IS_DOCKER),true)
	@$(call log_error,Target must be run outside docker)
	exit 1;
endif
	@$(call log_success,Entering inside php container ...)
	@./dc exec php ash

.PHONY: start
start: build ## Start the docker stack
ifeq ($(IS_DOCKER),true)
	@$(call log_error,Target must be run outside docker)
	exit 1;
endif
	@$(call log_success,Starting the docker stack ...)
	@./dc up -d
	@$(call log_success,Done)

.PHONY: stop
stop: ## Stop the docker stack
ifeq ($(IS_DOCKER),true)
	@$(call log_error,Target must be run outside docker)
	exit 1;
endif
	@$(call log_success,Stopping the docker stack ...)
	@./dc stop
	@$(call log_success,Done)

.PHONY: clean
clean: stop ## Clean the docker stack
ifeq ($(IS_DOCKER),true)
	@$(call log_error,Target must be run outside docker)
	exit 1;
endif
	@$(call log_success,Cleaning the docker stack ...)
	@./dc down
	@$(call log_success,Done)

.PHONY: qa
qa: php-cs-fixer-check phpstan unit-test func-test ## Run QA targets

.PHONY: php-cs-fixer-check
php-cs-fixer-check: ## Check code style
	@$(PHP_RUN) vendor/bin/php-cs-fixer fix --config=.php_cs.dist -v --dry-run --stop-on-violation

.PHONY: php-cs-fixer-fix
php-cs-fixer-fix: ## Auto fix code style
	@$(PHP_RUN) vendor/bin/php-cs-fixer fix

.PHONY: phpstan
phpstan: ## Analyze code with phpstan
	@$(PHP_RUN) vendor/bin/phpstan analyze

.PHONY: unit-test
unit-test: ## Run PhpUnit unit tests
	@$(PHP_RUN) vendor/bin/phpunit -v --testsuite unit --testdox

.PHONY: func-test
func-test: start ## Run PhpUnit func tests
	@$(PHP_EXEC) vendor/bin/phpunit -v --testsuite func --testdox


