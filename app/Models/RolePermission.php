<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $fillable = ['role_id','module_name', 'can_create','can_edit','can_view','can_view_own', 'created_at','updated_at'];
}
