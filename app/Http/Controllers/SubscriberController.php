<?php

namespace App\Http\Controllers;

use App\Notifications\VerificationCode;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Notification;

class SubscriberController extends Controller
{
    public function subscribe(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $token=random_int(100000, 999999);
        $subscriber=Subscriber::where('email', $request->email)->first();
        if(!$subscriber) {
            $subscriber = Subscriber::create([
                'email' => $request->email,
                'token' => $token
            ]);
        }
        else{
            $subscriber->token=$token;
            $subscriber->save();
        }
            $token_data = [
                'token' => $token
            ];
        Notification::send($subscriber, new VerificationCode($token_data));

        return response()->json();
    }

    public function verify(Request $request){
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
        ]);
        $subscriber=Subscriber::where('email', $request->email)->first();
        if($subscriber->token===$request->token){
            $subscriber->verified=true;
            $subscriber->token=null;
            $subscriber->save();

            return response()->json('Success');
        }

        return response()->json('Error');
    }

    public function get_subscribers(){
        $subscribers=Subscriber::get()->all();
        return response()->json($subscribers);
    }

    public function disable_subscriber(Request $request){
        $subscriber=Subscriber::find($request->id);
        if($subscriber->disabled===0){
            $subscriber->disabled = 1;
        }
        else{
            $subscriber->disabled = 0;
        }
        $subscriber->save();
        $subscribers=Subscriber::get()->all();
        return response()->json($subscribers);
    }
}

