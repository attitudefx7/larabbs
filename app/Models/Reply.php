<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    // 属于一个话题
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // 属于一个作者
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
