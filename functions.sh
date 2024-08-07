#!/bin/bash

SERVER_COMPOSE_FILE_PATH=./docker/docker-compose.yml

# Create .env from .env.example
function env() {
    if [ ! -f .env ]; then
        cp .env.example .env
    fi
}

function status()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH ps;
}

# Start the containers
function start()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH up -d --force-recreate --remove-orphans
    status
    sleep 10
    restart-message-broker
}

# Stop the containers
function stop()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH down --remove-orphans
}

function restart()
{
    stop
    start
}

function pull()
{
    docker-compose --file ${SERVER_COMPOSE_FILE_PATH} pull --no-parallel
}

function build() {
	docker-compose --file ${SERVER_COMPOSE_FILE_PATH} build ${@:1}
}

function restart-message-broker()
{
    make server-restart-message-broker
}

function bash()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli bash
}

function fpm-bash()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-fpm bash
}

function artisan()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli ./artisan ${@:1}
}

function cc()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli ./artisan optimize:clear
}

function composer()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli composer ${@:1}
}

function database()
{
    # echo "Using \$@: $@"
    # echo "Using \$*: $*"

    ENTITY=$1
    COMMAND=$2

    echo '';

    #region First argument
    if [[ -z "$ENTITY" ]]; then
        read -p 'Pls type entity (admin, client): ' ENTITY;

        echo '';
    fi

    if [[ ! -z "$ENTITY" ]]; then
        ENTITY="-${ENTITY}";
    fi
    #endregion End First argument

    #region Second argument
    if [[ -z "$COMMAND" ]]; then
        read -p 'Pls type ([seed], fresh, diff, migrate): ' COMMAND;

        ${COMMAND:='seed'}
        echo '';
    fi

    if [[ ! -z "$COMMAND" ]]; then
        COMMAND="-${COMMAND}";
    fi
    #endregion End Second argument

    docker-compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli make "server${ENTITY}-database${COMMAND}"
}

function logs()
{
    docker-compose --file $SERVER_COMPOSE_FILE_PATH logs ${@:1}
}
