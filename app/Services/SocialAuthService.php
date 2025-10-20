<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Role;

class SocialAuthService
{
    public function handleSocialAuth($provider, $socialUser)
    {

        $provider_id = $provider == 'google' ? $socialUser['sub'] :  $socialUser->id ;
        $avatar = $provider == 'google' ? $socialUser['picture'] : $socialUser->avatar;

        $user = User::where('provider', $provider)
                   ->where('provider_id', $provider_id)
                   ->first();

        if ($user) {
            return $user;
        }

        $existingUser = User::where('email', $socialUser['email'])->first();

        if ($existingUser) {
            $existingUser->update([
                'provider' => $provider,
                'provider_id' => $provider_id,
                'avatar' => $avatar,
            ]);

            return $existingUser;
        }

        if($provider == 'google'){
            $role = Role::where('name', 'student')->first();
            if(!$role){
                $role = Role::create(['name' => 'student', 'guard_name' => 'web']);
            }
            $user =  User::create([
                'first_name' => $socialUser['given_name'] ?: 'User',
                'second_name' => $socialUser['family_name'] ?: 'User',
                'email' => $socialUser['email'] ?: 'Useremail',
                'provider' => $provider,
                'provider_id' => $provider_id,
                'avatar' => $socialUser['picture'] ?: 'User',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(16)), 
            ]);
            $user->assignRole($role);
            return $user;
        }elseif($provider == 'facebook'){
            $role = Role::where('name', 'student')->first();
            if(!$role){
                $role = Role::create(['name' => 'student', 'guard_name' => 'web']);
            }
            $user = User::create([
                'first_name' => $socialUser->name ?: 'User',
                'second_name' => $socialUser->name ?: 'User',
                'email' => $socialUser->email ?: 'Useremail',
                'provider' => $provider,
                'provider_id' => $socialUser->id,
                'avatar' => $socialUser->avatar ?: 'User',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(16)), 
            ]);
            $user->assignRole($role);
            return $user;
        };


    }

    public function generateTokenResponse($user, $tokenName = 'api-token', $abilities = ['*'])
    {
        $token = $user->createToken($tokenName, $abilities);

        return [
            'token' => $token->plainTextToken,
            'user' => new UserResource($user)
        ];
    }

    public function getUserProfile($user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'second_name' => $user->second_name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'provider' => $user->provider,
            'email_verified' => !is_null($user->email_verified_at),
            'is_social_user' => $user->isSocialUser(),
            'active_tokens' => $user->getActiveTokensCount(),
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}
