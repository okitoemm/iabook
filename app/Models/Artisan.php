<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artisan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_name',
        'siret',
        'specialty',
        'description',
        'experience_years',
        'hourly_rate',
        'service_area',
        'is_verified',
        'rating_average',
        'total_reviews',
        'payment_methods',
        'documents',
        'status',
        'profile_views'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'rating_average' => 'float',
        'total_reviews' => 'integer',
        'experience_years' => 'integer',
        'hourly_rate' => 'float',
        'payment_methods' => 'array',
        'documents' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getPositiveReviewsPercentage()
    {
        if ($this->total_reviews === 0) return 0;
        
        $positiveReviews = $this->reviews()
            ->where('rating', '>=', 4)
            ->count();
            
        return ($positiveReviews / $this->total_reviews) * 100;
    }
}



