<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\State;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getStates(Request $request){
        if($request->isMethod('post')){
            $states = State::where('country_id', $request->country)->get();
            return response()->json($states, 200);
        }
    }
}
