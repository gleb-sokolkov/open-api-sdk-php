<?php

namespace Open\Api\Adapter\IlluminateOpenApi\Interfaces;

interface LogInterface
{
    public function debug(string $message, array $context = []): void;

    public function info(string $message, array $context = []): void;

    public function error(string $message, array $context = []): void;

    public function warning(string $message, array $context = []): void;

    public function critical(string $message, array $context = []): void;
}
