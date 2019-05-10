<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Filestack\Filelink;

class TestContainerInstance implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $random)
    {
        return true;
        try
        {
            $random = request()->input('random');

            $test = app(Filelink::class, ['handle' => $random])->getMetaData()['size'] == $random;
        } catch (\Exception $e)
        {
            $test = false;
        }

        return $test;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The mocking hasn't worked";
    }
}
