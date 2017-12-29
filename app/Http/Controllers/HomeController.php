<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Contracts\ShippingServiceInterface;

class HomeController extends Controller
{

    protected $shippingService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShippingServiceInterface $shippingService)
    {
        $this->middleware('auth');
        $this->shippingService = $shippingService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function sendjson(Request $request)
    {
        $count = $request->get('count');
        // var_dump($request->get('count')); exit;

        $rules = $this->shippingService->getRule($count);
        $this->validate($request,$rules);
        $shippingData = $this->shippingService->returnData($request);
        $result = $this->shippingService->call($shippingData);
        return $result;
    }
}
