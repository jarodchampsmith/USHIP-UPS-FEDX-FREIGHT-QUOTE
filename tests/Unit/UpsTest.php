<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Contracts\ShippingServiceInterface;
use App\Services\UpsService;
use Ups\Entity\Shipment;
use Ups\Rate;
use Ups\Entity\Address;
use Ups\Entity\ShipFrom;
use Ups\Entity\Package;
use Ups\Entity\PackagingType;
use Ups\Entity\UnitOfMeasurement;
use Ups\Entity\Dimensions;
use Ups\Entity\RateRequest;
use Ups\Entity\RateResponse;
use Ups\Entity\RatedShipment;
use Ups\Entity\Charges;


class UpsTest extends TestCase
{
    private $shipment;
    public function setUp(){
        $address = array();
        $this->shipment = new Shipment;

        // Shipper
        $shipper = $this->shipment->getShipper();
        $shipper->setName("JaneSmith");
        $shipper->setCompanyName("CommercialGoodsGalore");
        $shipper->setPhoneNumber("1234567890");

        // originAddress
        $originaddress = $shipper->getAddress();
        $originaddress->setAddressLine1("1000 Main Street");
        $originaddress->setAddressLine2("Bldg 8, Suite 300");
        $originaddress->setPostalCode("93108");
        $originaddress->setCity("Santa Barbara");
        $originaddress->setstateProvinceCode("CA");
        $originaddress->setCountryCode("US");

        // shipForm

        $shipFrom = new ShipFrom;

        // OriginAddress
        $shipFromAddress = new Address;
        $shipFromAddress->setAddressLine1("1000 Main Street");
        $shipFromAddress->setAddressLine2("Bldg 8, Suite 300");
        $shipFromAddress->setAddressLine2("Bldg 8, Suite 300");
        $shipFromAddress->setPostalCode("93108");
        $shipFromAddress->setCity("Santa Barbara");
        $shipFromAddress->setstateProvinceCode("CA");
        $shipFromAddress->setCountryCode("US");

        $shipFrom->setAddress($originaddress);
        $this->shipment->setShipFrom($shipFrom);

        // shipTo

        $shipTo = $this->shipment->getShipTo();
        $shipTo->setCompanyName("CommercialGoodsGalore");
        $shipTo->setPhoneNumber("3213213210");

        // Destination Address

        $shipToAddress = $shipTo->getAddress();

        $shipToAddress->setPostalCode("10002");
        $shipToAddress->setCountryCode("US");

        // multi package
        $package = new Package;
        $package->getPackagingType()->setCode(PackagingType::PT_PACKAGE);
        $package->getPackageWeight()->setWeight("90");
        $weightUnit = new UnitOfMeasurement;
        $weightUnit->setCode(UnitOfMeasurement::UOM_LBS);
        $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

        $dimensions = new Dimensions;
        $dimensions->setLength("20");
        $dimensions->setWidth("5");
        $dimensions->setHeight("5");
        $unit = new UnitOfMeasurement;
        $unit->setCode(UnitOfMeasurement::UOM_IN);
        $dimensions->setUnitOfMeasurement($unit);
        $package->setDimensions($dimensions);
        $this->shipment->addPackage($package);
    }
    /**
     * A Ups test Success.
     *
     *
     */
    public function testSuccess()
    {
        $ups = new UpsService();
        $response = $ups->call($this->shipment);
        $this->assertArrayHasKey("price",$response);
        $this->assertEquals($response['price'], 84.45);
    }
    /**
    * A Ups test Failure
    * @expectedException Ups\Exception\InvalidResponseException
    * @expectedExceptionMessage The maximum per package weight for the selected service from the selected country is 150.00 pounds. (111035)
    */
    // public function testFailure() {
    //     $ups = new UpsService();
    //     $response = $ups->call($this->shipment);
    //     $this->assertArrayHasKey("error",$response);
    // }

    /**
    * A Ups test Failure Second
    * @expectedException ParseError
    * @expectedExceptionMessage syntax error, unexpected '$shipFrom' (T_VARIABLE)
    */
    // public function testFailureSecond() {
    //     $ups = new UpsService();
    //     $response = $ups->call($this->shipment);
    //     $this->assertArrayHasKey("error",$response);
    // }

    /**
    * A Ups test Failure Third
    * @expectedException FatalThrowableError
    * @expectedExceptionMessage syntax error, unexpected identifier (T_STRING)
    */
    // public function testFailureThird() {
    //     $ups = new UpsService();
    //     $response = $ups->call($this->shipment);
    //     $this->assertArrayHasKey("error",$response);
    // }
}
