<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use WebToPay;

class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('Paysera');
        $this->gateway->setProjectId('239986');
        $this->gateway->setPassword('fd5956c1f89f6cd9a4a52f523c05cbfc');
    }

    public function initiatePayment($orderNr, $amount)
    {
        $response = $this->gateway->purchase(
            [
                'language' => 'ENG',
                'transactionId' => $orderNr,
                'amount' => $amount / 100,
                'currency' => 'EUR',
                'returnUrl' => url("/profile?status=success"),
                'cancelUrl' => url("/profile/cancel/$orderNr"),
                'notifyUrl' => url("/paysera/notification"),
                'testMode' => false,
            ]
        )->send();

        if ($response->isRedirect()) {
            $response->redirect();
        } else {
            echo $response->getMessage();
        }
    }

    public function cancelOrder($orderNr)
    {
        $order = Order::where('order_nr', '=', $orderNr)->first();

        if($order)
        {
            $order->active = 2;
            $order->save();

            return redirect()->route('profile.view')->with('error', 'Payment canceled');
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
                 
            if ($response['status'] === '1' || $response['status'] === '3') {
                $order = Order::where('order_nr', "=", $response['orderid'])->first(); 
                
                if($order){
                    $isPaymentValid = $this->isPaymentValid($order->toArray(), $response);

                    if($isPaymentValid){
                        $order->active = 1;
                        $order->save();

                        echo 'OK';
                    }
                }
            } else {
                echo 'Payment was not successful';
            }
        } catch (\Throwable $exception) {
            echo get_class($exception) . ':' . $exception->getMessage();
        }
    }

    function isPaymentValid(array $order, array $response): bool
    {
        if (array_key_exists('payamount', $response) === false) {
            if (intval($order['final_price']) !== intval($response['amount'])) {
                throw new \Exception('Wrong payment amount');
            }
        } else {
            if (intval($order['final_price']) !== intval($response['payamount'])) {
                throw new \Exception('Wrong payment amount');
            }
        }
    
        return true;
    }
}
