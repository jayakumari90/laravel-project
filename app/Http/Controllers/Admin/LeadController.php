<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreLeadRequest;
use App\Models\User;
use App\Models\RoleType;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Source;
use App\Models\Country;
use App\Models\State;
use App\Models\Tag;
use App\Models\DefaultLanguage;
use DataTables;

class LeadController extends Controller
{
    public function list(Request $request){
        if ($request->ajax()) {
            $data = Lead::select('id','name','company','email','phone','lead_value','staff','lead','source','tag','created_at')->with('getLeadStatus','getSource','getStaff')->get();
        return Datatables::of($data)->addIndexColumn()

                ->editColumn('lead', function ($row) {
                        return $row->getLeadStatus->lead;
                
                })
                ->editColumn('source', function ($row) {
                        return $row->getSource->source;
                
                })
                
                ->editColumn('staff', function ($row) {
                        return $row->getStaff->name;
                
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="' . route('lead.show', $row->id) . '"><i class="fas fa-eye"></i>
                    </a>';
                   // $btn .= '<a href="' . route('restaurant_cat.delete', $row->id) . '" type="button" data-toggle="tooltip" data-title="Delete" title="Delete" class="btn btn-danger btn-sm">Delete</a>';
                    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.lead.list');
    }

    public function add(Request $request){
        $lead_status = LeadStatus::where('status',1)->get();
        $source = Source::where('status',1)->get();
        $staffs = User::where('role',3)->where('status',1)->get();
        $tags = Tag::where('status',1)->get();
        $countries = Country::get();
        $states = State::get();
        $languages = DefaultLanguage::where('status',1)->get();
        
        return view('admin.lead.add',compact('lead_status','source','staffs','tags','countries','states','languages'));
    }
    public function store(StoreLeadRequest $request){
        if($request->isMethod('post')){
            // $validator = Validator::make();
            // if ($validator->fails()) {
            //     $arr = array('msg' => $validator->errors(), 'status' => false);
            //         return Response()->json($arr);
            // }else{
                Lead::Create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'lead'=>$request->lead,
                    'source'=>$request->source,
                    'staff'=>$request->staff,
                    'tag'=>$request->tag,
                    'position'=>$request->position,
                    'country'=>$request->country,
                    'state'=>$request->state,
                    'city'=>$request->city,
                    'website'=>$request->website,
                    'lead_value'=>$request->lead_value,
                    'default_language'=>$request->default_language,
                    'company'=>$request->company,
                    'description'=>$request->description,
                    'lead_public'=> $request->is_public,
                    'contacted_today'=>$request->contacted_today,
                    'status'=>1
                ]);
                return response()->json(['success' => 'Lead added successfully.']);
                //return redirect()->route('lead.list');
            //}
        }
    }

    public function show($id){
        $leads = Lead :: where('id',$id)->with('getLeadStatus','getSource','getStaff','getCountry','getState','getDefaultLanguage')->first();
        return view('admin.lead.show', compact('leads'));
    }
}
