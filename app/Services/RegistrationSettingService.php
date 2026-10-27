<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class RegistrationSettingService
{
    protected const CACHE_KEY = 'aau_registration_settings';
    protected const STORAGE_FILE = 'registration_settings.json';

    /**
     * Get default settings for registration control.
     */
    public static function getDefaultSettings(): array
    {
        return [
            'is_open' => true,
            'status' => 'open', // 'open' | 'closed'
            'academic_term' => 'Academic Year 2026/2027',
            'closed_title' => 'Registration Currently Closed',
            'closed_message' => 'Online registration for the Addis Ababa University Graduate Portal is currently closed by the university administration. Please check back later or contact the Office of the Registrar for further assistance.',
            'closing_date' => null,
            'reopening_date' => 'To be announced by Academic Affairs',
            'contact_email' => 'registrar@aau.edu.et',
            'contact_phone' => '+251 11 123 9700',
            'allow_admin_override' => true,
            'announcement' => 'Welcome to Addis Ababa University Graduate Registration Portal.',
            'last_updated_by' => 'System Administrator',
            'last_updated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Get the file path where settings are persisted.
     */
    protected static function getFilePath(): string
    {
        return storage_path('app/' . self::STORAGE_FILE);
    }

    /**
     * Retrieve all registration settings.
     */
    public static function getSettings(): array
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            $path = self::getFilePath();
            if (File::exists($path)) {
                $decoded = json_decode(File::get($path), true);
                if (is_array($decoded)) {
                    return array_merge(self::getDefaultSettings(), $decoded);
                }
            }
            return self::getDefaultSettings();
        });
    }

    /**
     * Check if registration is currently open.
     */
    public static function isOpen(): bool
    {
        $settings = self::getSettings();
        return (bool) ($settings['is_open'] ?? true) && ($settings['status'] ?? 'open') === 'open';
    }

    /**
     * Update and persist registration settings.
     */
    public static function updateSettings(array $data, ?string $updatedBy = null): array
    {
        $current = self::getSettings();

        // Format is_open boolean and status consistency
        if (isset($data['is_open'])) {
            $data['is_open'] = filter_var($data['is_open'], FILTER_VALIDATE_BOOLEAN);
            $data['status'] = $data['is_open'] ? 'open' : 'closed';
        } elseif (isset($data['status'])) {
            $data['is_open'] = ($data['status'] === 'open');
        }

        $data['last_updated_at'] = now()->toIso8601String();
        if ($updatedBy) {
            $data['last_updated_by'] = $updatedBy;
        }

        $merged = array_merge($current, $data);

        $path = self::getFilePath();
        $directory = dirname($path);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($path, json_encode($merged, JSON_PRETTY_PRINT));
        Cache::forget(self::CACHE_KEY);
        Cache::put(self::CACHE_KEY, $merged, 3600);

        return $merged;
    }
}
