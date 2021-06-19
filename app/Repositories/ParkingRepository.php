<?php

namespace App\Repositories;

use App\Parking;
use DateTime;

class ParkingRepository extends BaseRepository {

    /**
     * Create a new ParkingRepository instance.
     *
     * @param  Parking $parking
     * @return void
     */
    public function __construct(Parking $parking)
    {
        $this->model = $parking;
    }

    /**
     * Add vehicle to the parking.
     *
     * @param  array $post
     * @return void
     */
    public function addNewVehicle($post)
    {
        $this->model->create($post);
    }

    public function notAlreadyIn($regNum)
    {
        $vehicleIn = $this->model->where('reg_num', $regNum)->whereNull('departure_at')->count();

        return $vehicleIn == 0;
    }

    public function getAllVehiclesCurrentlyIn()
    {
        return $this->model->whereNull('departure_at')->get();
    }

    public function availableSpots()
    {
        $allVehiclesIn = $this->getAllVehiclesCurrentlyIn();
        $availableSpots = Parking::$maxSpots;

        if(!empty($allVehiclesIn)) {
            foreach($allVehiclesIn as $vehicle) {
                $availableSpots -= $vehicle->spots;
            }
        }

        return $availableSpots;
    }

    public function isThereEnoughSpaceForCategory($category)
    {
        $availableSpots = $this->availableSpots();

        $spotsForCategory = Parking::$categorySpots[$category];

        return ($availableSpots - $spotsForCategory) > 0;
    }

    // about to be depricated
    public function vehicleIsInTheParking($regNum)
    {
        return !$this->notAlreadyIn($regNum);
    }

    public function calcSum($regNum)
    {
        $vehicle = $this->model->where('reg_num', $regNum)->whereNull('departure_at')->first();
        $begin = new DateTime($vehicle->arrival_at);
        $end = new DateTime();

        $interval = \DateInterval::createFromDateString('1 hour');
        $period = new \DatePeriod($begin, $interval, $end);
        $sum = 0;

        foreach ($period as $dt) {
            $tariffType = $this->getTariffType($dt);
            $hourPrice = Parking::$prices[$vehicle->category][$tariffType];
            $sum += $hourPrice;
        }

        if(!empty($vehicle->promo_card)) {
            $discount = Parking::$cards[$vehicle->promo_card];
            $sum = $sum * ((100-$discount) / 100);
        }

        return $sum;
    }

    private function getTariffType($dt)
    {
        $dailyStart = Parking::$tariffHoursDaily['from'];
        $dailyEnd = Parking::$tariffHoursDaily['to'];

        $hour = $dt->format('H:i');

        if ($hour >= $dailyStart  && $hour <= $dailyEnd) {
            $type = 'daily';
        } else {
            $type = 'nightly';
        }

        return $type;
    }

    public function deregisterVehicle($regNum)
    {
        $this->model->where('reg_num', $regNum)->whereNull('departure_at')->update(['departure_at' => now()]);
    }
}
