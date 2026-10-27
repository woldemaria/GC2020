<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoComment extends Model
{
    protected $fillable = [
        'photo_id',
        'commenter_name',
        'commenter_email',
        'comment',
        'likes',
        'dislikes',
        'is_approved',
        'approved_by',
        'approved_at',
        'is_flagged',
        'flag_reason'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_flagged' => 'boolean',
        'approved_at' => 'datetime',
        'likes' => 'integer',
        'dislikes' => 'integer'
    ];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false)->where('is_flagged', false);
    }

    public function scopeFlagged($query)
    {
        return $query->where('is_flagged', true);
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getTotalVotesAttribute()
    {
        return $this->likes + $this->dislikes;
    }
}
