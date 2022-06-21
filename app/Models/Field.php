<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'form_id',
        'order',
        'active',
        'question',
        'type',
        'mark',
        'required',
        'sync',
        'filter',
        'report'
    ];

    public function scopeActive($query)
    {
        return $query->where('active',1);
    }

    public function scopeReport($query)
    {
        return $query->where('report',1);
    }

    public function scopeFilter($query)
    {
        return $query->where('filter',1);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function option()
    {
        return $this->hasMany(Option::class);
    }
}
