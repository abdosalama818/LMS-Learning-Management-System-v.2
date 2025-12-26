<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Admin extends User implements MustVerifyEmail
{
    protected $guarded = [];
}
