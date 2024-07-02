<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'phone','address','position','lead','source','staff','country','state','city','website','lead_value','default_language','lead_public','contacted_today','description','company','zipcode','tag','status','converted_customer','password'
    ];

    public function getLeadStatus()
    {
        return $this->belongsTo('App\Models\LeadStatus', 'lead');
    }
    public function getSource()
    {
        return $this->belongsTo('App\Models\Source', 'source');
    }
    
    
    public function getStaff()
    {
        return $this->belongsTo('App\Models\User', 'staff');
    }
    public function getCountry()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }
    public function getState()
    {
        return $this->belongsTo('App\Models\State', 'state');
    }
    public function getDefaultLanguage()
    {
        return $this->belongsTo('App\Models\DefaultLanguage', 'default_language');
    }
}

