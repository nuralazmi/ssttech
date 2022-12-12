<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailAddress extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'mail_addresses';
}
