<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Executa antes de cada teste
     * @return void
     */
    public function setUp():void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

    }
}
