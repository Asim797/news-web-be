<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\Api\UpdatePreferenceRequest;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get User Profile
     *
     * @param Request $request as Array
     * @return object
     */
    public function index(Request $request){
        return new BaseResponse(STATUSCODEOK, __('user.profile_fetched_success'), [
            'user' => $request->user()
        ]);
    }

    /**
     * Update User Profile
     *
     * @param UpdateProfileRequest $request as Array
     * @return object
     */
    public function updateProfile(UpdateProfileRequest $request): object
    {
        $request->user()->update($request->validated());
        return new BaseResponse(STATUSCODEUPDATE, __('user.profile_update_success'), []);
    }

    /**
     * Update User Preferences
     *
     * @param UpdatePreferenceRequest $request as Array
     * @return object
     */
    public function updatePreferences(UpdatePreferenceRequest $request): object
    {
        $request->user()->update([
            'preferred_sources'    => json_encode($request['sources']),
            'preferred_categories' => json_encode($request['categories']),
            'preferred_authors'    => json_encode($request['authors']),
        ]);
        return new BaseResponse(STATUSCODEUPDATE, __('user.preferences_update_success'), []);
    }

    /**
     * User Password Change
     *
     * @param ChangePasswordRequest $request as Array
     * @return object
     */
    public function changePassword(ChangePasswordRequest $request): object
    {
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return new BaseResponse(STATUSCODEBADREQUEST, __('user.password_does_not_match'), []);
        }
        $request->user()->update(['password' => $request->password]);
        return new BaseResponse(STATUSCODEUPDATE, __('user.user_change_password_success'), []);
    }
}
