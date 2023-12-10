#!/bin/bash

SERVER_COMPOSE_FILE=./docker/docker-compose.yml

function env() {
    if [ ! -f .env ]; then
        cp .env.example .env
    fi
}

function status()
{
    docker-compose --file $SERVER_COMPOSE_FILE ps;
}

function start()
{
    docker-compose --file $SERVER_COMPOSE_FILE up --build -d --force-recreate --remove-orphans
    status
    # sleep 10
    # message-broker init
}

function stop()
{
    docker-compose --file $SERVER_COMPOSE_FILE down --remove-orphans
}

function restart()
{
    if [[ ! -z "$1" ]]; then
        docker-compose --file $SERVER_COMPOSE_FILE down ${@:1}
        docker-compose --file $SERVER_COMPOSE_FILE up --build -d ${@:1}
    else
        stop
        start
    fi
}

function pull()
{
    docker-compose --file ${SERVER_COMPOSE_FILE} pull --no-parallel
}

function build() {
	docker-compose --file ${SERVER_COMPOSE_FILE} build ${@:1}
}

function message-broker()
{
    function create-exchange()
    {
        case "$1" in
            'command-handler')
                docker-compose --file ${SERVER_COMPOSE_FILE} run --rm php-cli php artisan create-rabbitmq:command-handler-exchanges
            ;;
            'domain-event-handler')
                docker-compose --file ${SERVER_COMPOSE_FILE} run --rm php-cli php artisan create-rabbitmq:domain-event-handler-exchanges
            ;;
            *)
                echo -e "
${CYAN}Create RrabbitMQ Exchanges

${YELLOW} Usage:${ENDCOLOR}
    create-exchange <command>

${YELLOW} Available commands: ${ENDCOLOR}${GREEN}
    command-handler ${BLUE}.................................................................${GREEN} Command handler
    domain-event-handler ${BLUE}............................................................${GREEN} Domain Event handler
"
                exit 1
            ;;
        esac
    }

    case "$1" in
        'init')
            supervisor stop

            # Create RrabbitMQ Exchanges
            message-broker create-exchange command-handler
            message-broker create-exchange domain-event-handler

            ## Generate Supervisor RabbitMQ
            supervisor generate-rabbitmq-commands-consumer
            supervisor generate-rabbitmq-domain-events-consumer

            supervisor start
        ;;
        'restart')
            make server-restart-message-broker
        ;;
        'create-exchange')
            create-exchange ${@:2}
        ;;
        *)
            echo -e "
${CYAN}Server command line interface for the Docker-based web development environment demo.

${YELLOW} Usage:${ENDCOLOR}
    message-broker <command>

${YELLOW} Available commands: ${ENDCOLOR}${GREEN}
    init ${BLUE}..........................................................................${GREEN} Init
    restart ${BLUE}.......................................................................${GREEN} Restart
    create-exchange [options] ${BLUE}.....................................................${GREEN} Create RrabbitMQ Exchanges
                                                                                    Options:
                                                                                        command-handler ${BLUE}.......................................${GREEN} Command handler
                                                                                        domain-event-handler ${BLUE}..................................${GREEN} Domain Event handler
"
            exit 1
        ;;
    esac
}

function bash()
{
    docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli bash
}

function fpm-bash()
{
    docker-compose --file $SERVER_COMPOSE_FILE run --rm php-fpm bash
}

function artisan()
{
    docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli ./artisan ${@:1}
}

