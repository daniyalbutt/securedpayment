<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;  
use App\Models\Payment;

class PayPalController extends Controller{
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $paypal_config;

    public function __construct()
    {

    }

    public function index(){
        return view('paypal');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function payment(Request $request){
        $id = $request->id;
        $data = Payment::find($id);
        if ($data->status == 0) {
            $set_sandbox = $data->merchants->sandbox == 0 ? 'live' : 'sandbox';
            $this->paypal_config = [
                'mode'    => $set_sandbox,
                $set_sandbox => [
                    'client_id'         => $data->merchants->public_key,
                    'client_secret'     => $data->merchants->private_key,
                    'app_id'            => 'PAYPAL_LIVE_APP_ID',
                ],
                'payment_action' => 'Sale',
                'currency'       => 'USD',
                'notify_url'     => '',
                'locale'         => 'en_US',
                'validate_ssl'   => true,
            ];
            $provider = new PayPalClient;
            $provider->setApiCredentials($this->paypal_config);
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment.success', ['id' => $data->id]),
                    "cancel_url" => route('pay', ['id' => $data->unique_id]),
                ],
                "purchase_units" => [
                    [
                        "reference_id" => $data->id,
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $data->price
                        ],
                        'custom_id' => json_encode($request->input()),
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect()->route('pay', ['id' => $data->unique_id])->with('error', 'Something went wrong.');
            } else {
                return redirect()->route('pay', ['id' => $data->unique_id])->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function paymentCancel(){
        return redirect()->route('paypal')->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function paymentSuccess(Request $request){
        $get_payment = Payment::find($request->id);
        $set_sandbox = $get_payment->merchants->sandbox == 0 ? 'live' : 'sandbox';
        $set_paypal_config = [
            'mode'    => $set_sandbox,
            $set_sandbox => [
                'client_id'         => $get_payment->merchants->public_key,
                'client_secret'     => $get_payment->merchants->private_key,
                'app_id'            => 'PAYPAL_LIVE_APP_ID',
            ],
            'payment_action' => 'Sale',
            'currency'       => 'USD',
            'notify_url'     => '',
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];
        $provider = new PayPalClient;
        $provider->setApiCredentials($set_paypal_config);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        $custom_id = $response['purchase_units'][0]['payments']['captures'][0]['custom_id'];
        $referenceId = $response['purchase_units'][0]['reference_id'];
        $data = Payment::find($referenceId);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $data->update([
                'status'=> 2,
                'return_response' => json_encode($response),
                'payment_data' => $custom_id
            ]);
            return redirect()->route('success.payment', ['id' => $referenceId])->with('success', 'Transaction complete.');
        } else {
            $data->update([
                'status'=> 1,
                'return_response' => json_encode($response),
                'payment_data' => $custom_id
            ]);
            return redirect()->route('declined.payment', ['id' => $referenceId])->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

}