<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Responses\BaseResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * User Login
     *
     * @param LoginRequest $request as Array
     * @return object
     */
    public function login(LoginRequest $request): object
    {
        if (auth()->attempt($request->validated())){
            $token = auth()->user()->createToken(config('news.api_token_secret'))->plainTextToken;
            return new BaseResponse(STATUSCODEOK, __('auth.sign_in_success'), [
                'user'         => auth()->user(),
                'access_token' => $token
            ]);
        }
        return new BaseResponse(STATUSCODENOTAUTHORISED, __('auth.sign_in_error'), []);
    }

    /**
     * User Register
     *
     * @param RegisterRequest $request as Array
     * @return object
     */
    public function register(RegisterRequest $request): object
    {
        try {
            DB::beginTransaction();
            $user = User::create($request->validated());
            auth()->login($user);
            $token = auth()->user()->createToken(config('news.api_token_secret'))->plainTextToken;
            DB::commit();
            return new BaseResponse(STATUSCODECREATE, __('auth.sign_up_success'), [
                'user'         => auth()->user(),
                'access_token' => $token
            ]);
        } catch (\Exception $exception){
            DB::rollBack();
            return new BaseResponse(STATUSCODEBADREQUEST, __('auth.server_error'), []);
        }
    }
}
