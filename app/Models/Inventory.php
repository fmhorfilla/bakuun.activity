<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    
    protected $table = 'inventories';

    protected $fillable = [
       'hotel_id',
       'hotel_code',
       'start',
       'end',
       'inv_type_code',
       'rate_plan_code',
    ];

}
