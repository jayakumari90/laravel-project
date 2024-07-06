<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','lead_id','image','status','created_at','updated_at'
    ];
}
