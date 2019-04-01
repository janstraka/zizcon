<?php

namespace Libs;

use Entity\AttendantEvent;
use Nette\DI\Container;
use Nette\Object;

class MapCoordinates extends Object
{
    /**
     * @param $address
     * @return Coordinate
     */
    public function getCoordinates($address)
    {
        if(!$address){
            return false;
        }

        $address = urlencode($address);
        $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
        $response = file_get_contents($url);
        $json = json_decode($response,true);

        $location = $json['results'][0]['geometry']['location'];

        return new Coordinate($location['lat'], $location['lng']);
    }
}

class Coordinate{
    public $latitude;
    public $longitude;

    /**
     * Coordinate constructor.
     * @param $latitude
     * @param $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }


}