<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Parking;

class PromoCard implements Rule
{
    protected $cards;

    /**
     * Create a new rule instance.
     * @return void
     */
    public function __construct()
    {
        $this->cards = array_keys(Parking::$cards);
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
        return in_array(strtolower($value), $this->cards);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected promo card is invalid. Cards can be: ' . implode(',', $this->cards);
    }
}
