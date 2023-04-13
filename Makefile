.DEFAULT_GOAL := help

# Makefile
# alias m="make"

COMPOSE_FILE_PATH := ./docker/docker-compose.yml

init:						## Init
	@make init-project
	@make init-docker

init-project:				## Init Prokect
	@cp .env.example .env

init-testing:				# Init Testing
	@cp .env.example .env.testing

init-docker:				## Init Docker
	@cp ./docker/.env.example ./docker/.env

install:					## Install project
	@make -s init

pull:						## Pull project
	@docker-compose --file $(COMPOSE_FILE_PATH) pull

build:						## Build project
	@docker-compose --file $(COMPOSE_FILE_PATH) build

build-no-cache:				## Build no cache project
	@docker-compose --file $(COMPOSE_FILE_PATH) build --no-cache

up-build:					## Up and build project
	@docker-compose --file $(COMPOSE_FILE_PATH) up --build -d

up:							## Up project
	@docker-compose --file $(COMPOSE_FILE_PATH) up -d
	@make ps

down:						## Down project
	docker-compose --file $(COMPOSE_FILE_PATH) down --remove-orphans

restart:					## Restart project
	@docker-compose --file $(COMPOSE_FILE_PATH) restart node

bash:						## Project bash terminal
	@docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli sh

ps:							## Show project process
	docker-compose --file $(COMPOSE_FILE_PATH) ps

key-generate:			## Generate App encription keys
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan key:generate && ./artisan key:generate --env=testing

test:					## Run test
	DB_HOST=test-postgres
	DB_PORT=54322
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan test

migrate:				## Run migrate
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate

migrate-status:			## Run migrate status
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:status

migrate-fresh:			## Run migrate fresh
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:fresh

migrate-install:		## Run migrate install
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:install

migrate-refresh:		## Run migrate refresh
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:refresh

migrate-reset:
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:reset

migrate-rollback:		## Run migrate rollback
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:rollback

migrate-fresh-seed:			## Run migrate fresh and seed
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:fresh --seed

migrate-refresh-seed:	## Run migrate refresh & seed
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:refresh --seed

migrate-rollback-seed:	## Run migrate rollback & seed
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan migrate:rollback
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan db:seed

cc:						## Clear chash
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan optimize:clear

psalm:				## Run Paslm
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./vendor/bin/psalm --show-info=true --no-cache


pint-check:				## Run Pint Test
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./vendor/bin/pint --test

pint-fix:				## Run Pint Fix
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./vendor/bin/pint -v

composer-du-o:			## Compouser dump autolad
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli composer du -o

composer-install:			## Compouser install
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli composer install --ignore-platform-reqs

composer-require:			## Compouser require
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli composer require $(package) --ignore-platform-reqs

composer-require-dev:			## Compouser require dev
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli composer require --dev $(package) --ignore-platform-reqs

composer-remove:			## Compouser remove
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli composer remove $(package) --ignore-platform-reqs

composer-remove-dev:			## Compouser remove dev
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli composer remove --dev $(package) --ignore-platform-reqs

seed:							## Run Seeder
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artian db:seed --class=$(class)

seed-class:						## Run Class Seeder
	docker-compose --file $(COMPOSE_FILE_PATH) run --rm php-cli ./artisan db:seed --class=$(class)

.PHONY: help
help:				## Show Project commands
	@#echo ${Cyan}"\t\t This project 'job' REST API Server!"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo ${Red}"----------------------------------------------------------------------"
