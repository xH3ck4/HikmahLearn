<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogsUpdate extends Model
{
    use HasFactory;

    protected $table = 'logs_update';

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
