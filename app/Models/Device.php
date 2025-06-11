<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = false;

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
