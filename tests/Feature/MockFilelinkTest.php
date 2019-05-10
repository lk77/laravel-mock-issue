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
     * Test that instance isnt mocked
     *
     * @return void
     */
    public function test_instance_mock()
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
     * Test that instance isnt mocked
     *
     * @return void
     */
    public function test_instance_mock_with_offset_set()
    {
        $random = Str::random(32);

        App::offsetSet(Filelink::class, $this->mock(Filelink::class, function ($mock) use ($random) {
            $mock->shouldReceive('getMetaData')->andReturn(['size' => $random]);
        }));

        $this->assertTrue(app(Filelink::class)->getMetaData()['size'] === $random);

        $response = $this->postJson("/file", ['random' => $random]);

        $this->assertSame('true', $response->getContent());
    }
}
