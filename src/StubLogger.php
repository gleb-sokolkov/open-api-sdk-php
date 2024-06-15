<?php

namespace BusinessRU\Open\Api;

use Psr\Log\LoggerInterface;

class StubLogger implements LoggerInterface
{

    public function emergency($message, array $context = array()): void
    {
        // TODO: Implement emergency() method.
    }

    public function alert($message, array $context = array()): void
    {
        // TODO: Implement alert() method.
    }

    public function critical($message, array $context = array()): void
    {
        // TODO: Implement critical() method.
    }

    public function error($message, array $context = array()): void
    {
        // TODO: Implement error() method.
    }

    public function warning($message, array $context = array()): void
    {
        // TODO: Implement warning() method.
    }

    public function notice($message, array $context = array()): void
    {
        // TODO: Implement notice() method.
    }

    public function info($message, array $context = array()): void
    {
        // TODO: Implement info() method.
    }

    public function debug($message, array $context = array()): void
    {
        // TODO: Implement debug() method.
    }

    public function log($level, $message, array $context = array()): void
    {
        // TODO: Implement log() method.
    }
}