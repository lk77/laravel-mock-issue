<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileTestRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Filestack\Filelink;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fileTest(FileTestRequest $request)
    {
        try
        {
            $random = $request->input('random');

            $test = app(Filelink::class, ['handle' => $random])->getMetaData()['size'] == $random;
        } catch (\Exception $e)
        {
            $test = false;
        }

        return response()->json($test);
    }
}
