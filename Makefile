.DEFAULT_GOAL := help

# SERVER_COMPOSE_FILE_PATH := ./docker/docker-compose.yml

server-echo:
	@echo "${SERVER_COMPOSE_FILE_PATH}"

server-init:						## Init
	@make server-init-project
	@make server-init-docker

server-init-project:				## Init Prokect
	@cp .env.example .env

server-init-testing:				# Init Testing
	@cp .env.example .env.testing

server-init-docker:				## Init Docker
	@cp ./docker/.env.example ./docker/.env

server-install:					## Install project
	@make -s server-init

server-pull:						## Pull project
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} pull

server-build:						## Build project
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} build

server-build-no-cache:				## Build no cache project
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} build --no-cache

server-up-build:					## Up and build project
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} up --build -d

server-up:							## Up project
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} up -d
	@make server-ps

server-container-up-build:				## Up project container
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} up --build -d $(container)
	@make server-ps

server-down:						## Down project
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} down --remove-orphans

server-bash:						## Project bash terminal
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli bash

server-fpm-bash:						## Project bash terminal
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-fpm bash

server-container-run-bash:						## Project bash terminal
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm $(container) bash

server-container-sh:						## Project sh terminal
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} exec $(container) sh

server-container-bash:						## Project bash terminal
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} exec $(container) bash

server-ps:							## Show project process
	printf "%s\n" "Target bar executing..."
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} ps

server-logs:							## Show project process
	printf "%s\n" "Target bar executing..."
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH}  logs $(container)

server-logs-f:							## Show project process
	printf "%s\n" "Target bar executing..."
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH}  logs -f $(container)

server-supervisor-restart:
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} restart supervisor

server-key-generate:			## Generate App encription keys
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan key:generate && ./artisan key:generate --env=testing

server-test:					## Run test
	DB_HOST=test-postgres
	DB_PORT=54322
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan test

server-migrate:				## Run migrate
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate

server-migrate-status:			## Run migrate status
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:status

server-migrate-fresh:			## Run migrate fresh
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:fresh

server-migrate-install:		## Run migrate install
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:install

server-migrate-refresh:		## Run migrate refresh
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:refresh

server-migrate-reset:
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:reset

server-migrate-rollback:		## Run migrate rollback
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:rollback

server-migrate-fresh-seed:			## Run migrate fresh and seed
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:fresh --seed

server-migrate-refresh-seed:	## Run migrate refresh & seed
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:refresh --seed

server-migrate-rollback-seed:	## Run migrate rollback & seed
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan migrate:rollback
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan db:seed

server-cc:						## Clear chash
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan optimize:clear

server-psalm:				## Run Paslm
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./vendor/bin/psalm --show-info=true --no-cache


server-pint-check:				## Run Pint Test
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./vendor/bin/pint --test

server-pint-fix:				## Run Pint Fix
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./vendor/bin/pint -v

server-composer-du-o:			## Compouser dump autolad
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli composer du -o

server-composer-install:			## Compouser install
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli composer install --ignore-platform-reqs

server-composer-require:			## Compouser require
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli composer require $(package) --ignore-platform-reqs

server-composer-require-dev:			## Compouser require dev
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli composer require --dev $(package) --ignore-platform-reqs

server-composer-remove:			## Compouser remove
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli composer remove $(package) --ignore-platform-reqs

server-composer-remove-dev:			## Compouser remove dev
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli composer remove --dev $(package) --ignore-platform-reqs

server-seed-class:						## Run Class Seeder
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan db:seed --class=$(class)

.PHONY: server-help
server-help:				## Show Project commands
	@#echo ${Cyan}"\t\t This project 'Shop Server' REST API Server!"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo ${Red}"----------------------------------------------------------------------"
