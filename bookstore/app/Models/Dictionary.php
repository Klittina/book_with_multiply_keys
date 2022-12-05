<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;

    protected  $primaryKey = 'mes_id';

    protected $fillable = [
        'mes_id',
        'subject',
        'text'
    ];
}
