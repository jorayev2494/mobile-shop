<?php

declare(strict_types=1);

namespace App\Services\Api;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\DomainEvent;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\QueueName;

class GenerateSupervisorRabbitMQConsumerService
{
    use QueueName;

    private const EVENTS_TO_PROCESS_AT_TIME             = 200;
    private const NUMBERS_OF_PROCESSES_PER_SUBSCRIBER   = 1;
    private const PATH                                  = __DIR__ . '/';
    protected static $defaultName = 'codelytv:domain-events:rabbitmq:generate-supervisor-files';

    public function configCreator(object $handler, bool $append = false): void
    {
        $name = RabbitMqQueueNameFormatter::format($handler);
        $queueName = $this->makeQueueName($name, $handler);

        $consumeCommandPrefix = match (true) {
            $handler instanceof CommandHandlerInterface => 'command',
            $handler instanceof DomainEvent => 'event',
        };

        $fileContent = str_replace(
            [
                '{queue_name}',
                // '{path}',
                '{processes}',
                '{consume_command_prefix}',
                '{events_to_process}',
            ],
            [
                $queueName,
                // self::PATH,
                self::NUMBERS_OF_PROCESSES_PER_SUBSCRIBER,
                $consumeCommandPrefix,
                self::EVENTS_TO_PROCESS_AT_TIME,
            ],
            $this->template()
        );

        file_put_contents($this->fileName($queueName), $fileContent, $append ? FILE_APPEND : 0);
    }

    private function template(): string
    {
        // return <<<EOF
        //     [program:codelytv_{queue_name}]
        //     command      = {path}/apps/mooc/backend/bin/console codelytv:domain-events:rabbitmq:consume --env=prod {queue_name} {events_to_process}
        //     process_name = %(program_name)s_%(process_num)02d
        //     numprocs     = {processes}
        //     startsecs    = 1
        //     startretries = 10
        //     exitcodes    = 2
        //     stopwaitsecs = 300
        //     autostart    = true
        //     EOF;

        return <<<EOF

        [program:Shop.{queue_name}]
        process_name    = %(process_num)02d
        command         = php /var/project/artisan rabbitmq:{consume_command_prefix}-consume --queue {queue_name}
        autostart       = true
        autorestart     = true
        user            = root
        numprocs        = {processes}
        redirect_stderr = true
        stdout_logfile  = /var/project/storage/logs/{queue_name}.log

        EOF;
    }

    private function fileName(string $fileName = 'supervisord'): string
    {
        // return sprintf('%s/%s.ini', base_path(env('SUPERVISOR_PATH')), $queue);
        return sprintf('%s/%s.ini', base_path(env('SUPERVISOR_PATH')), $fileName);
    }
}
