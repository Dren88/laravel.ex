<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'deal_id', 'permission_id'];
}
