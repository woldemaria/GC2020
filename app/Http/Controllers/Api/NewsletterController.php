<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:newsletters,email',
                'name' => 'nullable|string|max:255'
            ]);

            $newsletter = Newsletter::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Successfully subscribed to newsletter!',
                'data' => $newsletter
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request): JsonResponse
    {
        $email = $request->get('email');
        
        $newsletter = Newsletter::where('email', $email)->first();
        
        if (!$newsletter) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found in our newsletter list.'
            ], 404);
        }

        $newsletter->unsubscribe();

        return response()->json([
            'success' => true,
            'message' => 'Successfully unsubscribed from newsletter.'
        ]);
    }

    /**
     * Check subscription status
     */
    public function status(Request $request): JsonResponse
    {
        $email = $request->get('email');
        
        $newsletter = Newsletter::active()->where('email', $email)->first();
        
        return response()->json([
            'subscribed' => $newsletter !== null
        ]);
    }
}