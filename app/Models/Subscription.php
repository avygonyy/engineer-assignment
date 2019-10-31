<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 */
class Subscription extends Model
{
    protected $table = 'subscription';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email'
    ];
}
