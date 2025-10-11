<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SocialAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    protected $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    /**
     * Redirect to social provider
     */
    public function redirectToProvider($provider)
    {
        try {
            $this->validateProvider($provider);

            return response()->json([
                'redirect_url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Invalid provider or configuration error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function handleProviderCallback($provider, Request $request)
    {
        try {
            $this->validateProvider($provider);

            if (!$request->has('code')) {
                return response()->json([
                    'error' => 'Authorization code is required'
                ], 400);
            }

            $code = $request->input('code');
            if ($provider == 'google') {
                $code = urldecode($code);
                $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                    'code' => $code,
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
                    'grant_type' => 'authorization_code',
                ]);
                if ($response->successful()) {
                    $tokenData = $response->json();
                    $accessToken = $tokenData['access_token'];

                    try {
                        $userResponse = Http::withToken($accessToken)
                            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

                        if (!$userResponse->successful()) {
                            throw new \Exception('Failed to fetch user info from Google');
                        }

                        $userData = $userResponse->json();

                        $user = $this->socialAuthService->handleSocialAuth($provider, $userData);
                        $token = $this->socialAuthService->generateTokenResponse($user);

                        return response()->json([
                            'success' => true,
                            'data' => $token
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error processing user data: ' . $e->getMessage());
                        return response()->json([
                            'error' => 'Failed to process user data',
                            'message' => $e->getMessage()
                        ], 500);
                    }
                }
            }

            if ($provider == 'facebook') {
             $socialUer = Socialite::driver($provider)->stateless()->user();
            
             $user = $this->socialAuthService->handleSocialAuth($provider, $socialUer);
            
             $repsonseToken = $this->socialAuthService->generateTokenResponse($user);

             return response()->json([
                'status' => true ,
                'user' =>  $repsonseToken
             ]);
            }
        } catch (\Exception $e) {
            Log::error('Social auth error: ' . $e->getMessage(), [
                'exception' => $e,
                'provider' => $provider ?? 'unknown'
            ]);

            return response()->json([
                'error' => 'Authentication failed',
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Logout (revoke current token)
     */
    public function logout(Request $request)
    {
        if ($token = $request->user()->currentAccessToken()) {
            $token->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Logout from all devices (revoke all tokens)
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out from all devices'
        ]);
    }

    /**
     * Get user's active tokens
     */
    public function tokens(Request $request)
    {
        $tokens = $request->user()->tokens()->select('id', 'name', 'abilities', 'last_used_at', 'created_at')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'tokens' => $tokens,
                'total' => $tokens->count()
            ]
        ]);
    }

    /**
     * Revoke specific token
     */
    public function revokeToken(Request $request)
    {
        $request->validate([
            'token_id' => 'required|integer|exists:personal_access_tokens,id'
        ]);

        $user = $request->user();
        $token = $user->tokens()->find($request->token_id);

        if (!$token) {
            return response()->json([
                'error' => 'Token not found'
            ], 404);
        }

        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'Token revoked successfully'
        ]);
    }

    /**
     * Unlink social account
     */
    public function unlinkSocialAccount(Request $request)
    {
        $user = $request->user();

        if (!$user->isSocialUser()) {
            return response()->json([
                'error' => 'No social account linked'
            ], 400);
        }

        // Don't allow unlinking if user has no password (social-only account)
        if (is_null($user->password)) {
            return response()->json([
                'error' => 'Cannot unlink social account. Please set a password first.'
            ], 400);
        }

        $user->update([
            'provider' => null,
            'provider_id' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Social account unlinked successfully'
        ]);
    }

    private function validateProvider($provider)
    {
        $allowedProviders = ['google', 'facebook'];

        if (!in_array($provider, $allowedProviders)) {
            throw new Exception('Provider not supported');
        }
    }
}
