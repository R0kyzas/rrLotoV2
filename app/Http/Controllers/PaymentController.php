<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Omnipay\Common\GatewayFactory;
use Omnipay\Omnipay;
use WebToPay;

class PaymentController extends Controller
{
    // public function initiatePayment($orderId)
    // {
    //     $bankUrl = WebToPay::getPaymentUrl() . "?data=";
    //     $request = WebToPay::redirectToPayment([
    //         'projectid'     => "239986",
    //         'sign_password' => "fd5956c1f89f6cd9a4a52f523c05cbfc",
    //         'orderid'       => $orderId,
    //         'amount'        => 100,
    //         'currency'      => 'EUR',  
    //         'accepturl' => 'http://localhost:8000/paysera/notification',
    //         'cancelurl' => 'http://localhost:8000/cancel',
    //         'callbackurl' => 'http://localhost:8000/paysera/notification',
    //         'test' => 1,
    //     ]);

    //     $generatedPaymentUrl = $bankUrl . base64_encode($request['data']) . "&sign=" . $request['sign'];
    //     // dd($request['data'], ' ',$request['sign'] );
    //     dd($generatedPaymentUrl);
    //     return redirect($generatedPaymentUrl);
    // }

    // public function handleNotification(Request $request)
    // {
    //     try {
    //         $response = WebToPay::validateAndParseData(
    //             $request->all(),
    //             239986,
    //             "fd5956c1f89f6cd9a4a52f523c05cbfc",
    //         );
         
    //         if ($response['status'] === '1' || $response['status'] === '3') {
    //             //@ToDo: Validate payment amount and currency, example provided in isPaymentValid method.
    //             //@ToDo: Validate order status by $response['orderid']. If it is not already approved, approve it.
         
    //             echo 'OK';
    //         } else {
    //             echo 'Payment was not successful';
    //         }
    //     } catch (\Throwable $exception) {
    //         echo get_class($exception) . ':' . $exception->getMessage();
    //     }
    // }
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('Paysera');
        $this->gateway->setProjectId('239986');
        $this->gateway->setPassword('fd5956c1f89f6cd9a4a52f523c05cbfc');
    }

    public function initiatePayment($orderId)
    {
        $response = $this->gateway->purchase(
            [
                'language' => 'ENG',
                'transactionId' => $orderId,
                'amount' => '10.00',
                'currency' => 'EUR',
                'returnUrl' => secure_url("/profile"),
                'cancelUrl' => secure_url("/cancel"),
                'notifyUrl' => secure_url("/paysera/notification"),
            ]
        )->send();

        if ($response->isRedirect()) {
            $response->redirect();
        } else {
            echo $response->getMessage();
        }
    }

    public function handleNotification(Request $request)
    {
        try {
                    $response = WebToPay::validateAndParseData(
                        $request->all(),
                        239986,
                        "fd5956c1f89f6cd9a4a52f523c05cbfc",
                    );
                 
                    // dd($response['orderid']);
                    if ($response['status'] === '1' || $response['status'] === '3') {
                        //@ToDo: Validate payment amount and currency, example provided in isPaymentValid method.
                        //@ToDo: Validate order status by $response['orderid']. If it is not already approved, approve it.
                        $order = Order::where("id", "=", $response['orderid'])->first();
                        $order->active = 1;
                        $order->save();
                        echo 'OK';
                    } else {
                        echo 'Payment was not successful';
                    }
                } catch (\Throwable $exception) {
                    echo get_class($exception) . ':' . $exception->getMessage();
                }
    }
}
