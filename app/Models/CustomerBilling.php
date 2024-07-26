<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class CustomerBilling extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['customer_id', 'billing_address','shipping_address','billing_city','shipping_city','billing_country','shipping_country','billing_state','shipping_state','billing_zipcode','shipping_zipcode','status','added_by','created_at','updated_at'];
}
