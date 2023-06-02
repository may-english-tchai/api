DOCKER=docker compose
COMPOSER=symfony composer
CONSOLE=symfony console

.DEFAULT_GOAL := docker-sh

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?## .*$$)|(^## )' Makefile | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

sf-cc:
	chmod -R 777 ./
	$(CONSOLE) c:c

composer-install:
	$(COMPOSER) install

composer-update:
	$(COMPOSER) update --with-all-dependencies

doctrine-migration:
	$(CONSOLE) make:migration

doctrine-migrate:
	$(CONSOLE) doctrine:migrations:migrate -n

fixtures-load:
	$(CONSOLE) hautelook:fixtures:load -n

jwt-generate:
	$(CONSOLE) lexik:jwt:generate-keypair --skip-if-exists

stan:
	./vendor/bin/phpstan analyse

cs-fix:
	./vendor/bin/php-cs-fixer fix

rector:
	./vendor/bin/rector

analyze: stan cs-fix rector

test:
	$(CONSOLE) doctrine:schema:drop --force --env=test
	$(CONSOLE) doctrine:schema:create --env=test
	APP_ENV=test $(CONSOLE) hautelook:fixtures:load -n
	APP_ENV=test ./vendor/bin/phpunit

## —— Git ————————————————————————————————————————————————————————————————

type ?= feat
commit: analyze ## Auto commit with branch name
	git add .
	@git commit -am "${type}: #$(shell git branch --show-current | sed 's/-/ /g')"

## —— Git ————————————————————————————————————————————————————————————————
docker-install: Dockerfile docker-compose.yaml clean docker-down docker-build docker-up docker-ps docker-logs ## Reset and install your environment

docker-up: docker-down ## Start the docker container
	$(DOCKER) up -d

docker-logs: ## List the docker containers
	$(DOCKER) logs -f

docker-ps: ## List the docker containers
	$(DOCKER) ps -a

docker-build: ## Build the docker container
	$(DOCKER) build

docker-down: ## down the stack
	$(DOCKER) down --remove-orphans

docker-sh: ## Connect to the docker container
	$(DOCKER) exec -it api zsh
