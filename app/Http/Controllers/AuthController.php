<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\SocialiteManager;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $auth;

    /**
     * @var SocialiteManager
     */
    private $socialite;

    /**
     * AuthController constructor.
     * @param AuthService $auth
     * @param Socialite $socialite
     */
    public function __construct(AuthService $auth, Socialite $socialite)
    {
        $this->auth = $auth;
        $this->socialite = $socialite;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->auth->login($credentials);
        if (!$token) {
            abort(403);
        }

        return response()->json(['token' => $token]);
    }

    public function social($name)
    {
        if (!config("services.$name")) {
            abort(404);
        }

        return $this->socialite->with($name)->stateless()->redirect();
    }

    public function socialCallback($name)
    {
        if (!config("services.$name")) {
            abort(404);
        }

        $user = $this->socialite->with($name)->stateless()->user();
        if (!$user) {
            abort(403);
        }

        $token = $this->auth->socialLogin($name, $user);
        if (!$token) {
            abort(403);
        }

        return response()->json(['token' => $token]);
    }
}
