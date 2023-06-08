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

database-drop:
	$(CONSOLE) doctrine:schema:drop --force --full-database

doctrine-migration:
	$(CONSOLE) make:migration

doctrine-migrate: ## Apply doctrine migrate
	$(CONSOLE) doctrine:migrations:up-to-date || $(CONSOLE) doctrine:migrations:migrate -n

doctrine-reset: database-drop doctrine-migrate

fixtures-load: doctrine-reset ## Load fixtures
	$(CONSOLE) hautelook:fixtures:load -n

jwt-generate:
	$(CONSOLE) lexik:jwt:generate-keypair --skip-if-exists

lint:
	$(CONSOLE) lint:container
	$(CONSOLE) lint:yaml --parse-tags config/
	$(CONSOLE) lint:twig templates/
	$(CONSOLE) doctrine:schema:validate

stan:
	./vendor/bin/phpstan analyse

cs-fix:
	./vendor/bin/php-cs-fixer fix

rector:
	./vendor/bin/rector

analyze: lint stan cs-fix rector

test:
	$(CONSOLE) doctrine:schema:drop --force --env=test
	$(CONSOLE) doctrine:schema:create --env=test
	APP_ENV=test $(CONSOLE) hautelook:fixtures:load -n
	APP_ENV=test ./vendor/bin/phpunit

## —— Git ————————————————————————————————————————————————————————————————
git-rebase:
	git pull --rebase origin main

type ?= feat
message ?= \#$(shell git branch --show-current | sed "s/-/ /g")
git-auto-commit:
	git add .
	@git commit -m "${type}: ${message}" || true

GIT_CURRENT_BRANCH=$(shell git rev-parse --abbrev-ref HEAD)
git-push:
	git push origin "$(GIT_CURRENT_BRANCH)"

commit: analyze git-auto-commit git-rebase git-push

## —— Docker ————————————————————————————————————————————————————————————————
docker-install: Dockerfile docker-compose.yaml docker-down docker-build docker-up docker-ps docker-logs ## Reset and install your environment

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

docker-restart: docker-down docker-up docker-ps ## Reset the docker container

deploy: git-rebase docker-down docker-build docker-up docker-ps docker-logs ## Deploy the application

