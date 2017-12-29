<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Services\UshipService;


class UshipTest extends TestCase
{
    private $uship;

    public function setUp() {
      $this->uship = array();
      $address = array();

      // Origin Address

      $originAddress['streetAddress'] = "1000 Main Street";
      $originAddress['alternateStreetAddress'] = "Bldg 8, Suite 300";
      $originAddress['majorMunicipality'] = "Santa Barbara";
      $originAddress['postalCode'] = "93108";
      $originAddress['stateProvince'] = "CA";
      $originAddress['country'] = "US";
      $originAddress['addressType'] = "BusinessWithLoadingDockOrForklift";

      // Origin TimeFrame

      $originTimeFrame['earliestArrival'] = "2017-06-09";
      $originTimeFrame['latestArrival'] = "2017-06-15";
      $originTimeFrame['timeFrameType'] = "on";

      // Origin Attributes

      $originAttributes['inside'] = "false";
      $originAttributes['liftgateRequired'] = "false";
      $originAttributes['callBeforeArrival'] = "true";
      $originAttributes['appointmentRequired'] = "true";

      //Origin Contacts

      $originContacts['name'] = "JaneSmith";
      $originContacts['companyName'] = "CommercialGoodsGalore";
      $originContacts['phoneNumber'] = "1234567890";

      // Desitination Address

      $destinationAddress['postalCode'] = "10002";
      $destinationAddress['country'] = "US";
      $destinationAddress['addressType'] =  "BusinessWithLoadingDockOrForklift";

      // Desitination attributes
      $destinationAttributes['inside'] = "false";
      $destinationAttributes['liftgateRequired'] = "false";
      $destinationAttributes['callBeforeArrival'] = "true";
      $destinationAttributes['appointmentRequired'] = "true";

      // Destination Contacts

      $destinationContacts['name'] = "James";
      $destinationContacts['companyName'] = "CommercialGoodsGalore";
      $destinationContacts['phoneNumber'] = "1234567890";

      $commodity[0]="CarsLightTrucks";
      $unitCount[0]= "1";
      $packaging[0] = "Pallets";
      $lengthInMeters[0] = "20";
      $heightInMeters[0] = "5";
      $widthInMeters[0] = "5";
      $lbs[0] = "90";
      $freightClass[0] = "77.5";
      $stackable[0] = "true";
      $hazardous[0] = "false";
      $handlingUnit[0] = "Boxes";

      // Attributes

      $protectfromFreezing = "false";
      $sortandSegregate = "false";
      $blindShipmentCoordination = "false";

      //Route/item Array.

      $origin['address'] = $originAddress;
      $origin['timeFrame'] = $originTimeFrame;
      $origin['attributes'] = $originAttributes;
      $origin['contact'] = $originContacts;

      $destination['address'] = $destinationAddress;
      $destination['attributes'] = $destinationAttributes;
      $destination['contact'] = $destinationContacts;

      array_push($address,$origin);
      array_push($address,$destination);
      $route['items'] = $address;

      $items[0]['Commodity'] = $commodity[0];
      $items[0]['unitCount'] = $unitCount[0];
      $items[0]['packaging'] = $packaging[0];
      $items[0]['lbs'] = $lbs[0];
      $items[0]['freightClass'] = $freightClass[0];

      $items[0]['lengthInMeters'] = $lengthInMeters[0];
      $items[0]['heightInMeters'] = $heightInMeters[0];
      $items[0]['widthInMeters'] = $widthInMeters[0];

      $items[0]['stackable'] = $stackable[0];
      $items[0]['hazardous'] = $hazardous[0];
      $items[0]['handlingUnit'] = $handlingUnit[0];

      // Attributs Array
      $attributes['protectfromFreezing'] = $protectfromFreezing;
      $attributes['sortandSegregate'] = $sortandSegregate;
      $attributes['blindShipmentCoordination'] = $blindShipmentCoordination;

      $this->uship['route'] = $route;
      $this->uship['items'] = $items;
      $this->uship['attributes'] = $attributes;

    }
    /**
     * A Uship test Success.
     *
     *
     */
    public function testSuccess() {
        $Uship = new UshipService();
        $response = $Uship->call(json_encode($this->uship));
        $this->assertArrayHasKey("price",$response);
        $this->assertEquals($response['price'], 998.58);
    }

    /**
    * A Uship test Failure
    * @expectedException ErrorException
    * @expectedExceptionMessage Undefined property: stdClass::$price
    */
    // public function testFailure() {
    //     $Uship = new UshipService();
    //     $response = $Uship->call(json_encode($this->uship));
    //     $this->assertArrayHasKey("error",$response);
    // }

    /**
    * A Uship test Failure Second
    * @expectedException ParseError
    * @expectedExceptionMessage syntax error, unexpected '$shipFrom' (T_VARIABLE)
    */
    // public function testFailureSecond() {
    //     $Uship = new UshipService();
    //     $response = $Uship->call(json_encode($this->uship));
    //     $this->assertArrayHasKey("error",$response);
    // }

}
