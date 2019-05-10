<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\File;
use Filestack\Filelink;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class MockFilelinkTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that instance is mocked with $this->mock
     *
     * @testdox We are testing that the instance is mocked when using $this->mock
     *
     * @return void
     */
    public function test_instance_mock_with_this_mock()
    {
        $random = Str::random(32);

        $this->mock(Filelink::class, function ($mock) use ($random) {
            $mock->shouldReceive('getMetaData')->andReturn(['size' => $random]);
        });

        $this->assertTrue(app(Filelink::class)->getMetaData()['size'] === $random);

        $response = $this->postJson("/file", ['random' => $random]);

        $this->assertSame('true', $response->getContent());
    }

    /**
     * Test that instance is mocked with App::offsetSet
     *
     * @testdox We are testing that the instance is mocked when using App::offsetSet
     *
     * @return void
     */
    public function test_instance_mock_with_app_offset_set()
    {
        $random = Str::random(32);

        App::offsetSet(Filelink::class, $this->mock(Filelink::class, function ($mock) use ($random) {
            $mock->shouldReceive('getMetaData')->andReturn(['size' => $random]);
        }));

        $this->assertTrue(app(Filelink::class)->getMetaData()['size'] === $random);

        $response = $this->postJson("/file", ['random' => $random]);

        $this->assertSame('true', $response->getContent());
    }

    /**
     * Test that instance is mocked with app instance
     *
     * @testdox We are testing that the instance is mocked when using $this->app->instance
     *
     * @return void
     */
    public function test_instance_mock_with_app_instance()
    {
        $random = Str::random(32);

        $this->app->instance(Filelink::class, $this->mock(Filelink::class, function ($mock) use ($random) {
            $mock->shouldReceive('getMetaData')->andReturn(['size' => $random]);
        }));

        $this->assertTrue(app(Filelink::class)->getMetaData()['size'] === $random);

        $response = $this->postJson("/file", ['random' => $random]);

        $this->assertSame('true', $response->getContent());
    }

    /**
     * Test that instance is mocked with make with
     *
     * @testdox We are testing that the instance is mocked when using $this->mock and $this->app->makeWith
     *
     * @return void
     */
    public function test_instance_mock_with_this_mock_and_app_make_with()
    {
        $random = Str::random(32);

        $this->mock(Filelink::class, function ($mock) use ($random) {
            $mock->shouldReceive('getMetaData')->andReturn(['size' => $random]);
        });

        $instance = $this->app->makeWith(Filelink::class, ['handle' => $random]);

        $this->assertTrue($instance->getMetaData()['size'] === $random);
    }

    /**
     * Test that instance is mocked with make
     *
     * @testdox We are testing that the instance is mocked when using $this->mock and $this->app->make
     *
     * @return void
     */
    public function test_instance_mock_with_this_mock_and_app_make()
    {
        $random = Str::random(32);

        $this->mock(Filelink::class, function ($mock) use ($random) {
            $mock->shouldReceive('getMetaData')->andReturn(['size' => $random]);
        });

        $instance = $this->app->make(Filelink::class);

        $this->assertTrue($instance->getMetaData()['size'] === $random);
    }
}
