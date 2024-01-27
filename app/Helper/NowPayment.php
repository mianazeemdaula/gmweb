<?php
namespace App\Helper;

use Illuminate\Support\Facades\Http;

class NowPayment{
    private $apikey;
    private $url;
    private $client = null;

    public function __construct()
    {
        $this->apikey = env('NOWPAYMENTS_API_KEY');
        $this->url = env('NOWPAYMENTS_URL');
        $this->client = Http::withHeaders([
            'x-api-key' => $this->apikey,
            'Content-Type' => 'application/json',
        ]);
    }

    public function currencies(){
        $response = $this->client->get($this->url.'/currencies?fixed_rate=true');
        return $response->json();
    }

    public function payment($data){
        $response = $this->client->post($this->url.'/payment', $data);
        return $response->json();
    }

    public function getPayment($id){
        $response = $this->client->get($this->url."/payment/$id");
        return $response->json();
    }

    public function getPayments(){
        $response = $this->client->get($this->url."/payments");
        return $response->json();
    }

    public function getBalance(){
        $response = $this->client->get($this->url."/balance");
        return $response->json();
    }

    public function payout($request){
        // add more header to client
        $authClient = Http::withHeaders([
            'Content-Type' => 'application/json',
        ]);
        $authresponse =  $authClient->post($this->url."/auth", [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if($authresponse->status() != 200){
            return $authresponse->json();
        }
        $token = $authresponse->json()['token'];
        $payoutClient = Http::withHeaders([
            'x-api-key' => $this->apikey,
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $token",
        ]);
        $response = $payoutClient->post($this->url."/payout", [
            'ipn_callback_url' => url('/api/nowpayment/payoutipn'),
            'withdrawals' => [
                [
                    'amount' => $request->amount,
                    'currency' => $request->currency,
                    'address' => $request->address,
                    'ipn_callback_url' => url('/api/nowpayment/payoutipn'),
                ]
            ]
        ]);
        return $response->json();
    }

    public function verifyPayout($request){
        // add more header to client
        $authClient = Http::withHeaders([
            'Content-Type' => 'application/json',
        ]);
        $authresponse =  $authClient->post($this->url."/auth", [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if($authresponse->status() != 200){
            return $authresponse->json();
        }
        $token = $authresponse->json()['token'];
        $payoutClient = Http::withHeaders([
            'x-api-key' => $this->apikey,
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $token",
        ]);
        $batchId = $request->batch;
        $response = $payoutClient->post($this->url."/$batchId/verify", [
            'verification_code' => $request->mail_code,
        ]);
        return $response->json();
    }
}