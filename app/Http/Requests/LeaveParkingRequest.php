<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\ParkingRepository;
use App\Rules\AlreadyOut;

class LeaveParkingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(ParkingRepository $parkingRepository)
    {
        return [
            'reg_num' => ['required', 'max:255', new AlreadyOut($parkingRepository)],
        ];
    }
}
