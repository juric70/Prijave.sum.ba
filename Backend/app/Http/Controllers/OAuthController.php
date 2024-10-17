<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Str;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['redirectToProvider', 'handleProviderCallback']);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToProvider(Request $request): RedirectResponse
    {
        Session::put('url.intended', $request->query('redirect_to'));

        return Socialite::driver('eduid')->redirect();
    }

    public function handleProviderCallback()
    {
        $user_socialite = Socialite::driver('eduid')->stateless()->user();

    
        $laravelUser = User::updateOrCreate([
            'uid' => $user_socialite->uid,
            'branch' => $user_socialite->branch
        ], [
            'name' => $user_socialite->first_name,
            'lastname' => $user_socialite->last_name,
            'email' => $user_socialite->email,
            'password' => 'aaaaaaaaaa',
            'username' => $user_socialite->email
        ]);//ako trebadne dodati jos neka polja

        Auth::login($laravelUser);

        Log::info('User logged: ' . $laravelUser->uid);
        $intended_url = Session::get('url.intended', null);

        if ($intended_url !== null)
            return redirect($intended_url);

        return redirect(route('user'));
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();
        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::save();

        $logoutUrl = config('services.eduid.logout_url');

//        $intended_url = Session::get('url.intended', $request->redirect_to);
        $intended_url = $request->redirect_to;

        if ($intended_url)
            $logoutUrl .= '?redirect_to=' . $intended_url;

        return redirect($logoutUrl);
    }
}
