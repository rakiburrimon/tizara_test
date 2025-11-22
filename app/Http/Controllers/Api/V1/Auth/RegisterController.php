<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Jobs\SendDefaultEmailJob;
use App\Mail\VerifyEmailMail;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends ApiBaseController
{
    /**
     * The OTP service instance.
     */
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
            // Mail::to($user->email)->send(new VerifyEmailMail($verificationToken, $user->email));

            // $emailService = new EmailService();
            // $emailService->sendEmail(
            //     $validatedData['email'],
            //     'Registration',
            //     'User Registration',
            //     'title'
            // );

            SendDefaultEmailJob::dispatch($validatedData['email'],
                'Registration',
                'User Registration',
                'title'
            );


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

    /**
     * Login a user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $user = User::where('email', $validatedData['email'])->first();

            if (! $user) {
                return $this->notFoundResponse([], __('User not found'));
            }

            // if (! $user->is_verified || ! $user->email_verified_at) {
            //     return $this->forbiddenResponse([], __('User is not verified'));
            // }

            if (! Hash::check($validatedData['password'], $user->password)) {
                return $this->unauthorizedResponse([], __('Invalid credentials'));
            }

            // Generate a new token for the user
            $token = $user->createToken(config('app.name'))->plainTextToken;

            $this->otpService->sendOtpEmail($otp);

            // Return a success response
            return $this->okResponse(['user' => $user, 'token' => $token], __('User logged in successfully'));
        } catch (\Exception $e) {
            // Log the error message
            Log::error('User login error: ' . $e->getMessage());

            // Return a server error response
            return $this->serverErrorResponse(['error' => $e->getMessage()], __('User login failed'));
        }
    }
}
