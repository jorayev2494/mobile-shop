<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ\Traits;

trait RoutingKey
{
    protected function makeRoutingKey(string $value, object $handler): string
    {
        $className = class_basename($handler);
        
        $ch = explode('.', $value);
        foreach ($ch as $key => $v) {
            if ($v === $className) {
                unset($ch[$key]);
            }
        }
        
        // $routingKey = substr($value, 0, strpos($value, '.' . $className));
        $routingKey = implode('.', $ch);

        return strtolower($routingKey);
    }
}
