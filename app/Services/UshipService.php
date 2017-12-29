<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;

class UshipService implements ShippingServiceInterface
{
   /**
    *  @param integer
    *  @return Array
    *
    *  Request data Validation rules
    *
    */



    public function getRule($count)
    {
        $rules = [
            'item' => 'array|min:1',
        ];

        // origin Address rules

        $rules['item.origin.streetAddress'] = 'required|string|max:255' ;
        $rules['item.origin.majorMunicipality'] = 'required|string|max:255' ;
        $rules['item.origin.postalCode'] = 'required|string|max:255' ;
        $rules['item.origin.stateProvince'] = 'required|string|max:255' ;
        $rules['item.origin.country'] = 'required|string|max:255' ;
        $rules['item.origin.addressType'] = 'required|string|max:255' ;

        $rules['item.origin.earliestArrival'] = 'required|date' ;
        $rules['item.origin.latestArrival'] = 'required|date' ;

        $rules['item.origin.name'] = 'required|string|max:255' ;
        $rules['item.origin.companyName'] = 'required|string|max:255' ;
        $rules['item.origin.phoneNumber'] = 'required|string|max:255' ;

        // destination Address rules

        $rules['item.destination.postalCode'] = 'required|string|max:255' ;
        $rules['item.destination.country'] = 'required|string|max:255' ;
        $rules['item.destination.addressType'] = 'required|string|max:255' ;

        $rules['item.destination.name'] = 'required|string|max:255' ;
        $rules['item.destination.companyName'] = 'required|string|max:255' ;
        $rules['item.destination.phoneNumber'] = 'required|string|max:255' ;


        // items rules

        for ($i = 0; $i < $count; $i++) {
            $rules['items.'.$i.'.Commodity'] = 'required|string|max:255';
            $rules['items.'.$i.'.unitCount'] = 'required|integer|max:50';
            $rules['items.'.$i.'.lengthInMeters'] = 'required_without:'.'items.'.$i.'.freightClass';
            $rules['items.'.$i.'.heightInMeters'] = 'required_with:'.'items.'.$i.'.lengthInMeters';
            $rules['items.'.$i.'.lbs'] = 'required|numeric';
            $rules['items.'.$i.'.freightClass'] = 'required_without:'.'items.'.$i.'.lengthInMeters';
            $rules['items.'.$i.'.handlingUnit'] = 'required|string|max:255';
        }

        return $rules;
    }

    /**
     *  @param Array
     *  @return Json
     *
     *  make uship json and return
     */

