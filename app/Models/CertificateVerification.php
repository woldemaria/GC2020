<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id',
        'verifier_ip',
        'verifier_user_agent',
        'verification_method',
        'verification_details',
        'verified_at'
    ];

    protected $casts = [
        'verification_details' => 'json',
        'verified_at' => 'datetime'
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }

    /**
     * Get verification statistics
     */
    public static function getStats($certificateId = null): array
    {
        $query = static::query();
        
        if ($certificateId) {
            $query->where('certificate_id', $certificateId);
        }

        $totalVerifications = $query->count();
        $todayVerifications = $query->whereDate('verified_at', today())->count();
        $weekVerifications = $query->where('verified_at', '>=', now()->subWeek())->count();
        
        $methodStats = $query->selectRaw('verification_method, COUNT(*) as count')
            ->groupBy('verification_method')
            ->pluck('count', 'verification_method')
            ->toArray();

        return [
            'total' => $totalVerifications,
            'today' => $todayVerifications,
            'week' => $weekVerifications,
            'methods' => $methodStats
        ];
    }
}