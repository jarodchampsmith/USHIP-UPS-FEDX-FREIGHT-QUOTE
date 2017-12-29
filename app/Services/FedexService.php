<?php
/**
* User: Starin
* Date: 06/27/17
*/

namespace App\Services;

use App\Contracts\ShippingServiceInterface;
use SoapClient;
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__."/../libs/fedex/library/fedex-common.php5");

class FedexService implements ShippingServiceInterface
{

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
        $rules['item.origin.name'] = 'required|string|max:255' ;
        $rules['item.origin.companyName'] = 'required|string|max:255' ;
        $rules['item.origin.phoneNumber'] = 'required|string|max:255' ;

        // destination Addres rules

        $rules['item.destination.streetAddress'] = 'required|string|max:255' ;
        // $rules['item.destination.majorMunicipality'] = 'required|string|max:255' ;
        $rules['item.destination.postalCode'] = 'required|string|max:255' ;
        $rules['item.destination.stateProvince'] = 'required|string|max:255' ;
        $rules['item.destination.country'] = 'required|string|max:255' ;
        $rules['item.destination.name'] = 'required|string|max:255' ;
        $rules['item.destination.companyName'] = 'required|string|max:255' ;
        $rules['item.destination.phoneNumber'] = 'required|string|max:255' ;

        //Attributes
        // $rules['item.dropoffType'] = 'required|string|max:255' ;
        // $rules['item.serviceType'] = 'required|string|max:255' ;
        // $rules['item.packagingType'] = 'required|string|max:255' ;

        // items rules

