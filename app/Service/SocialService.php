<?php
namespace App\Service;
use App\User;
use Illuminate\Support\Facades\Hash;


class SocialService
{
    public function saveSocialData($user){

      $email = $user->getNickname();
      $name = $user->getName();
      $avatar = $user->getAvatar();

      $password = Hash::make('12345678');
      $data = ['email' => $email, 'password' => $password, 'name' => $name, 'avatar' => $avatar];
      $u = User::where('email', $email)->first();
      if ($u) {
          return $u->fill(['name' => $name, 'avatar' => $avatar]);
      }
      return User::create($data);
    }
}
