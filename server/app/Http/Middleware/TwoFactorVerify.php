<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class TwoFactorVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if($user->token_2fa_expiry > \Carbon\Carbon::now()){
            return $next($request);
        }

        $user->token_2fa = mt_rand(10000,99999);
        $user->save();
        // This is the twilio way
        // send message to user here
        $this->sendSMS('Your confirmation message is: ' . $user->token_2fa, $user->phone);
        //Twilio::message($user->phone_number, 'Two Factor Code: ' . $user->token_2fa);
        // If you want to use email instead just
        // send an email to the user here ..
        return redirect('/2fa');
    }

    function sendSMS($msg, $number) {

        $quick_buy = "http://www.quickbuysms.com/index.php?option=com_spc&" .
        "comm=spc_api&username=ogoo80&password=@ughonu247&sender=" .
        "DataSecur&recipient=" . $number . "&message=" .
         urlencode($msg);

         $client = new \GuzzleHttp\Client;

        $response = $client->get($quick_buy);

         // You need to parse the response body
         // This will parse it into an array
         //$response = json_decode($response->getBody(), true);


    }

}
