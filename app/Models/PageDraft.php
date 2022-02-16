<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageDraft extends Model
{
    protected $table = 'page_drafts';

    protected $fillable = [
        'title', 'slug', 'content', 'library_id'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