        for ($i = 0; $i < $count; $i++) {
            // $rules['items.'.$i.'.Commodity'] = 'required|string|max:255';
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
        $fedex['WebAuthenticationDetail'] = array(
            'UserCredential' => array(
                'Key' => getProperty('key'),
                'Password' => getProperty('password')
            )
        );
        $fedex['ClientDetail'] = array(
            'AccountNumber' => getProperty('shipaccount'),
            'MeterNumber' => getProperty('meter')
        );
        $fedex['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
        $fedex['Version'] = array(
            'ServiceId' => 'crs',
            'Major' => '20',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        $fedex['ReturnTransitAndCommit'] = true;
        $fedex['RequestedShipment']['DropoffType'] = $request->item['dropoffType']; //'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
        $fedex['RequestedShipment']['ShipTimestamp'] = date('c');
        $fedex['RequestedShipment']['ServiceType'] = $request->item['serviceType']; //'INTERNATIONAL_PRIORITY'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
        $fedex['RequestedShipment']['PackagingType'] = $request->item['packagingType']; //'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
        $fedex['RequestedShipment']['Shipper'] = $this->addShipper($request);
        $fedex['RequestedShipment']['Recipient'] = $this->addRecipient($request);
        $fedex['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment($request);
        $fedex['RequestedShipment']['PackageCount'] = $request->get('count');
        $fedex['RequestedShipment']['RequestedPackageLineItems'] = $this->addPackageLineItems($request);
        return $fedex;
    }

    public function call($fedex)
    {
        $newline = "<br />";
        //The WSDL is not included with the sample code.
        //Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = __ROOT__."/../libs/fedex/wsdl/RateService_v20.wsdl";
        ini_set("soap.wsdl_cache_enabled", "0");
        ini_set('soap.wsdl_cache_ttl',0);

        $client = new SoapClient ( $path_to_wsdl , array(
            //'trace' => 1,
            'stream_context'=> stream_context_create(array('ssl'=> array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'allow_self_signed' => true //can fiddle with this one.
            )))
        )); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information
        $result = array();
        try {
            if(setEndpoint('changeEndpoint')) {
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }

            $response = $client -> getRates($fedex);

            if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){
                $rateReply = $response -> RateReplyDetails;

                if($rateReply->RatedShipmentDetails && is_array($rateReply->RatedShipmentDetails)) {
                    $amount = number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");
                } else if($rateReply->RatedShipmentDetails && ! is_array($rateReply->RatedShipmentDetails)) {
                    $amount = number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");
                }
                // return response()->json(['price' => $amount], 200);
                $result = ['price' => $amount];
            } else {
                $notifications = $response -> Notifications;
                if(is_array($notifications)) {
                    // return response()->json(['error' => $notifications[0] -> LocalizedMessage], 402);
                    $result = ['error' => $notifications[0] -> LocalizedMessage];
                } else {
                    // return response()->json(['error' => $notifications -> LocalizedMessage], 402);
                    $result = ['error' => $notifications -> LocalizedMessage];
                }
                // printError($client, $response);
            }
            // writeToLog($client);    // Write to log file
        } catch (SoapFault $exception) {
        //    printFault($exception, $client);
          //  return response()->json(['error' => $exception -> faultstring], 402);
           $result = ['error' => $exception -> faultstring];
        }
        return $result;
    }

    function addShipper($request)
    {
        $shipper = array(
            'Contact' => array(
                'PersonName' => $request->item['origin']['name'],
                'CompanyName' => $request->item['origin']['companyName'],
                'PhoneNumber' => $request->item['origin']['phoneNumber']
            ),
            'Address' => array(
                'StreetLines' => array($request->item['origin']['streetAddress']),
                'City' => $request->item['origin']['majorMunicipality'],
                'StateOrProvinceCode' => $request->item['origin']['stateProvince'],
                'PostalCode' => $request->item['origin']['postalCode'],
                'CountryCode' => $request->item['origin']['country']
            )
        );
        return $shipper;
    }

    function addRecipient($request)
    {
        $recipient = array(
            'Contact' => array(
                'PersonName' => $request->item['destination']['name'],
                'CompanyName' => $request->item['destination']['companyName'],
                'PhoneNumber' => $request->item['destination']['phoneNumber']
            ),

            'Address' => array(
                'StreetLines' => array($request->item['destination']['streetAddress']),
                'City' => $request->item['destination']['majorMunicipality'],
                'StateOrProvinceCode' => $request->item['destination']['stateProvince'],
                'PostalCode' => $request->item['destination']['postalCode'],
                'CountryCode' => $request->item['destination']['country'],
                'Residential' => false
            )
        );
        return $recipient;
    }

    function addShippingChargesPayment()
    {
        $shippingChargesPayment = array(
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => getProperty('billaccount'),
                    'CountryCode' => 'US'
                )
            )
        );
        return $shippingChargesPayment;
    }

    function addLabelSpecification()
    {
        $labelSpecification = array(
            'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
            'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
            'LabelStockType' => 'PAPER_7X4.75'
        );
        return $labelSpecification;
    }

    function addSpecialServices()
    {
        $specialServices = array(
            'SpecialServiceTypes' => array('COD'),
            'CodDetail' => array(
                'CodCollectionAmount' => array(
                    'Currency' => 'USD',
                    'Amount' => 150
                ),
                'CollectionType' => 'ANY' // ANY, GUARANTEED_FUNDS
            )
        );
        return $specialServices;
    }

    function addPackageLineItems($request)
    {
        $packageLineItems = [];
        for($i = 0; $i < $request->get('count'); $i++) {
            $packageLineItems[$i] = array(
                'SequenceNumber'=>$i + 1,
                'GroupPackageCount'=> $request->items[$i]['unitCount'],
                'Weight' => array(
                    'Value' => $request->items[$i]['lbs'],
                    'Units' => 'LB'
                ),
                'Dimensions' => array(
                    'Length' => $request->items[$i]['lengthInMeters'],
                    'Width' => $request->items[$i]['widthInMeters'],
                    'Height' => $request->items[$i]['heightInMeters'],
                    'Units' => 'IN'
                )
            );
        }
        return $packageLineItems;
    }
}

?>
