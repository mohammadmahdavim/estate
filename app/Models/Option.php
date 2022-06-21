<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'field_id',
        'value',
        'order',
        'active',
        'mark',
        'code',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active',1)->orderBy('order','asc');
    }
}
