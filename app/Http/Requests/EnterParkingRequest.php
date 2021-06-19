<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Category;
use App\Rules\PromoCard;
use App\Rules\AlreadyIn;
use App\Rules\EnoughSpace;
use App\Repositories\ParkingRepository;

class EnterParkingRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(ParkingRepository $parkingRepository)
    {
        return [
            'reg_num' => ['required', 'max:255', new AlreadyIn($parkingRepository)],
            'category' => ['bail', 'required', new Category, new EnoughSpace($parkingRepository)],
            'promo_card' => ['sometimes', 'required', new PromoCard],
        ];
    }

}
