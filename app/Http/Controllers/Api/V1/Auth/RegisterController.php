<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Mail\VerifyEmailMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends ApiBaseController
{
	/**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            $existingUser = User::where('email', $validatedData['email'])->first();

            if ($existingUser) {
                return $this->badRequestResponse([], __('User already exists'));
            }

            $verificationToken = Str::random(60);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'email_verification_token' => $verificationToken,
            ]);
            // Send the verification email
            Mail::to($user->email)->send(new VerifyEmailMail($verificationToken, $user->email));
            // Commit the transaction
            DB::commit();

            return $this->createdResponse(['user' => $user], __('User registered successfully. Please check your email to verify your account.'));
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            // Log the error message
            Log::error('User registration error: ' . $e->getMessage());

            // Return a server error response
            return $this->serverErrorResponse(['error' => $e->getMessage()], __('User registration failed'));
        }
    }
}
