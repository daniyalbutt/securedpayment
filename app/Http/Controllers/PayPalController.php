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
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment.success'),
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
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
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