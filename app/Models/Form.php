<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'name',
        'created_by',
        'active',
        'reportable'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function field()
    {
        return $this->hasMany(Field::class)->orderBy('order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeReport($query)
    {
        return $query->where('reportable', 1);
    }
}
