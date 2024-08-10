<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketNote extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id','customer_id','added_by','note','status','created_at','updated_at'];

    public function getCustomer()
    {
        return $this->belongsTo('App\Models\USer', 'customer_id');
    }

}
