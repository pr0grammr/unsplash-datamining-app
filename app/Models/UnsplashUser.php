<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UnsplashUser extends Model
{
    use HasFactory;

    const DETECTION_MODE_MANUAL = 'manual';
    const DETECTION_MODE_AUTO = 'auto';

    protected $guarded = ['id'];

    protected $fillable = [
        'username',
        'name',
        'first_name',
        'last_name',
        'twitter_username',
        'instagram_username',
        'bio',
        'location',
        'profile_image',
        'total_collections',
        'total_likes',
        'total_photos',
        'total_views',
        'following_count',
        'followers_count',
        'downloads',
        'detection_mode',
        'twitter',
        'refreshed_at'
    ];

    public function photos()
    {
        return $this->hasMany(UnsplashPhoto::class);
    }
}
