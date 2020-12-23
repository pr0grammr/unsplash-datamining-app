<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UnsplashPhoto extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'photo_id',
        'created_at',
        'updated_at',
        'description',
        'urls',
        'likes',
        'views',
        'downloads',
        'user',
        'refreshed_at'
    ];

    public function user()
    {
        return $this->belongsTo(UnsplashUser::class, 'user_id');
    }
}
