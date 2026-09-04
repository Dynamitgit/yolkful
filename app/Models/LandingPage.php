<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = ['title', 'slug', 'meta_description', 'intro_content', 'tag_id'];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}