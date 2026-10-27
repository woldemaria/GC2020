<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RegistrationSettingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        $settings = RegistrationSettingService::getSettings();
        return view('auth.register', compact('settings'));
    }

    /**
     * Get registration status for public frontend
     */
    public function status(): JsonResponse
    {
        $settings = RegistrationSettingService::getSettings();
        return response()->json([
            'success' => true,
            'is_open' => RegistrationSettingService::isOpen(),
            'status' => $settings['status'] ?? 'open',
            'settings' => $settings,
        ]);
    }

    /**
     * Handle registration request
     */
    public function register(Request $request): JsonResponse
    {
        // Enforce admin permission for open/closed registration
        if (!RegistrationSettingService::isOpen()) {
            $isAdmin = Auth::check() && Auth::user()->isAdmin();
            if (!$isAdmin) {
                $settings = RegistrationSettingService::getSettings();
                return response()->json([
                    'success' => false,
                    'is_closed' => true,
                    'message' => $settings['closed_message'] ?? 'Online registration is currently closed by the university administration.',
                    'settings' => $settings,
                ], 403);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_admin' => $request->boolean('is_admin', false),
                'is_active' => true,
            ]);

            // Log the user in automatically
            Auth::login($user);

            // Create token for API authentication
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'user' => $user,
                'token' => $token,
                'redirect' => $user->isAdmin() ? '/admin' : '/'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
