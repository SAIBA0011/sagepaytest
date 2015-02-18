<?php namespace App\Http\Controllers;

use \dwmsw\sagepay as pay;
use GuzzleHttp\Client;

class WelcomeController extends Controller {


	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Create instance of Direct
		$sagepay = new pay\Direct();
		$basket = new pay\Basket();
		$basket->addItem(new pay\Item('Test Item', 30.00, 6, 1));
		$basket->addItem(new pay\Item('Test Item Two', 30.00, 6, 2));
		$sagepay->setBasket($basket);

		$sagepay->setConnectionMode('test');
		$sagepay->setVendorName('protxross');
		$sagepay->setCurrency('GBP');
		$sagepay->setApplyAvsCv2(1);
		$sagepay->setApply3dSecure(0);
		$sagepay->setGiftAid(0);

		$vendorTxCode = md5(rand(1, 1000));

		// TX Specific bits
		$sagepay->setVendorTxCode($vendorTxCode);
		$sagepay->setDescription('Test Payment');
		$sagepay->setCustomerEmail('daryll@digitalwebmedia.co.uk');

		// Set up addresses
		$BillingAddress = new pay\Address();
		$BillingAddress->setName('Daryll', 'Doyle');
		$BillingAddress->setPhone('46554789658');
		$BillingAddress->setAddress('88', 'Test Address', 'Town', 'GB', '412');

		// Set Addresses into the class
		$sagepay->setBillingAddress($BillingAddress);
		// Delivery Address can be a different instance of address if needed
		$sagepay->setDeliveryAddress($BillingAddress);

		// New card instance
		$card = new pay\Card();
		// Card details
		$card->setCardHolder('Mr D Doyle');
		$card->setCardType('VISA');
		$card->setCardNumber('4929000000006');
		$card->setStartDate(false);
		$card->setExpiryDate('1216');
		$card->setCV2('123');

		$sagepay->setCard($card);

		$output = $sagepay->register('PAYMENT');

		// Store MD and PaRes in Database with Pending Purchase ( if 3d secured transaction )

		$data = [
			'ACSURL' => $output['ACSURL'],
			'MD' => $output['MD'],
			'PAReq' => $output['PAReq']
		];

		return view('home', compact('data'));

	}

}
