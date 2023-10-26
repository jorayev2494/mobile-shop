.DEFAULT_GOAL := help

SERVER_COMPOSE_FILE_PATH := ./docker/docker-compose.yml

server-init:										## Init
	@make server-init-project
	@make server-init-docker

server-init-project:								## Init Prokect
	@cp .env.example .env

server-init-testing:								## Init Testing
	@cp .env.example .env.testing

server-init-docker:									## Init Docker
	@cp ./docker/.env.example ./docker/.env

server-install:										## Install project
	@make -s server-init

test:												## Run test
	# DB_HOST=test-postgres
	# DB_PORT=54322
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan test

server-admin-database-diff:							## Run Admin database diff
	ENTITY=admin php ./vendor/bin/doctrine-migrations diff

server-admin-database-fresh:						## Run Admin database fresh
	./artisan db:wipe --database=admin_pgsql --drop-views --drop-types

server-admin-database-migrate:						## Run Admin database
	ENTITY=admin php ./vendor/bin/doctrine-migrations migrate

server-client-database-diff:						## Run Client database diff
	ENTITY=client php ./vendor/bin/doctrine-migrations diff

server-client-database-fresh:						## Run Client database fresh
	./artisan db:wipe --database=client_pgsql --drop-views --drop-types

server-client-database-migrate:						## Run Client migrations
	ENTITY=client php ./vendor/bin/doctrine-migrations migrate

server-database-seed:								## Run migrate fresh and seed
	./artisan db:seed

server-psalm:										## Run Paslm
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./vendor/bin/psalm --show-info=true --no-cache

server-pint-check:									## Run Pint Test
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./vendor/bin/pint --test

server-pint-fix:									## Run Pint Fix
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./vendor/bin/pint -v

server-create-rabbitmq-exchanges:					## Create RrabbitMQ Exchanges
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli php artisan create-rabbitmq:command-handler-exchanges
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli php artisan create-rabbitmq:domain-event-handler-exchanges

server-generate-supervisor-rabbitmq:				## Generate Supervisor RabbitMQ
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli php artisan generate-supervisor-rabbitmq:commands-consumer
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli php artisan generate-supervisor-rabbitmq:domain-events-consumer

server-supervisor-restart:
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} up --build -d supervisor

server-refresh-rabbitmq-and-restart-supervisor:
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} rm -s -f -v supervisor
	@make server-create-rabbitmq-exchanges
	@make server-generate-supervisor-rabbitmq
	@make server-supervisor-restart

server-restart-message-broker:
	@make server-refresh-rabbitmq-and-restart-supervisor

server-seed-class:									## Run Class Seeder
	@docker-compose --file ${SERVER_COMPOSE_FILE_PATH} run --rm php-cli ./artisan db:seed --class=$(class)

# .PHONY: server-help
server-help:										## Show Project commands
	@#echo ${Cyan}"\t\t This project 'Shop Server' REST API Server!"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo ${Red}"----------------------------------------------------------------------"
