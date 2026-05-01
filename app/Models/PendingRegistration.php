<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingRegistration extends Model
{
    protected $fillable =[
        'registration-id',
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'otp_hash',
        'otp_expires_at',
        'otp_attempts',
        'last_otp_sent_at',
    ];

    protected $casts =[
        'date_of_birth'=>'date',
        'otp_expires_at'=>'datetime',
        'last_otp_sent_at'=>'datetime',
    ];
}
