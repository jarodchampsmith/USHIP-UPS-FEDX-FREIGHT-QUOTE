<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Services\FedexService;
define('__ROOTDIRECT__', dirname(dirname(__FILE__)));
require_once(__ROOTDIRECT__.'/../libs/fedex/library/fedex-common.php5');

class FedexTest extends TestCase
{
    private $fedex;

    public function setUp()
    {
        $this->fedex = array();
        $shipper = array();
        $recipient = array();
        $shippingChargesPayment = array();
        $packageLineItems = array();

        //Shipper Contacts Info
        $shipper['Contact']['PersoonName'] = "JaneSmith";
        $shipper['Contact']['companyName'] = "CommercialGoodsGalore";
        $shipper['Contact']['phoneNumber'] = "1234567890";

        //Shipper Address Info
        $shipper['Address']['StreetLines'] = "1000 Main Street";
        $shipper['Address']['City'] = "Santa Barbara";
        $shipper['Address']['StateOrProvinceCode'] = "CA";
        $shipper['Address']['PostalCode'] = "93108";
        $shipper['Address']['CountryCode'] = "US";

        //Recipient Contacts information
        $recipient['Contact']['PersoonName'] = "James";
        $recipient['Contact']['companyName'] = "CommercialGoodsGalore";
        $recipient['Contact']['phoneNumber'] = "3216548970";

        //Recipient Address information
        $recipient['Address']['StreetLines'] = "172 Allen St";
        $recipient['Address']['City'] = "";
        $recipient['Address']['StateOrProvinceCode'] = "NY";
        $recipient['Address']['PostalCode'] = "10002";
        $recipient['Address']['CountryCode'] = "US";

        //ShippingChargesPayment
        $shippingChargesPayment = array(
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => getProperty('billaccount'),
                    'CountryCode' => 'US'
                )
            )
        );

        //PackageLineItems
        $packageLineItems[0] = array(
          'SequenceNumber' => 1,
          'GroupPackageCount'=> 1,
          'Weight' => array(
              'Value' => "90",
              'Units' => 'LB'
          ),
          'Dimensions' => array(
              'Length' => "10",
              'Width' => "5",
              'Height' => "5",
              'Units' => 'IN'
          )
        );

        $this->fedex['WebAuthenticationDetail'] = array(
            'UserCredential' => array(
                'Key' => getProperty('key'),
                'Password' => getProperty('password')
            )
        );
        $this->fedex['ClientDetail'] = array(
            'AccountNumber' => getProperty('shipaccount'),
            'MeterNumber' => getProperty('meter')
        );
        $this->fedex['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
        $this->fedex['Version'] = array(
            'ServiceId' => 'crs',
            'Major' => '20',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        $this->fedex['ReturnTransitAndCommit'] = true;
        $this->fedex['RequestedShipment']['DropoffType'] = "REGULAR_PICKUP";
        $this->fedex['RequestedShipment']['ShipTimestamp'] = date('c');
        $this->fedex['RequestedShipment']['ServiceType'] = "FEDEX_GROUND";
        $this->fedex['RequestedShipment']['PackagingType'] = "YOUR_PACKAGING";
        $this->fedex['RequestedShipment']['Shipper'] = $shipper;
        $this->fedex['RequestedShipment']['Recipient'] = $recipient;
        $this->fedex['RequestedShipment']['PackageCount'] = 1;
        $this->fedex['RequestedShipment']['ShippingChargesPayment'] = $shippingChargesPayment;
        $this->fedex['RequestedShipment']['RequestedPackageLineItems'] = $packageLineItems;
    }
    /**
     * A Fedex test Success.
     *
     *
     */
    public function testSuccess()
    {
        $fedex = new FedexService();
        $response = $fedex->call($this->fedex);
        $this->assertArrayHasKey("price",$response);
        $this->assertEquals($response['price'], 84.34);
    }
    /**
    * A Fedex test Failure
    * @expectedException
    * @expectedExceptionMessage Service is not allowed.
    */
    // public function testFailure()
    // {
    //     $Fedex = new FedexService();
    //     $response = $Fedex->call($this->fedex);
    //     $this->assertArrayHasKey("error",$response);
    // }

    /**
    * A Fedex test Failure Second
    * @expectedException
    * @expectedExceptionMessage Package 1 - Invalid dimensions
    */

    // public function testFailureSecond()
    // {
    //     $Fedex = new FedexService();
    //     $response = $Fedex->call($this->fedex);
    //     $this->assertArrayHasKey("error",$response);
    // }


}