function cc()
{
    docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli ./artisan optimize:clear
    docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli rm ./storage/logs/laravel/*.log
}

function composer()
{
    docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli composer ${@:1}
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

    echo "server${ENTITY}-database${COMMAND}"

    docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli make "server${ENTITY}-database${COMMAND}"
}

function logs()
{
    docker-compose --file $SERVER_COMPOSE_FILE logs ${@:1}
}

function psalm()
{
    case "$1" in
        'run')
            docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli ./vendor/bin/psalter --issues=all
        ;;
        *)
            echo -e "
${CYAN}Server command line interface for the Docker-based web development environment demo.

${YELLOW} Usage:${ENDCOLOR}
    paslm <command>

${YELLOW} Available commands: ${ENDCOLOR}${GREEN}
    run ${BLUE}............................................................................${GREEN} Paslm run
"
            exit 1
        ;;
    esac
}

# https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/config.rst
function php-cs-fixer()
{
    case "$1" in
        'check')
            ./vendor/bin/php-cs-fixer check --config=.php-cs-fixer.php --verbose -vvv --diff --allow-risky=yes --using-cache=no app
            ./vendor/bin/php-cs-fixer check --config=.php-cs-fixer.php --verbose -vvv --diff --allow-risky=yes --using-cache=no src
        ;;
        'fix')
            ./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --verbose -vvv --diff --allow-risky=yes --using-cache=no app
            ./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --verbose -vvv --diff --allow-risky=yes --using-cache=no src
        ;;
        *)
            echo -e "
${CYAN}Server command line interface for the Docker-based web development environment demo.

${YELLOW} Usage:${ENDCOLOR}
    php-cs-fixer <command>

${YELLOW} Available commands: ${ENDCOLOR}${GREEN}
    check ${BLUE}............................................................................${GREEN} Print status of containers
    fix ${BLUE}..............................................................................${GREEN} Start the containers
"

            exit 1
        ;;
    esac
}

function test()
{
    if [[ "$1" != '-h' ]]; then
        docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli ./artisan test ${@:1}
    # else if [[ "$1" == 'phpunit' ]]; then
    #   docker-compose --file $SERVER_COMPOSE_FILE run --rm php-cli ./vendor/bin/phpunit --colors=always ${@:1}
    else
        echo -e "
${CYAN}Server command line interface for the Docker-based web development environment demo.

${YELLOW} Usage:${ENDCOLOR}
    test <command>

${YELLOW} Available commands: ${ENDCOLOR}${GREEN}
    -h ${BLUE}.............................................................................${GREEN} Help
    -g, --group ${BLUE}....................................................................${GREEN} Filter by Group [--group=manager]
"
        exit 1
    fi
}

function supervisor()
{
    case "$1" in
        'start')
            docker-compose --file $SERVER_COMPOSE_FILE up --build -d supervisor
        ;;
        'stop')
            docker-compose --file $SERVER_COMPOSE_FILE rm -s -f -v supervisor
        ;;
        'restart')
            docker-compose --file $SERVER_COMPOSE_FILE rm -s -f -v supervisor
            docker-compose --file $SERVER_COMPOSE_FILE up --build -d supervisor
        ;;
        'generate-rabbitmq-commands-consumer')
            docker-compose --file ${SERVER_COMPOSE_FILE} run --rm php-cli php artisan generate-supervisor-rabbitmq:commands-consumer
        ;;
        'generate-rabbitmq-domain-events-consumer')
            docker-compose --file ${SERVER_COMPOSE_FILE} run --rm php-cli php artisan generate-supervisor-rabbitmq:domain-events-consumer
        ;;
        'cc')
            docker-compose --file $SERVER_COMPOSE_FILE run --rm supervisor rm ./storage/logs/supervisor/*.log
        ;;
        *)
            echo -e "
${CYAN}Server command line interface for the Docker-based web development environment demo.

${YELLOW} Usage:${ENDCOLOR}
    paslm <command>

${YELLOW} Available commands: ${ENDCOLOR}${GREEN}
    start ${BLUE}.........................................................................${GREEN} Start
    stop ${BLUE}..........................................................................${GREEN} Stop
    restart ${BLUE}.......................................................................${GREEN} Restart
    generate-rabbitmq-commands-consumer ${BLUE}...........................................${GREEN} Generate RabbitMQ Commands consumer
    generate-rabbitmq-domain-events-consumer ${BLUE}......................................${GREEN} Generate RabbitMQ Domain Events consumer
    cc ${BLUE}............................................................................${GREEN} Celar cahe
"
            exit 1
        ;;
    esac
}
