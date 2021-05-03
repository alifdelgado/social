<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function assertClassUsestraits($trait, $class)
    {
        $this->assertArrayHasKey(
            $trait,
            class_uses($class),
            "{$class} class must use {$trait} trait"
        );
    }
}
