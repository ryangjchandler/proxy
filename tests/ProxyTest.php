<?php

use RyanChandler\Proxy\Proxy;

class Target
{
    public $_name = 'Ryan';
}

test('it can proxy get calls', function () {
    $target = new Proxy(new Target(), [
        'get' => function (Target $target, string $name) {
            $property = '_' . $name;

            return $target->{$property};
        },
    ]);

    expect($target->name)->toEqual('Ryan');
});

test('it can proxy set calls', function () {
    $target = new Proxy(new Target(), [
        'get' => function (Target $target, string $name) {
            $property = '_' . $name;

            return $target->{$property};
        },
        'set' => function (Target $target, string $name, mixed $value) {
            $property = '_' . $name;

            $target->{$property} = $value;
        },
    ]);

    $target->name = 'John';

    expect($target->name)->toEqual('John');
});

test('it can proxy method calls', function () {
    $target = new Proxy(new Target(), [
        'call' => function (Target $target, string $name, array $arguments = []) {
            $property = '_' . $name;

            return $target->{$property};
        },
    ]);

    expect($target->name())->toEqual('Ryan');
});

test('it can proxy method calls with arguments', function () {
    $target = new Proxy(new Target(), [
        'call' => function (Target $target, string $name, array $arguments = []) {
            $property = '_' . $name;

            return $arguments[0] . $target->{$property};
        },
    ]);

    expect($target->name('Hello, '))->toEqual('Hello, Ryan');
});
