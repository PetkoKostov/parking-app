<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\ParkingRepository;

class AlreadyIn implements Rule
{
    /**
     * The ParkingRepository instance.
     *
     * @var ParkingRepository
     */
    protected $parkingRepository;

    /**
     * Create a new rule instance.
     * @param  ParkingRepository $parkingRepository
     * @return void
     */
    public function __construct(ParkingRepository $parkingRepository)
    {
        $this->parkingRepository = $parkingRepository;
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
        return $this->parkingRepository->notAlreadyIn($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This vehicle is already in the parking lot.';
    }
}
