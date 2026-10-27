<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_number',
        'verification_code',
        'qr_code_path',
        'graduate_name',
        'student_id',
        'qualification',
        'department',
        'program',
        'graduation_date',
        'gpa',
        'honors',
        'university_name',
        'university_logo_path',
        'university_address',
        'certificate_type',
        'language',
        'additional_notes',
        'digital_signature_path',
        'authorized_by',
        'authorized_title',
        'issued_at',
        'expires_at',
        'status',
        'verification_count',
        'last_verified_at'
    ];

    protected $casts = [
        'graduation_date' => 'date',
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_verified_at' => 'datetime',
        'gpa' => 'decimal:2',
        'verification_count' => 'integer'
    ];

    public function verifications(): HasMany
    {
        return $this->hasMany(CertificateVerification::class);
    }

    /**
     * Generate a unique certificate number
     */
    public static function generateCertificateNumber($year = null): string
    {
        $year = $year ?? date('Y');
        $prefix = 'GC' . $year;
        
        do {
            $number = $prefix . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (static::where('certificate_number', $number)->exists());
        
        return $number;
    }

    /**
     * Generate a unique verification code
     */
    public static function generateVerificationCode(): string
    {
        do {
            $code = strtoupper(Str::random(12));
        } while (static::where('verification_code', $code)->exists());
        
        return $code;
    }

    /**
     * Verify certificate by code or number
     */
    public static function verify($codeOrNumber, $method = 'manual_code'): ?self
    {
        $codeOrNumber = trim((string) $codeOrNumber);
        $certificate = static::where(function ($query) use ($codeOrNumber) {
            $query->where('verification_code', $codeOrNumber)
                  ->orWhere('certificate_number', $codeOrNumber);
        })
        ->where('status', 'active')
        ->first();

        if ($certificate) {
            // Update verification count and timestamp
            $certificate->increment('verification_count');
            $certificate->update(['last_verified_at' => now()]);
            
            // Log verification
            $certificate->verifications()->create([
                'verifier_ip' => request()->ip(),
                'verifier_user_agent' => request()->userAgent(),
                'verification_method' => $method,
                'verified_at' => now()
            ]);
        }

        return $certificate;
    }

    /**
     * Check if certificate is valid
     */
    public function isValid(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Get formatted graduation date
     */
    public function getFormattedGraduationDateAttribute(): string
    {
        return $this->graduation_date->format('F j, Y');
    }

    /**
     * Get verification URL
     */
    public function getVerificationUrlAttribute(): string
    {
        return url('/verify-certificate/' . $this->verification_code);
    }

    /**
     * Get QR code data (Canonical URL for direct real-world smartphone camera scanning)
     */
    public function getQrCodeDataAttribute(): string
    {
        return $this->verification_url;
    }

    /**
     * Generate and save vector QR code for this certificate
     */
    public function generateQrCode(): bool
    {
        try {
            $qrData = $this->verification_url;
            $filename = 'certificates/qr-codes/' . $this->verification_code . '.svg';

            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(300)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($qrData);

            \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $qrCode);
            $this->update(['qr_code_path' => $filename]);

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to generate QR code for certificate {$this->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Scope for active certificates
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for certificates by department
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope for certificates by graduation year
     */
    public function scopeByGraduationYear($query, $year)
    {
        return $query->whereYear('graduation_date', $year);
    }
}