<?php

declare(strict_types=1);

namespace App\Services\Api\Base;

use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\QueueName;
use Illuminate\Filesystem\Filesystem;

abstract class GenerateSupervisorRabbitMQConsumerService
{
    use QueueName;

    public const SUPERVISOR_PATH = '/docker/supervisor/configs/commands-and-domain-events';

    protected const EVENTS_TO_PROCESS_AT_TIME             = 200;
    protected const NUMBERS_OF_PROCESSES_PER_SUBSCRIBER   = 1;
    protected const PATH                                  = __DIR__ . '/';

    public function __construct(
        private readonly Filesystem $filesystem,
    ) {

    }

    abstract protected function getConsumeCommandPrefix(): string;

    protected function generate(string $queueName, bool $append): void
    {
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
                $this->getConsumeCommandPrefix(),
                self::EVENTS_TO_PROCESS_AT_TIME,
            ],
            $this->template()
        );

        file_put_contents($this->fileName($queueName), $fileContent, $append ? FILE_APPEND : 0);
    }

    protected function template(): string
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
        stdout_logfile  = /var/project/storage/logs/supervisor/{queue_name}.log

        EOF;
    }

    protected function fileName(string $fileName = 'supervisord'): string
    {
        return sprintf('%s/%s.ini', base_path(static::SUPERVISOR_PATH), $fileName);
    }

    public function clearDirectory(): void
    {
        $directoryFiles = str_replace('//', '/', base_path(static::SUPERVISOR_PATH));

        $this->filesystem->deleteDirectory($directoryFiles);
        $this->filesystem->makeDirectory($directoryFiles);
    }
}
