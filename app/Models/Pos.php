<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{

    protected $table = 'poses';

    protected $fillable = [
      'hotel_id',
      'booking_channel_type',
      'company_name_code',
      'company_name_value'
    ];

}
