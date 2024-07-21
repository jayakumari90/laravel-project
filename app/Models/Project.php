<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['project_name','customer','calculate_progress','task_progress','billing_type','status','estimated_hour','members','start_date','deadline','tags','description','send_project','created_at','updated_at'];
}
