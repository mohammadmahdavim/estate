<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function authorPost()
    {
        return $this->belongsTo(User::class, 'author')->withDefault();
    }


    public function sector()
    {
        return $this->belongsTo(Sector::class)->withDefault();
    }

    public function verifierPost()
    {
        return $this->belongsTo(User::class, 'verifier')->withDefault();
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id')->withDefault();
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id')->withDefault();
    }

    public function detail()
    {
        return $this->hasMany(PosterDetail::class);
    }

    public function AdminDocument()
    {
        return $this->hasMany(AdminDocument::class);
    }

    public function images()
    {
        return $this->hasMany(PosterImage::class);
    }

    public function documents()
    {
        return $this->hasMany(PosterDocument::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class);
    }

    public function like()
    {
        return $this->belongsToMany(User::class, 'like_post');
    }
}
