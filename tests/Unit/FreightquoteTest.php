<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Services\FreightquoteService;
class FreightquoteTest extends TestCase
{
    private $freightquote;
    public function setUp()
    {
        $this->freightquote = array(
            'GetRatingEngineQuote' => array(
                'request' => array(
                    'CustomerId' => "0",
                    'QuoteType' => "B2B",
                    'ServiceType' => "LTL",
                    'BillCollect' => "SHIPPER",
                    'SortAndSegregate' => "false",
                    'UseStackableFlag' => "false",
                    'QuoteShipment' => array(
                        'IsBlind' => "false",
                        'ShipmentLocations' => array(
                            'Location' => array(
                                0 => array(
                                    'LocationName' => "CommercialGoodsGalore",
                                    'LocationType' => "Origin",
                                    'HasLoadingDock' => "false",
                                    'IsConstructionSite' => "false",
                                    'RequiresInsideDelivery' => "false",
                                    'IsTradeShow' => "false",
                                    'IsResidential' => "false",
                                    'RequiresLiftgate' => "false",
                                    'HasAppointment' => "false",
                                    'IsLimitedAccess' => "false",
                                    'LocationAddress' => array(
                                        'ContactName' => "JaneSmith",
                                        'ContactPhone' => "1234567890",
                                        'streetAddress' => "12250 Iavelli Way",
                                        'AdditionalAddress' => "",
                                        'City' => "Poway",
                                        'StateCode' => "CA",
                                        'PostalCode' => "92064",
                                        'CountryCode' => "US"
                                    )
                                ),
                                1 => array(
                                    'LocationName' => "CommercialGoodsGalore",
                                    'LocationType' => "Destination",
                                    'HasLoadingDock' => "false",
                                    'IsConstructionSite' => "false",
                                    'RequiresInsideDelivery' => "false",
                                    'IsTradeShow' => "false",
                                    'IsResidential' => "false",
                                    'RequiresLiftgate' => "false",
                                    'HasAppointment' => "false",
                                    'IsLimitedAccess' => "false",
                                    'LocationAddress' => array(
                                        'ContactName' => "CommercialGoodsGalore",
                                        'ContactPhone' => "3216548970",
                                        'StreetAddress' => "ste B",
                                        'AdditionalAddress' => "",
                                        'City' => "Kent",
                                        'StateCode' => "WA",
                                        'PostalCode' => "98032",
                                        'CountryCode' => "US"
                                    )
                                )
                            )
                        ),
                        'ShipmentProducts' => array(
                            'Product' => array(
                                0 => array(
                                    'Class' => "300",
                                    'ProductDescription' => "1 LK7530I",
                                    'Weight' => 220.0,
                                    'Length' => 77.0,
                                    'Width' => 45.0,
                                    'Height' => 58.0,
                                    'PackageType' => "Pallets_other",
                                    'CommodityType' => "GeneralMerchandise",
                                    'ContentType' => "NewCommercialGoods",
                                    'IsStackable' => "false",
                                    'IsHazardousMaterial' => "false",
                                    'PieceCount' => "1",
                                    'ItemNumber' => 0
                                )
                            )
                        ),
                        'ShipmentContacts' => array(
                            'ContactAddress' => array(
                                0 => array(
                                    'ContactName' => "JaneSmith",
                                    'ContactPhone' => "1234567890"
                                ),
                                1 => array(
                                    'ContactName' => "James",
                                    'ContactPhone' => "3216548970"
                                )
                            )
                        ),
                    )
                ),
                'user' => array(
                    'Name' => env('FREIGHTQUOTE_USER_ID'),
                    'Password' => env('FREIGHTQUOTE_USER_PWD'),
                    'CredentialType' => 'Default'
                )
            )
        );
    }
    /**
     * A Freightquote test Success.
     *
     *
     */
    public function testFreightquote()
    {
        $freight_quote = new FreightquoteService();
        $response = $freight_quote->call($this->freightquote);
        $this->assertArrayHasKey("price",$response);
        $this->assertEquals($response['price'], 218.84);
    }

    /**
    * A Freightquote test Failure
    * @expectedException
    * @expectedExceptionMessage Dimensions passed will not fit on a truck. {Product:Boxes}
    */
    // public function testFailure()
    // {
    //     $freight_quote = new FreightquoteService();
    //     $response = $freight_quote->call($this->freightquote);
    //     $this->assertArrayHasKey("error",$response);
    // }
    /**
    * A Freightquote test Failure
    * @expectedException
    * @expectedExceptionMessage Dimensions passed will not fit on a truck. {Product:Boxes}
    */
    // public function testFailure()
    // {
    //     $freight_quote = new FreightquoteService();
    //     $response = $freight_quote->call($this->freightquote);
    //     $this->assertArrayHasKey("error",$response);
    // }

    /**
    * A Freightquote test Failure Second
    * @expectedException
    * @expectedExceptionMessage Freightquote.com: No Response
    */

    // public function testFailureSecond()
    // {
    //     $freight_quote = new FreightquoteService();
    //     $response = $freight_quote->call($this->freightquote);
    //     $this->assertArrayHasKey("error",$response);
    // }

    /**
    * A Freightquote test Failure Third
    * @expectedException
    * @expectedExceptionMessage No carriers found for quote -1
    */
    //
    // public function testFailureThird()
    // {
    //     $freight_quote = new FreightquoteService();
    //     $response = $freight_quote->call($this->freightquote);
    //     $this->assertArrayHasKey("error",$response);
    // }
}
