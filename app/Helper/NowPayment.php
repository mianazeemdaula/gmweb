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
        $this->url = env('NOWPAYMENTS_ENV') == "live" ?  env('NOWPAYMENTS_URL') : env('NOWPAYMENTS_SANDBOX_URL');
        $this->client = Http::withHeaders([
            'x-api-key' => $this->apikey,
            'Content-Type' => 'application/json',
        ]);
    }

    public function currencies(){;
        $response = $this->client->get($this->url.'/currencies?fixed_rate=true');
        return $response->json();
    }

    public function payment($data){
        $response = $this->client->post($this->url.'/payment', $data);
        return $response->json();
    }
}