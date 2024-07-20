<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Note extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['description','customer_id', 'added_by', 'status', 'created_at', 'updated_at'];
}
