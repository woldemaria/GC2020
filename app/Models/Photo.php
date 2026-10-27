<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Photo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'alt_text',
        'category',
        'order',
        'is_featured',
        'taken_at',
        'likes',
        'dislikes',
        'graduation_year',
        'motto',
        'student_name',
        'student_names',
        'department',
        'degree_program',
        'photographer',
        'tags',
        'photo_type',
        'allow_comments',
        'is_public',
        'uploaded_by',
        'approved_at',
        'approved_by',
        'admin_notes'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'taken_at' => 'datetime',
        'order' => 'integer',
        'likes' => 'integer',
        'dislikes' => 'integer',
        'graduation_year' => 'integer',
        'tags' => 'array',
        'student_names' => 'array',
        'allow_comments' => 'boolean',
        'is_public' => 'boolean',
        'approved_at' => 'datetime'
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopeByPhotoType($query, $type)
    {
        return $query->where('photo_type', $type);
    }

    public function scopeByGraduationYear($query, $year)
    {
        return $query->where('graduation_year', $year);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PhotoComment::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(PhotoComment::class)->orderBy('created_at', 'desc');
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getTotalVotesAttribute()
    {
        return $this->likes + $this->dislikes;
    }

    public function getLikePercentageAttribute()
    {
        $total = $this->total_votes;
        return $total > 0 ? round(($this->likes / $total) * 100, 1) : 0;
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/placeholder-gallery.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        // Generate thumbnail path by adding _thumb before file extension
        if ($this->image_path) {
            $pathInfo = pathinfo($this->image_path);
            $thumbnailPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
            return asset('storage/' . $thumbnailPath);
        }
        return asset('images/placeholder-gallery-thumb.jpg');
    }

    public function getTagsListAttribute()
    {
        return $this->tags ? implode(', ', $this->tags) : '';
    }
}