    public function returnData($request)
    {
        $uship = array();
        $address = array();
        $count = $request->get('count');

        // Origin Address

        $originAddress['streetAddress'] = $request->item['origin']['streetAddress'];
        $originAddress['alternateStreetAddress'] = $request->item['origin']['alternateStreetAddress'];
        $originAddress['majorMunicipality'] = $request->item['origin']['majorMunicipality'];
        $originAddress['postalCode'] = $request->item['origin']['postalCode'];
        $originAddress['stateProvince'] = $request->item['origin']['stateProvince'];
        $originAddress['country'] = $request->item['origin']['country'];
        $originAddress['addressType'] = $request->item['origin']['addressType'];

        // Origin TimeFrame

        $originTimeFrame['earliestArrival'] = $request->item['origin']['earliestArrival'];
        $originTimeFrame['latestArrival'] = $request->item['origin']['latestArrival'];
        $originTimeFrame['timeFrameType'] = $request->item['origin']['timeFrameType'];

        // Origin attributes

        $originAttributes['inside'] = $request->item['origin']['inside'];
        $originAttributes['liftgateRequired'] = $request->item['origin']['liftgateRequired'];
        $originAttributes['callBeforeArrival'] = $request->item['origin']['callBeforeArrival'];
        $originAttributes['appointmentRequired'] = $request->item['origin']['appointmentRequired'];

        // Origin Contacts

        $originContacts['name'] = $request->item['origin']['name'];
        $originContacts['companyName'] = $request->item['origin']['companyName'];
        $originContacts['phoneNumber'] = $request->item['origin']['phoneNumber'];

        // Desitination Address

        $destinationAddress['postalCode'] = $request->item['destination']['postalCode'];
        $destinationAddress['country'] = $request->item['destination']['country'];
        $destinationAddress['addressType'] = $request->item['destination']['addressType'];

        // Desitination attributes

        $destinationAttributes['inside'] = $request->item['destination']['inside'];
        $destinationAttributes['liftgateRequired'] = $request->item['destination']['liftgateRequired'];
        $destinationAttributes['callBeforeArrival'] = $request->item['destination']['callBeforeArrival'];
        $destinationAttributes['appointmentRequired'] = $request->item['destination']['appointmentRequired'];

        // Destination Contacts

        $destinationContacts['name'] = $request->item['destination']['name'];
        $destinationContacts['companyName'] = $request->item['destination']['companyName'];
        $destinationContacts['phoneNumber'] = $request->item['destination']['phoneNumber'];

        for ( $i = 0; $i < $count; $i++) {
            $commodity[$i] = $request->items[$i]['Commodity'];
            $unitCount[$i] = $request->items[$i]['unitCount'];
            $packaging[$i] = "Pallets"; //$request->items[$i]['packaging'];
            $lengthInMeters[$i] = $request->items[$i]['lengthInMeters'];
            $heightInMeters[$i] = $request->items[$i]['heightInMeters'];
            // $widthInMeters[$i] = $request->items[$i]['widthInMeters'];
            $lbs[$i] = $request->items[$i]['lbs'];
            $freightClass[$i] = $request->items[$i]['freightClass'];
            $stackable[$i] = $request->items[$i]['stackable'];
            $hazardous[$i] = $request->items[$i]['hazardous'];
            $handlingUnit[$i] = $request->items[$i]['handlingUnit'];
        }

        //Attributes
        $protectfromFreezing = $request->protectfromFreezing;
        $sortandSegregate = $request->sortandSegregate;
        $blindShipmentCoordination =$request->blindShipmentCoordination;

        // Route/item Array

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

        // Items Array

        for ( $i = 0; $i < $count; $i++) {
            $items[$i]['Commodity'] = $commodity[$i];
            $items[$i]['unitCount'] = $unitCount[$i];
            $items[$i]['packaging'] = $packaging[$i];
            $items[$i]['lbs'] = $lbs[$i];
            if($freightClass[$i] > 0) {
                $items[$i]['freightClass'] = $freightClass[$i];
            } else {
                $items[$i]['lengthInMeters'] = $lengthInMeters[$i];
                $items[$i]['heightInMeters'] = $heightInMeters[$i];
                $items[$i]['widthInMeters'] = $widthInMeters[$i];
            }
            $items[$i]['stackable'] = $stackable[$i];
            $items[$i]['hazardous'] = $hazardous[$i];
            $items[$i]['handlingUnit'] = $handlingUnit[$i];
        }

        // Attributs Array
        $attributes['protectfromFreezing'] = $protectfromFreezing;
        $attributes['sortandSegregate'] = $sortandSegregate;
        $attributes['blindShipmentCoordination'] = $blindShipmentCoordination;

        $uship['route'] = $route;
        $uship['items'] = $items;
        $uship['attributes'] = $attributes;
        return json_encode($uship);
    }

    /**
     *  @param $client_id : string
     *         $client_secret : string
     *
     *  @return string
     *
     *  post data to https://api.uship.com/oauth/token and get the access_token
     */

    public function getAccessToken($client_id, $client_secret){
        $url = "https://api.uship.com/oauth/token";
        $grant_type = "client_credentials";
        $data = 'grant_type='.$grant_type.'&client_id='.$client_id.'&client_secret='.$client_secret;

        // post to https://api.uship.com/oauth/token

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
        if(curl_exec($ch) === false)
        {
            $error = '{"error": "' . curl_error($ch).'"}';
            echo error; exit;
        } else {
            $response = curl_exec( $ch );
        }

        //convert string to json
        $result = json_decode($response);
        return $result->access_token;
    }

    /**
     *  @param JSON
     *
     *  @return price
     *
     *  call uship api & return pricing.
     */

    public function call($uship){
        $client_id = env('USHIPAPI_CLIENT_ID');
        $client_secret = env('USHIPAPI_CLIENT_SECRET');

        $access_token = $this->getAccessToken($client_id, $client_secret);
        $authorization = "Bearer ".$access_token;

        $uship_endpoint_url = "https://api.uship.com/v2/estimate";
        // $uship_endpoint_url = "https://api.uship.com/v2/rateRequests/";


        $ch = curl_init( $uship_endpoint_url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $uship);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER,array('authorization: '.$authorization));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = array();
        if(curl_exec($ch) === false) {
            $error = curl_error($ch);
            $result = ['error' => $error];
        } else {
            try {
                $response = curl_exec( $ch );
                $response_object = json_decode($response);
                $result = ['price' => $response_object->price->value];
            } catch (Exception $e) {
                $result = ['error' => $e->getMessage()];
            }
        }
        return $result;
    }
}

?>
