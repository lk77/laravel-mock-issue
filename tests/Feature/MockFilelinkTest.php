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
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('DatabaseSeeder');

        $user = User::first();

        $this->actingAs($user);

        // On mock s3
        Storage::shouldReceive('temporaryUrl')
               ->andReturn('https://s3.eu-central-1.amazonaws.com/user-media.crown.tv.eu/uploaded/root_file5cadeade3550b?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA42J2KDJSZVXXHFWJ%2F20190417%2Feu-central-1%2Fs3%2Faws4_request&X-Amz-Date=20190417T080154Z&X-Amz-SignedHeaders=host&X-Amz-Expires=7200&X-Amz-Signature=93e2507a77639afdc464fa73735d8f4010d8d0d63ac8611f94d8f5c7b2cb8c9d');
    }

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
}
