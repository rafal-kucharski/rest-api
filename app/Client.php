<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'vat_number',
        'street',
        'city',
        'post_code',
        'email',
    ];
}
