<?php

namespace NotificationChannels\GoogleChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Room extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    public function space(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Space::class, 'related');
    }
}
