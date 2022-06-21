<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDocument extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(TypeDocument::class, 'type_id');
    }

    public function AuthorComment()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function poster()
    {
        return $this->belongsTo(Poster::class);
    }
}
