<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected  $primaryKey = 'copy_id';

    protected $fillable = [
        'm_id',
        'send_time',
        'mes_id'
    ];
}
