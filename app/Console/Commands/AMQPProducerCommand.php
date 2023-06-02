<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPProducerCommand extends Command
{
    protected $signature = 'rabbitmq:producer';

    protected $description = 'RabbitMQ producer';

    public function handle(AMQPStreamConnection $amqpConnection): int
    {
        /** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
        $channel = $amqpConnection->channel();

        // $count = random_int(5, 25);
        $count = 1500;
        for ($i = 0; $i < $count; $i++) {
            $data = 'Hello RabbitMQ! ' . random_int(0000, 9999) . ' Uuid is ' . \Str::uuid();
            $msg = new AMQPMessage($data);
            $channel->basic_publish($msg, 'test_exchange', 'test_key');
            echo ' [x] Count: ' . $count . ' Sent: ', $data, "\n";
        }

        $channel->close();
        $amqpConnection->close();

        return Command::SUCCESS;
    }
}
