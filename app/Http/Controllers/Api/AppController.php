<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AppController extends Controller
{
    public function fetch(){
        $url =  "https://v6.exchangerate-api.com/v6/ace3e1175f6a43afd15d031f/latest/USD";
        $response = Http::get($url);
        $data = $response->json();
        $currencies = $data['conversion_rates'];
        foreach($currencies as $key => $value){
            $currency = Currency::where('name',$key)->first();
            if($currency){
                $currency->rate = $value;
                $currency->save();
            }else{
                $currency = new Currency();
                $currency->name = $key;
                $currency->rate = $value;
                $currency->save();
            }
        }
        return true;
    }
    public function data(){
        $lastRecord = Currency::latest()->first();
        $now = Carbon::now();
        if($lastRecord){
            $lastRecordDate = Carbon::parse($lastRecord->created_at);
            $diff = $now->diffInMinutes($lastRecordDate);
            if($diff > 60){
                $this->fetch();
            }
        }else{
            $this->fetch();
        }
        $data['app_version'] = '1.0.5';
        $data['app_name'] = 'Crypto MLM';
        $data['app_logo'] = asset('images/logo.png');
        $data['currencies'] = Currency::whereIn('name',['PKR','USD','AED','ZAR','SAR'])->get();
        $data['app_description'] = 'Crypto MLM is a web application that allows you to manage your mlm business easily.';
        $data['coins'] = ["USDTBSC", "USDTTRC20", "USDTDOT", "USDTERC20", "USDTMATIC", "USDTSOL", "USDTALGO", "TRX"];
        return response()->json($data);
    }

    public function levels(){
        $levels = \App\Models\Level::where('active', true)
        ->orderBy('min_price','asc')->get();
        return response()->json($levels);
    }

    public function paymentMethods(){
        $paymentMethods = \App\Models\PaymentMethod::where('status', 'active')
        ->orderBy('name','asc')->get();
        return response()->json($paymentMethods);
    }

    public function faqCategories(){
        $faqCategories = \App\Models\FaqCategory::whereHas('faqs')
        ->orderBy('name','asc')->get();
        return response()->json($faqCategories);
    }

    public function faqs(){
        $faqs = \App\Models\Faq::where('active', true)
        ->orderBy('order','asc')->get();
        return response()->json($faqs);
    }

    public function contactUs(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        $data = $request->all();
        return response()->json(['message' => 'Your message has been sent successfully.']);
    }

    public function offers(){
        $offers = \App\Models\Offer::where('active', true)
        ->orderBy('end_date','desc')->get();
        return response()->json($offers);
    }
}
