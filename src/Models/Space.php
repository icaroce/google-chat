<?php

namespace NotificationChannels\GoogleChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Space extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function related()
    {
        return $this->morphTo('related');
    }
}
