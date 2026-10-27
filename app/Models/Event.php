<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'venue',
        'image',
        'category',
        'max_attendees',
        'registered_count',
        'registration_deadline',
        'is_featured',
        'is_published',
        'requirements',
        'highlights',
        'contact_email',
        'contact_phone',
        'organizer',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'registration_deadline' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'max_attendees' => 'integer',
        'registered_count' => 'integer',
        'requirements' => 'array',
        'highlights' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if registrations are still open.
     */
    public function isRegistrationOpen(): bool
    {
        if (!$this->is_published) {
            return false;
        }

        if ($this->registration_deadline && Carbon::parse($this->registration_deadline)->isPast()) {
            return false;
        }

        if ($this->max_attendees && $this->registered_count >= $this->max_attendees) {
            return false;
        }

        return true;
    }

    /**
     * Check if the event has already happened.
     */
    public function isPast(): bool
    {
        return Carbon::parse($this->event_date)->isPast();
    }

    /**
     * Check if the event is upcoming.
     */
    public function isUpcoming(): bool
    {
        return Carbon::parse($this->event_date)->isToday() || Carbon::parse($this->event_date)->isFuture();
    }

    /**
     * Get remaining spots.
     */
    public function getRemainingSpotsAttribute(): ?int
    {
        if (!$this->max_attendees) {
            return null;
        }

        return max(0, $this->max_attendees - $this->registered_count);
    }

    /**
     * Get formatted event date.
     */
    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->event_date)->format('F j, Y');
    }

    /**
     * Get formatted day of week.
     */
    public function getDayOfWeekAttribute(): string
    {
        return Carbon::parse($this->event_date)->format('l');
    }

    /**
     * Get formatted time range.
     */
    public function getFormattedTimeAttribute(): string
    {
        $start = Carbon::parse($this->start_time)->format('g:i A');
        $end = $this->end_time ? Carbon::parse($this->end_time)->format('g:i A') : '';

        return $end ? "$start - $end" : $start;
    }

    /**
     * Get registration URL.
     */
    public function getRegistrationUrlAttribute(): string
    {
        return url('/events/' . $this->slug);
    }

    /**
     * Scope for published events.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', today());
    }

    /**
     * Scope for past events.
     */
    public function scopePast($query)
    {
        return $query->where('event_date', '<', today());
    }

    /**
     * Scope for featured events.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Generate a unique slug from the title.
     */
    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
