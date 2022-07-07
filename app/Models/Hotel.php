<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    
    protected $table = 'hotels';

	protected $fillable = [
       'version',
       'timestamp',
       'echo_token',
       'xmlns'
    ];

}
