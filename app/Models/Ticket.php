<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','subject','tags','assigned','name','email','priority','service','department','cc','ticket_body','knoladge_link','description','attachment','reply','status','created_at','updated_at'];
}
