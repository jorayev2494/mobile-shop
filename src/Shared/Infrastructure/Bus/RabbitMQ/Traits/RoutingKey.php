<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ\Traits;

trait RoutingKey
{
    protected function makeRoutingKey(string $value, object $handler): string
    {
        return $this->makeRoutingKeyFromClassName($value, class_basename($handler));

    }

    protected function makeRoutingKeyFromClassName(string $value, string $handlerClassName): string
    {        
        $ch = explode('.', $value);
        foreach ($ch as $key => $v) {
            if ($v === $handlerClassName) {
                unset($ch[$key]);
            }
        }
        
        // $routingKey = substr($value, 0, strpos($value, '.' . $className));
        $routingKey = implode('.', $ch);

        return strtolower($routingKey);
    }
}
