<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    use HasFactory;
    protected $fillable = [
    ];
    protected $appends = [
    ];
    protected $casts = [
    ];  
    public $timestamps = true;
    protected $table = 'drivenyou_apitokens';

}
