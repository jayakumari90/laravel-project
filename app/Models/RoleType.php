<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleType extends Model
{
    use HasFactory;
    protected $table ='role_types';
    protected $fillable = ['role_type','status','created_at','updated_at'];
}
