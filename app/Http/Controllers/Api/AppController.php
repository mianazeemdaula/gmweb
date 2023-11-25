<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function data(){
        $data['app_version'] = '1.0.0';
        $data['app_name'] = 'Crypto MLM';
        $data['app_logo'] = asset('images/logo.png');
        $data['app_description'] = 'Crypto MLM is a web application that allows you to manage your mlm business easily.';
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
