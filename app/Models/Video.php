<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'video_path',
        'tags',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
