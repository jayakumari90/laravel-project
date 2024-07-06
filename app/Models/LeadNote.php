<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','lead_id','note','date_connected','is_connected','status','created_at','updated_at'
    ];
}
