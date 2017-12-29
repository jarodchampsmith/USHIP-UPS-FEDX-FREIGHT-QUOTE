@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="post" action="/home">
            {{ csrf_field() }}
            @if (count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <div class="container">
                <fieldset>
                    <legend>ShippingType</legend>
                    <div class="text-center">
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="UShip" checked> UShip</span>
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="UPS"> UPS</span>
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="FedEx"> FedEx</span>
                        <span class="col-sm-3"><input type="radio" name="thirdParty" value="Freightquote"> Freightquote</span>
                    </div>
                </fieldset>
                <fieldset class="route">
                    <legend class="route-legend">Route:</legend>
                    <div class="itemdiv" id="itemdiv">
                        <div class="first col-sm-6" id="first">
                            <fieldset>
                                <legend>Shipper / ShipFrom:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">streetAddress:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][streetAddress]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">alternateStreetAddress:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][alternateStreetAddress]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">majorMunicipality:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][majorMunicipality]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">postalCode:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][postalCode]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">stateProvince:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][stateProvince]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">country:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][country]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row" name="UShip">
                                    <label class="col-md-4">AddressType:</label>
                                    <div class="col-md-8">
                                        <select name="item[origin][addressType]" class="full-width">
                                            <option value="Residence">Residence</option>
                                            <option value="BusinessWithLoadingDockOrForklift">Business (with loading dock or forklift)</option>
                                            <option value="BusinessWithoutLoadingDockOrForklift">Business (without loading dock or forklift)</option>
                                            <option value="Port">Port</option>
                                            <option value="ConstructionSite">ConstructionSite</option>
                                            <option value="TradeShowOrConvention">Trade Show / Convention Center</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="MilitaryBase">Military Base</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="Airport">Airport</option>
                                            <option value="OtherSecuredLocation">Other Secured or Limited Access Location</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Contact:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">name:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][name]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">companyName:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][companyName]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">phoneNumber:</label>
                                    <div class="col-md-8">
                                        <input name="item[origin][phoneNumber]" type="tel" class="input full-width"></input>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset name="UShip">
                                <legend>Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">Inside:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][inside]" value="true"> Yes
                                        <input type="radio" name="item[origin][inside]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">LiftgateRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][liftgateRequired]" value="true"> Yes
                                        <input type="radio" name="item[origin][liftgateRequired]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">callBeforeArrival:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][callBeforeArrival]" value="true" checked> Yes
                                        <input type="radio" name="item[origin][callBeforeArrival]" value="false"> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">appointmentRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][appointmentRequired]" value="true" checked> Yes
                                        <input type="radio" name="item[origin][appointmentRequired]" value="false"> No<br>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset name="Freightquote">
                                <legend>Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">HasLoadingDock:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][hasLoadingDock]" value="true"> Yes
                                        <input type="radio" name="item[origin][hasLoadingDock]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsConstructionSite:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isConstructionSite]" value="true"> Yes
                                        <input type="radio" name="item[origin][isConstructionSite]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresInsideDelivery:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][requiresInsideDelivery]" value="true"> Yes
                                        <input type="radio" name="item[origin][requiresInsideDelivery]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsTradeShow:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isTradeShow]" value="true"> Yes
                                        <input type="radio" name="item[origin][isTradeShow]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsResidential:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isResidential]" value="true"> Yes
                                        <input type="radio" name="item[origin][isResidential]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresLiftgate:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][requiresLiftgate]" value="true"> Yes
                                        <input type="radio" name="item[origin][requiresLiftgate]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">HasAppointment:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][hasAppointment]" value="true"> Yes
                                        <input type="radio" name="item[origin][hasAppointment]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsLimitedAccess:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[origin][isLimitedAccess]" value="true"> Yes
                                        <input type="radio" name="item[origin][isLimitedAccess]" value="false" checked> No<br>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="destination col-sm-6" id="destination">
                            <fieldset>
                                <legend>ShipTo:</legend>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>streetAddress:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input name="item[destination][streetAddress]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">alternateStreetAddress:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][alternateStreetAddress]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">majorMunicipality:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][majorMunicipality]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">postalCode:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][postalCode]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">stateProvince:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][stateProvince]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">country:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][country]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row" name="UShip">
                                    <label class="col-md-4">AddressType:</label>
                                    <div class="col-md-8">
                                        <select name="item[destination][addressType]" class="full-width">
                                            <option value="Residence">Residence</option>
                                            <option value="BusinessWithLoadingDockOrForklift">Business (with loading dock or forklift)</option>
                                            <option value="BusinessWithoutLoadingDockOrForklift">Business (without loading dock or forklift)</option>
                                            <option value="Port">Port</option>
                                            <option value="ConstructionSite">ConstructionSite</option>
                                            <option value="TradeShowOrConvention">Trade Show / Convention Center</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="MilitaryBase">Military Base</option>
                                            <option value="StorageFacility">Storage Facility</option>
                                            <option value="Airport">Airport</option>
                                            <option value="OtherSecuredLocation">Other Secured or Limited Access Location</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Contact:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">name:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][name]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">companyName:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][companyName]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">phoneNumber:</label>
                                    <div class="col-md-8">
                                        <input name="item[destination][phoneNumber]" type="tel" class="input full-width"></input>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset name="UShip">
                                <legend>Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">Inside:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][inside]" value="true"> Yes
                                        <input type="radio" name="item[destination][inside]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">LiftgateRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][liftgateRequired]" value="true"> Yes
                                        <input type="radio" name="item[destination][liftgateRequired]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">callBeforeArrival:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][callBeforeArrival]" value="true" checked> Yes
                                        <input type="radio" name="item[destination][callBeforeArrival]" value="false"> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">appointmentRequired:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][appointmentRequired]" value="true" checked> Yes
                                        <input type="radio" name="item[destination][appointmentRequired]" value="false"> No<br>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset name="Freightquote">
                                <legend>Attribute:</legend>
                                <div class="form-group row">
                                    <label class="col-md-4">HasLoadingDock:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][hasLoadingDock]" value="true"> Yes
                                        <input type="radio" name="item[destination][hasLoadingDock]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsConstructionSite:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isConstructionSite]" value="true"> Yes
                                        <input type="radio" name="item[destination][isConstructionSite]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresInsideDelivery:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][requiresInsideDelivery]" value="true"> Yes
                                        <input type="radio" name="item[destination][requiresInsideDelivery]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsTradeShow:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isTradeShow]" value="true"> Yes
                                        <input type="radio" name="item[destination][isTradeShow]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsResidential:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isResidential]" value="true"> Yes
                                        <input type="radio" name="item[destination][isResidential]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">RequiresLiftgate:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][requiresLiftgate]" value="true"> Yes
                                        <input type="radio" name="item[destination][requiresLiftgate]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">HasAppointment:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][hasAppointment]" value="true"> Yes
                                        <input type="radio" name="item[destination][hasAppointment]" value="false" checked> No<br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4">IsLimitedAccess:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="item[destination][isLimitedAccess]" value="true"> Yes
                                        <input type="radio" name="item[destination][isLimitedAccess]" value="false" checked> No<br>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="route" name="Freightquote">
                    <legend class="route-legend">Attribute:</legend>
                    <div class="row">
                        <div class="form-group col-sm-6 no-side-margin">
                            <label class="col-md-4">Quote Type:</label>
                            <div class="col-md-8">
                                <select name="item[quoteType]" class="full-width">
                                    <option value="B2B" selected>B2B</option>
                                    <option value="eBay">eBay</option>
                                    <option value="EnterpriseTMS">EnterpriseTMS</option>
                                    <option value="Freightview">Freightview</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-side-margin">
                            <label class="col-md-4">Service Type:</label>
                            <div class="col-md-8">
                                <select name="item[freightquoteServiceType]" class="full-width" id="serviceType">
                                    <option value="LTL" selected>LTL</option>
                                    <option value="Truckload">Truckload</option>
                                    <option value="Europe">Europe</option>
                                    <option value="Groupage">Groupage</option>
                                    <option value="Haulage">Haulage</option>
                                    <option value="All">All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="tl">
                        <div class="form-group col-sm-6 no-side-margin">
                            <label class="col-md-4">TLDelivery Date:</label>
                            <div class="col-md-8">
                                <input name="item[tlDeliveryDate]" type="date" class="input full-width"></input>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-side-margin">
                            <label class="col-md-4">TLEquipment Type:</label>
                            <div class="col-md-8">
                                <select name="item[tlEquipmentType]" class="full-width">
                                    <option value="Any">Any</option>
                                    <option value="DryVan">DryVan</option>
                                    <option value="Rail">Rail</option>
                                    <option value="Reefer">Reefer</option>
                                    <option value="Flatbed">Flatbed</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-side-margin">
                            <label class="col-md-4">TLEquipment Size:</label>
                            <div class="col-md-8">
                                <select name="item[tlEquipmentSize]" class="full-width">
                                    <option value="Any">Any</option>
                                    <option value="FiftyThreeFootDryVan">FiftyThreeFootDryVan</option>
                                    <option value="FortyEightFootDryVan">FortyEightFootDryVan</option>
                                    <option value="FortyEightFootFlatbedNoTarps">FortyEightFootFlatbedNoTarps</option>
                                    <option value="FortyEightFootFlatbedTarps">FortyEightFootFlatbedTarps</option>
                                    <option value="FortyEightOrFiftyThreeDryVan">FortyEightOrFiftyThreeDryVan</option>
                                    <option value="FiftyThreeFlatbed">FiftyThreeFlatbed</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 no-side-margin">
                            <label class="col-md-4">TLTarpSizeType:</label>
                            <div class="col-md-8">
                                <select name="item[tlTarpSizeType]" class="full-width">
                                    <option value="NoTarpRequired">NoTarpRequired</option>
                                    <option value="FourFeet">FourFeet</option>
                                    <option value="SixFeet">SixFeet</option>
                                    <option value="EightFeet">EightFeet</option>
                                    <option value="Oversized">Oversized</option>
                                    <option value="SmokeTarps">SmokeTarps</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4 no-side-margin">
                            <label class="col-md-6">IsBlind:</label>
                            <div class="col-md-6">
                                <input type="radio" name="item[isBlind]" value="true"> Yes
                                <input type="radio" name="item[isBlind]" value="false" checked> No<br>
                            </div>
                        </div>
                        <div class="form-group col-sm-4 no-side-margin">
                            <label class="col-md-6">SortAndSegregate:</label>
                            <div class="col-md-6">
                                <input type="radio" name="item[sortAndSegregate]" value="true"> Yes
                                <input type="radio" name="item[sortAndSegregate]" value="false" checked> No<br>
                            </div>
                        </div>
                        <div class="form-group col-sm-4 no-side-margin">
                            <label class="col-md-6">UseStackableFlag:</label>
                            <div class="col-md-6">
                                <input type="radio" name="item[useStackableFlag]" value="true"> Yes
                                <input type="radio" name="item[useStackableFlag]" value="false" checked> No<br>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-sm-6">
                        <fieldset  class="route" name="UShip">
                            <legend class="route-legend">TimeFrame:</legend>
                            <div class="form-group row no-side-margin">
                                <label class="col-md-4">Earliest Arrival:</label>
                                <div class="col-md-8">
                                    <input name="item[origin][earliestArrival]" type="date" class="input full-width"></input>
                                </div>
                            </div>
                            <div class="form-group row no-side-margin">
                                <label class="col-md-4">Latest Arrival:</label>
                                <div class="col-md-8">
                                    <input name="item[origin][latestArrival]" type="date" class="input full-width"></input>
                                </div>
                            </div>
                            <div class="form-group row no-side-margin">
                                <label class="col-md-4">timeFrameType:</label>
                                <div class="col-md-8">
                                    <input type="radio" name="item[origin][timeFrameType]" value="on" checked> On
                                    <input type="radio" name="item[origin][timeFrameType]" value="between"> Between
                                    <input type="radio" name="item[origin][timeFrameType]" value="daysdelay"> DaysDelay<br>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-6">
                        <fieldset class="route" name="UShip">
                            <legend class="route-legend">Attribute:</legend>
                            <div class="form-group row">
                                <label class="col-md-5">protectfromFreezing:</label>
                                <div class="col-md-7">
                                    <input type="radio" name="protectfromFreezing" value="true" > Yes
                                    <input type="radio" name="protectfromFreezing" value="false"checked> No<br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">sortandSegregate:</label>
                                <div class="col-md-7">
                                    <input type="radio" name="sortandSegregate" value="true" > Yes
                                    <input type="radio" name="sortandSegregate" value="false" checked> No<br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">blindShipmentCoordination:</label>
                                <div class="col-md-7">
                                    <input type="radio" name="blindShipmentCoordination" value="true" > Yes
                                    <input type="radio" name="blindShipmentCoordination" value="false" checked> No<br>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <fieldset class="route" name="FedEx">
                    <legend class="route-legend">Attribute:</legend>
                    <div class="form-group row">
                        <label class="col-md-4">Dropoff Type:</label>
                        <div class="col-md-8">
                            <select name="item[dropoffType]" class="full-width">
                                <option value="BUSINESS_SERVICE_CENTER">BUSINESS_SERVICE_CENTER</option>
                                <option value="DROP_BOX">DROP_BOX</option>
                                <option value="REGULAR_PICKUP" selected>REGULAR_PICKUP</option>
                                <option value="REQUEST_COURIER">REQUEST_COURIER</option>
                                <option value="STATION">STATION</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Service Type:</label>
                        <div class="col-md-8">
                            <select name="item[serviceType]" class="full-width">
                                <option value="EUROPE_FIRST_INTERNATIONAL_PRIORITY">EUROPE_FIRST_INTERNATIONAL_PRIORITY</option>
                                <option value="FEDEX_1_DAY_FREIGHT">FEDEX_1_DAY_FREIGHT</option>
                                <option value="FEDEX_2_DAY">FEDEX_2_DAY</option>
                                <option value="FEDEX_2_DAY_AM">FEDEX_2_DAY_AM</option>
                                <option value="FEDEX_2_DAY_FREIGHT">FEDEX_2_DAY_FREIGHT</option>
                                <option value="FEDEX_3_DAY_FREIGHT">FEDEX_3_DAY_FREIGHT</option>
                                <option value="FEDEX_DISTANCE_DEFERRED">FEDEX_DISTANCE_DEFERRED</option>
                                <option value="FEDEX_EXPRESS_SAVER">FEDEX_EXPRESS_SAVER</option>
                                <option value="FEDEX_FIRST_FREIGHT">FEDEX_FIRST_FREIGHT</option>
                                <option value="FEDEX_FREIGHT_ECONOMY">FEDEX_FREIGHT_ECONOMY</option>
                                <option value="FEDEX_FREIGHT_PRIORITY">FEDEX_FREIGHT_PRIORITY</option>
                                <option value="FEDEX_GROUND">FEDEX_GROUND</option>
                                <option value="FEDEX_NEXT_DAY_AFTERNOON">FEDEX_NEXT_DAY_AFTERNOON</option>
                                <option value="FEDEX_NEXT_DAY_EARLY_MORNING">FEDEX_NEXT_DAY_EARLY_MORNING</option>
                                <option value="FEDEX_NEXT_DAY_END_OF_DAY">FEDEX_NEXT_DAY_END_OF_DAY</option>
                                <option value="FEDEX_NEXT_DAY_FREIGHT">FEDEX_NEXT_DAY_FREIGHT</option>
                                <option value="FEDEX_NEXT_DAY_MID_MORNING">FEDEX_NEXT_DAY_MID_MORNING</option>
                                <option value="FIRST_OVERNIGHT">FIRST_OVERNIGHT</option>
                                <option value="GROUND_HOME_DELIVERY">GROUND_HOME_DELIVERY</option>
                                <option value="INTERNATIONAL_ECONOMY">INTERNATIONAL_ECONOMY</option>
                                <option value="INTERNATIONAL_ECONOMY_FREIGHT">INTERNATIONAL_ECONOMY_FREIGHT</option>
                                <option value="INTERNATIONAL_FIRST">INTERNATIONAL_FIRST</option>
                                <option value="INTERNATIONAL_PRIORITY" selected>INTERNATIONAL_PRIORITY</option>
                                <option value="INTERNATIONAL_PRIORITY_FREIGHT">INTERNATIONAL_PRIORITY_FREIGHT</option>
                                <option value="PRIORITY_OVERNIGHT">PRIORITY_OVERNIGHT</option>
                                <option value="SAME_DAY">SAME_DAY</option>
                                <option value="SAME_DAY_CITY">SAME_DAY_CITY</option>
                                <option value="SMART_POST">SMART_POST</option>
                                <option value="STANDARD_OVERNIGHT">STANDARD_OVERNIGHT</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Packaging Type:</label>
                        <div class="col-md-8">
                            <select name="item[packagingType]" class="full-width">
                                <option value="FEDEX_10KG_BOX">FEDEX_10KG_BOX</option>
                                <option value="FEDEX_25KG_BOX">FEDEX_25KG_BOX</option>
                                <option value="FEDEX_BOX">FEDEX_BOX</option>
                                <option value="FEDEX_ENVELOPE">FEDEX_ENVELOPE</option>
                                <option value="FEDEX_EXTRA_LARGE_BOX">FEDEX_EXTRA_LARGE_BOX</option>
                                <option value="FEDEX_LARGE_BOX">FEDEX_LARGE_BOX</option>
                                <option value="FEDEX_MEDIUM_BOX">FEDEX_MEDIUM_BOX</option>
                                <option value="FEDEX_PAK">FEDEX_PAK</option>
                                <option value="FEDEX_SMALL_BOX">FEDEX_SMALL_BOX</option>
                                <option value="FEDEX_TUBE">FEDEX_TUBE</option>
                                <option value="YOUR_PACKAGING" selected>YOUR_PACKAGING</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="route">
                    <legend class="route-legend">Items:</legend>
                    <div class="firstItem" id="firstItem">
                        <div class="sendItem" id="sendItem">
                            <div class="row" name="Freightquote">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Class:</label>
                                    <div class="col-md-8">
                                        <!-- <input name="items[0][class]" type="text" class="input full-width"></input> -->
                                        <select name="items[0][class]" class="full-width">
                                            <option value=""></option>
                                            <option value="50">50</option>
                                            <option value="55">55</option>
                                            <option value="60">60</option>
                                            <option value="65">65</option>
                                            <option value="70">70</option>
                                            <option value="77.5">77.5</option>
                                            <option value="85">85</option>
                                            <option value="92.5">92.5</option>
                                            <option value="100">100</option>
                                            <option value="110">110</option>
                                            <option value="125">125</option>
                                            <option value="150">150</option>
                                            <option value="175">175</option>
                                            <option value="200">200</option>
                                            <option value="250">250</option>
                                            <option value="300">300</option>
                                            <option value="400">400</option>
                                            <option value="500">500</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Product Description:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][productDescription]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row" name="UShip">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Commodity:</label>
                                    <div class="col-md-8">
                                        <select name="items[0][Commodity]" class="full-width">
                                            <option value="NewCommercialGoods">NewCommercialGoods</option>
                                            <option value="CarsLightTrucks" selected>CarsLightTrucks</option>
                                            <option value="UsedCommercialGoods">UsedCommercialGoods</option>
                                            <option value="WineLiquorBeerSpirits">WineLiquorBeerSpirits</option>
                                            <option value="NonPerishableFoodsBeverages">NonPerishableFoodsBeverages</option>
                                            <option value="OtherLessthanTruckloadGoods">OtherLessthanTruckloadGoods</option>
                                            <option value="WoodPaperProducts">WoodPaperProducts</option>
                                            <option value="LiquidsGasesChemicals">LiquidsGasesChemicals</option>
                                            <option value="StoneMetalsMinerals">StoneMetalsMinerals</option>
                                            <option value="CommoditiesDryBulk">CommoditiesDryBulk</option>
                                            <option value="GeneralFreight">GeneralFreight</option>
                                            <option value="MixedFreight">MixedFreight</option>
                                            <option value="Utilities">Utilities</option>
                                            <option value="PharmaceuticalProducts">PharmaceuticalProducts</option>
                                            <option value="Fertilizers">Fertilizers</option>
                                            <option value="PlasticsRubber">PlasticsRubber</option>
                                            <option value="TextilesLeather">TextilesLeather</option>
                                            <option value="MiscellaneousManufacturedProducts">MiscellaneousManufacturedProducts</option>
                                            <option value="OtherBusinessIndustrialGoods">OtherBusinessIndustrialGoods</option>
                                            <option value="PaperProducts">PaperProducts</option>
                                            <option value="LogsandOtherWoodintheRough">LogsandOtherWoodintheRough</option>
                                            <option value="WoodProducts">WoodProducts</option>
                                            <option value="PaperorPaperboardArticles">PaperorPaperboardArticles</option>
                                            <option value="PrintedProducts">PrintedProducts</option>
                                            <option value="LiquidsGases">LiquidsGases</option>
                                            <option value="Chemicals">Chemicals</option>
                                            <option value="CrudePetroleumOil">CrudePetroleumOil</option>
                                            <option value="WaterWell">WaterWell</option>
                                            <option value="GasolineandAviationTurbineFuel">GasolineandAviationTurbineFuel</option>
                                            <option value="FuelOils">FuelOils</option>
                                            <option value="ChemicalProductsandPreparationsnec">ChemicalProductsandPreparationsnec</option>
                                            <option value="BuildingMaterials">BuildingMaterials</option>
                                            <option value="MachineryLargeObjects">MachineryLargeObjects</option>
                                            <option value="ElectronicandOtherElectricalEquipmentandComponentsandOfficeEquipment">ElectronicandOtherElectricalEquipmentandComponentsandOfficeEquipment</option>
                                            <option value="PrecisionInstrumentsandApparatus">PrecisionInstrumentsandApparatus</option>
                                            <option value="CoalorCoke">CoalorCoke</option>
                                            <option value="MonumentalorBuildingStone">MonumentalorBuildingStone</option>
                                            <option value="NaturalSands">NaturalSands</option>
                                            <option value="GravelandCrushedStone">GravelandCrushedStone</option>
                                            <option value="NonMetallicMineralsnec">NonMetallicMineralsnec</option>
                                            <option value="MetallicOresandConcentrates">MetallicOresandConcentrates</option>
                                            <option value="CoalandPetroleumProductsnec">CoalandPetroleumProductsnec</option>
                                            <option value="NonMetallicMineralProducts">NonMetallicMineralProducts</option>
                                            <option value="Metalsheetscoilsrolls">Metalsheetscoilsrolls</option>
                                            <option value="BaseMetalinPrimaryorSemiFinishedFormsandinFinishedBasic">BaseMetalinPrimaryorSemiFinishedFormsandinFinishedBasic</option>
                                            <option value="ArticlesofBaseMetal">ArticlesofBaseMetal</option>
                                            <option value="VehicleParts">VehicleParts</option>
                                            <option value="BoatParts">BoatParts</option>
                                            <option value="RefrigeratedFood">RefrigeratedFood</option>
                                            <option value="MeatFishSeafood">MeatFishSeafood</option>
                                            <option value="CerealGrainsincludingseed">CerealGrainsincludingseed</option>
                                            <option value="AnimalFeedProductsofAnimalOrigin">AnimalFeedProductsofAnimalOrigin</option>
                                            <option value="MilledGrainProductsPreparationsandBakeryProducts">MilledGrainProductsPreparationsandBakeryProducts</option>
                                            <option value="Beverages">Beverages</option>
                                            <option value="AlcoholicBeverages">AlcoholicBeverages</option>
                                            <option value="OtherPreparedFoodstuffsandFatsandOils">OtherPreparedFoodstuffsandFatsandOils</option>
                                            <option value="TobaccoProducts">TobaccoProducts</option>
                                            <option value="OtherFoodAgriculture">OtherFoodAgriculture</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">handlingUnit:</label>
                                    <div class="col-md-8">
                                        <select name="items[0][handlingUnit]" class="full-width">
                                            <option value="Boxes">Boxes</option>
                                            <option value="Cartons">Cartons</option>
                                            <option value="Crates">Crates</option>
                                            <option value="Drums">Drums</option>
                                            <option value="Bags">Bags</option>
                                            <option value="Bales">Bales</option>
                                            <option value="Bundles">Bundles</option>
                                            <option value="Cans">Cans</option>
                                            <option value="Carboys">Carboys</option>
                                            <option value="Carpets">Carpets</option>
                                            <option value="Cases">Cases</option>
                                            <option value="Coils">Coils</option>
                                            <option value="Cylinders">Cylinders</option>
                                            <option value="Loose">Loose</option>
                                            <option value="NoPackagingRequired">NoPackagingRequired</option>
                                            <option value="PackagingHelpRequired">PackagingHelpRequired</option>
                                            <option value="Pallets48X40Inches">Pallets48X40Inches</option>
                                            <option value="Pails">Pails</option>
                                            <option value="Reels">Reels</option>
                                            <option value="Rolls">Rolls</option>
                                            <option value="TubesPipes">TubesPipes</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" name="Freightquote">
                                <div class="form-group col-sm-4 no-side-margin">
                                    <div class="col-md-12">
                                        <label>Commodity Type:</label>
                                        <select name="items[0][commodityType]" class="full-width">
                                            <option value="GeneralMerchandise">GeneralMerchandise</option>
                                            <option value="Machinery">Machinery</option>
                                            <option value="HouseholdGoods">HouseholdGoods</option>
                                            <option value="FragileGoods">FragileGoods</option>
                                            <option value="ComputerHardware">ComputerHardware</option>
                                            <option value="BottledProducts">BottledProducts</option>
                                            <option value="BottleBeverages">BottleBeverages</option>
                                            <option value="NonPerishableFood">NonPerishableFood</option>
                                            <option value="SteelSheet">SteelSheet</option>
                                            <option value="BrandedGoods">BrandedGoods</option>
                                            <option value="PrecisionInstruments">PrecisionInstruments</option>
                                            <option value="ChemicalsHazardous">ChemicalsHazardous</option>
                                            <option value="FineArt">FineArt</option>
                                            <option value="Automobiles">Automobiles</option>
                                            <option value="CellPhones">CellPhones</option>
                                            <option value="NewMachinery">NewMachinery</option>
                                            <option value="UsedMachinery">UsedMachinery</option>
                                            <option value="HotTubs">HotTubs</option>
                                            <option value="Alcohol">Alcohol</option>
                                            <option value="ApparelShoes">ApparelShoes</option>
                                            <option value="Appliances">Appliances</option>
                                            <option value="AutomobileParts">AutomobileParts</option>
                                            <option value="ComputerEquipment">ComputerEquipment</option>
                                            <option value="ConsumerCareProductsPerfume">ConsumerCareProductsPerfume</option>
                                            <option value="ConsumerElectronicsIncludingCellPhonesAndTelevisions">ConsumerElectronicsIncludingCellPhonesAndTelevisions</option>
                                            <option value="FoodAndBeverages">FoodAndBeverages</option>
                                            <option value="GeneralMerch">GeneralMerch</option>
                                            <option value="Metals">Metals</option>
                                            <option value="Pharmaceuticals">Pharmaceuticals</option>
                                            <option value="Tobacco">Tobacco</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 no-side-margin">
                                    <div class="col-md-12">
                                        <label>Package Type:</label>
                                        <select name="items[0][packageType]" class="full-width">
                                            <option value="Unknown">Unknown</option>
                                            <option value="Pallets_48x40">Pallets_48x40</option>
                                            <option value="Pallets_other">Pallets_other</option>
                                            <option value="Bags">Bags</option>
                                            <option value="Bales">Bales</option>
                                            <option value="Boxes" selected>Boxes</option>
                                            <option value="Bundles">Bundles</option>
                                            <option value="Carpets">Carpets</option>
                                            <option value="Coils">Coils</option>
                                            <option value="Crates">Crates</option>
                                            <option value="Cylinders">Cylinders</option>
                                            <option value="Drums">Drums</option>
                                            <option value="Pails">Pails</option>
                                            <option value="Reels">Reels</option>
                                            <option value="Rolls">Rolls</option>
                                            <option value="TubesPipes">TubesPipes</option>
                                            <option value="Motorcycle">Motorcycle</option>
                                            <option value="ATV">ATV</option>
                                            <option value="Pallets_120x120">Pallets_120x120</option>
                                            <option value="Pallets_120x100">Pallets_120x100</option>
                                            <option value="Pallets_120x80">Pallets_120x80</option>
                                            <option value="Pallets_europe">Pallets_europe</option>
                                            <option value="Pallets_48x48">Pallets_48x48</option>
                                            <option value="Pallets_60x48">Pallets_60x48</option>
                                            <option value="SlipSheets">SlipSheets</option>
                                            <option value="Unit">Unit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 no-side-margin">
                                    <div class="col-md-12">
                                        <label>Content Type:</label>
                                        <select name="items[0][contentType]" class="full-width">
                                            <option value="NewCommercialGoods">NewCommercialGoods</option>
                                            <option value="UsedCommercialGoods">UsedCommercialGoods</option>
                                            <option value="HouseholdGoods">HouseholdGoods</option>
                                            <option value="FragileGoods">FragileGoods</option>
                                            <option value="Automobile">Automobile</option>
                                            <option value="Motorcycle">Motorcycle</option>
                                            <option value="AutoOrMotorcycle">AutoOrMotorcycle</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">unitCount:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][unitCount]" type="text" class="input full-width" value=1></input>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Length:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][lengthInMeters]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Width:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][widthInMeters]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">Height:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][heightInMeters]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">LBS:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][lbs]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin" name="UShip">
                                    <label class="col-md-4">freightClass:</label>
                                    <div class="col-md-8">
                                        <input name="items[0][freightClass]" type="text" class="input full-width"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="row" name="StackAndHazardous">
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">stackable:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="items[0][stackable]" value="true" checked> Yes
                                        <input type="radio" name="items[0][stackable]" value="false"> No<br>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 no-side-margin">
                                    <label class="col-md-4">hazardous:</label>
                                    <div class="col-md-8">
                                        <input type="radio" name="items[0][hazardous]" value="true"> Yes
                                        <input type="radio" name="items[0][hazardous]" value="false" checked> No<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addItem"><i class="glyphicon glyphicon-plus"></i>add new Item</button>
                </fieldset>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="submit" value="Send" id="submit" class="col-sm-3 col-md-2 col-lg-2 col-xs-4 pull-right" style="margin-top: 10px;">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    jQuery(document).ready(function($) {

        initUI();
        function initUI() {
            $('fieldset[name=FedEx]').hide();
            $('fieldset[name=Freightquote]').hide();
            $('div[name=Freightquote]').hide();
            $('#tl').hide();
        }

        var i=0;
        $('#addItem').click(function(e) {
            i++;
            var newdiv = $("#firstItem div.sendItem").eq(0).clone();
            newdiv.find('input').each(function(){
                this.name = this.name.replace('[0]', '['+i+']');
            });
            newdiv.find('select').each(function(){
                this.name = this.name.replace('[0]', '['+i+']');
            })
            $('#firstItem').append(newdiv);
        });

        $('input[type=radio][name=thirdParty]').change(function() {
            $('fieldset[name=UShip]').hide();
            $('div[name=UShip]').hide();
            $('fieldset[name=FedEx]').hide();
            $('fieldset[name=Freightquote]').hide();
            $('div[name=Freightquote]').hide();
            $('div[name=StackAndHazardous]').hide();
            if (this.value == 'UShip') {
                $('fieldset[name=UShip]').show();
                $('div[name=UShip]').show();
                $('div[name=StackAndHazardous]').show();
            } else if (this.value == 'FedEx') {
                $('fieldset[name=FedEx]').show();
            } else if (this.value == 'Freightquote') {
                $('fieldset[name=Freightquote]').show();
                $('div[name=Freightquote]').show();
                $('div[name=StackAndHazardous]').show();
            } else {
            }
        });
        $('#serviceType').on('change', function() {
            if(this.value == 'Truckload') {
                $('#tl').show();
            } else {
                $('#tl').hide();
            }
        });
    });
</script>
