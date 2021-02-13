<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Service\SocialService;

class SocialController extends Controller
{
    public function index(){
      return Socialite::driver('vkontakte')->redirect();
    }

    public function callback(){
      $user = Socialite::driver('vkontakte')->user();
      $objSocial = new SocialService();
      if($user = $objSocial->saveSocialData($user)){
          \Auth::login($user);
          return redirect()->route('welcome');
      }
      return back();
    }
}
