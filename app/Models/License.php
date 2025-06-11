<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MoonShine\ChangeLog\Traits\HasChangeLog;

class License extends Model
{
    protected $guarded = false;
    use HasChangeLog;
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
