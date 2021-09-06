<?php

namespace RyanChandler\Proxy;

class Proxy
{
    public function __construct(
        protected object $target,
        protected array $handlers,
    ) {}

    public function __get(string $name)
    {
        if (! array_key_exists('get', $this->handlers)) {
            return $this->target->{$name};
        }

        return call_user_func($this->handlers['get'], $this->target, $name);
    }

    public function __set(string $name, mixed $value)
    {
        if (! array_key_exists('set', $this->handlers)) {
            return $this->target->{$name} = $value;
        }

        call_user_func($this->handlers['set'], $this->target, $name, $value);
    }
}
