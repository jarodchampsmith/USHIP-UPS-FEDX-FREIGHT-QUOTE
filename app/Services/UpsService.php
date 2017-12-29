<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;
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

class UpsService implements ShippingServiceInterface
{
    public function getRule($count)
    {
        $rules = [
            'item' => 'array|min:1',
        ];

        // origin Address rules

        $rules['item.origin.streetAddress'] = 'required|string|max:255';
        $rules['item.origin.majorMunicipality'] = 'required|string|max:255';
        $rules['item.origin.postalCode'] = 'required|string|max:255';
        $rules['item.origin.stateProvince'] = 'required|string|max:255';
        $rules['item.origin.country'] = 'required|string|max:255';
        $rules['item.origin.name'] = 'required|string|max:255';
        $rules['item.origin.companyName'] = 'required|string|max:255';
        $rules['item.origin.phoneNumber'] = 'required|string|max:255';

        // destination Addres rules

        $rules['item.destination.postalCode'] = 'required|string|max:255';
        $rules['item.destination.country'] = 'required|string|max:255';
        $rules['item.destination.companyName'] = 'required|string|max:255';
        $rules['item.destination.phoneNumber'] = 'required|string|max:255';

        // items rules

        for ($i = 0; $i < $count; $i++) {
            $rules['items.'.$i.'.unitCount'] = 'required|integer|max:50';
            $rules['items.'.$i.'.lengthInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.widthInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.heightInMeters'] = 'required|numeric';
            $rules['items.'.$i.'.lbs'] = 'required|numeric';
        }

        return $rules;
    }
    public function returnData($request)
    {
        try {
            $shipment = new Shipment;


            //Shipper
            $shipper = $shipment->getShipper();
            $shipper->setName($request->item['origin']['name']);
            $shipper->setCompanyName($request->item['origin']['companyName']);
            $shipper->setPhoneNumber($request->item['origin']['phoneNumber']);

            // OriginAddress
            $originaddress = $shipper->getAddress();
            $originaddress->setAddressLine1($request->item['origin']['streetAddress']);
            $originaddress->setAddressLine2($request->item['origin']['alternateStreetAddress']);
            $originaddress->setPostalCode($request->item['origin']['postalCode']);
            $originaddress->setCity($request->item['origin']['majorMunicipality']);
            $originaddress->setstateProvinceCode($request->item['origin']['stateProvince']);
            $originaddress->setCountryCode($request->item['origin']['country']);

            //shipFrom
            $shipFrom = new ShipFrom;
            // OriginAddress
            $shipFromAddress = new Address;
            $shipFromAddress->setAddressLine1($request->item['origin']['streetAddress']);
            $shipFromAddress->setAddressLine2($request->item['origin']['alternateStreetAddress']);
            $shipFromAddress->setPostalCode($request->item['origin']['postalCode']);
            $shipFromAddress->setCity($request->item['origin']['majorMunicipality']);
            $shipFromAddress->setstateProvinceCode($request->item['origin']['stateProvince']);
            $shipFromAddress->setCountryCode($request->item['origin']['country']);

            $shipFrom->setAddress($originaddress);
            $shipment->setShipFrom($shipFrom);


            //shipTo
            $shipTo = $shipment->getShipTo();
            $shipTo->setCompanyName($request->item['destination']['companyName']);
            $shipTo->setPhoneNumber($request->item['destination']['phoneNumber']);

            //Destination Address
            $shipToAddress = $shipTo->getAddress();

            $shipToAddress->setPostalCode($request->item['destination']['postalCode']);
            $shipToAddress->setCountryCode($request->item['destination']['country']);

            // multi package
            for($i = 0; $i < $request->get('count'); $i++) {
                $package = new Package;
                $package->getPackagingType()->setCode(PackagingType::PT_PACKAGE);
                $package->getPackageWeight()->setWeight($request->items[$i]['lbs']);
                $weightUnit = new UnitOfMeasurement;
                $weightUnit->setCode(UnitOfMeasurement::UOM_LBS);
                $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

                $dimensions = new Dimensions;
                $dimensions->setLength($request->items[$i]['lengthInMeters']);
                $dimensions->setWidth($request->items[$i]['widthInMeters']);
                $dimensions->setHeight($request->items[$i]['heightInMeters']);
                $unit = new UnitOfMeasurement;
                $unit->setCode(UnitOfMeasurement::UOM_IN);
                $dimensions->setUnitOfMeasurement($unit);
                $package->setDimensions($dimensions);
                $shipment->addPackage($package);
            }
            return $shipment;
        } catch (Exception $e){
            print_r($e); exit;
        }
    }
    public function call($shipment)
    {
        $user_id = env('UPS_USER_ID');
        $user_password = env('UPS_USER_PASSWORD');
        $access_key = env('UPS_ACCESS_KEY');

        // Rate Object
        $rate = new Rate($access_key, $user_id, $user_password);

        // RateRequest Object
        $rateRequest = new RateRequest;
        $rateRequest->setShipment($shipment);
        $result = array();
        try {
            //Send Reqeust and Get Response
            $rateResponse = $rate->getRate($rateRequest);
            $ratedShipment = $rateResponse->RatedShipment;
            $TotalCharges = $ratedShipment[0]->TotalCharges;
            $result = ['price' => $TotalCharges->MonetaryValue];

        } catch (Exception $e){
            $result = ['error'=>$e->getMessage()];
        }
        return $result;
    }
}

?>
