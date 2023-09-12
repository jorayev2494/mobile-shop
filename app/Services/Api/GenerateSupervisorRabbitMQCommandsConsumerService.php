<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Services\Api\Base\GenerateSupervisorRabbitMQConsumerService;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;

final class GenerateSupervisorRabbitMQCommandsConsumerService extends GenerateSupervisorRabbitMQConsumerService
{
    // public const SUPERVISOR_PATH = '/docker/supervisor/configs/commands';

    protected function getConsumeCommandPrefix(): string
    {
        return 'command';
    }

    public function configCreator(object $handler, bool $append = false): void
    {
        $name = RabbitMqQueueNameFormatter::format($handler);
        $queueName = $this->makeQueueName($name, $handler);

        $this->generate($queueName, $append);
    }
}
