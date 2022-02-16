<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'title', 'slug', 'content', 'library_id'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
