<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Parking;

class Category implements Rule
{
    protected $categories;

    /**
     * Create a new rule instance.
     * @return void
     */
    public function __construct()
    {
        $this->categories = array_keys(Parking::$categorySpots);
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array(strtoupper($value), $this->categories);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Allowed vehicle categories are ' . implode(',', $this->categories);
    }
}
