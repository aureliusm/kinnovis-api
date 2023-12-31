<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): ApiResponse
    {
        $user = User::where('email', $request->email)->first();

        /** @var string $requestPassword */
        $requestPassword = $request->password;

        /** @var string $deviceName */
        $deviceName = $request->device_name;

        if (! $user || ! Hash::check($requestPassword, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        /** @var string $token */
        $token = $user->createToken($deviceName)->plainTextToken;

        return new ApiResponse(['token' => $token]);
    }
}
