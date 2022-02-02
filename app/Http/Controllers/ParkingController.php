<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnterParkingRequest;
use App\Http\Requests\LeaveParkingRequest;
use App\Http\Requests\CheckBillParkingRequest;
use App\Repositories\ParkingRepository;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    //TODO add unit test
    /**
     * The BlogRepository instance.
     *
     * @var ParkingRepository
     */
    protected $parkingRepository;

    /**
     * Create a new ParkingController instance.
     *
     * @param  ParkingRepository $parkingRepository
     * @return void
     */
    public function __construct(ParkingRepository $parkingRepository)
    {
        $this->parkingRepository = $parkingRepository;
    }

    /**
     * Add new vehicle to the parking lot
     * @param  EnterParkingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enter(EnterParkingRequest $request)
    {
        $this->parkingRepository->addNewVehicle($request->all());

        return response()->json(['success' => true], 201);
    }

    /**
     * Checks the available parking lot spots
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableSpots()
    {
        $availableSpots = $this->parkingRepository->availableSpots();

        return response()->json(['success' => true, 'available-spots' => $availableSpots]);
    }

    /**
     * Checks the sum the owner has to pay to this moment
     * @param  CheckBillParkingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkBill(CheckBillParkingRequest $request)
    {
        $sum = $this->parkingRepository->calcSum($request->reg_num);

        return response()->json(['success' => true, 'sum' => $sum]);
    }

    /**
     * Vehicle leaves the parking lot
     * @param  LeaveParkingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function leave(LeaveParkingRequest $request)
    {
        $sum = $this->parkingRepository->calcSum($request->reg_num);

        $this->parkingRepository->deregisterVehicle($request->reg_num);

        return response()->json(['success' => true, 'sum' => $sum]);
    }
}
