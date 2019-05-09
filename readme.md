This repository illustrate an issue with laravel,
When a class is mocked in tests (Filelink class from filestack-php in this case). 
the instance that the service container gives in custom validation rules does not match.

### tests/Feature/MockFilelinkTest.php ###

```
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
```

### app/Rules/TestContainerInstance.php ###

```
public function passes($attribute, $random)
{
	try
	{
		$random = $request->input('random');

		$test = app(Filelink::class)->getMetaData()['size'] == $random;
	} catch (\Exception $e)
	{
		$test = false;
	}

	return $test;
}
```

### app/Http/Requests/FileTestRequest.php ###

```
public function rules()
{
	return [
		'random' => [new TestContainerInstance()]
	];
}
```

### app/Http/Controllers/Controller.php ###

```
public function fileTest(FileTestRequest $request)
{
	try
	{
		$random = $request->input('random');

		$test = app(Filelink::class)->getMetaData()['size'] == $random;
	} catch (\Exception $e)
	{
		$test = false;
	}

	return response()->json($test);
}
```


