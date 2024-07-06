<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\LeadsExport;
use App\Imports\LeadImport;
use App\Models\User;
use App\Models\RoleType;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Source;
use App\Models\Country;
use App\Models\State;
use App\Models\Tag;
use App\Models\DefaultLanguage;
use App\Models\LeadFile;
use App\Models\LeadNote;
use DataTables;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Lead::with(['getLeadStatus', 'getSource', 'getStaff'])->get();
            
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('lead', function ($row) {
                    $lead_status = LeadStatus::where('status', 1)->get();
                    $options = '<select class="form-control" name="lead_status" onchange="updateLeadStatus(' . $row->id . ', this.value)">';
                    if($row->lead == 7){
                        $options .= '<option value="' . $status->id . '" ' . $selected . '></option>';
                    }
                    foreach ($lead_status as $status) {
                        $selected = $row->lead == $status->id ? 'selected' : '';
                        $options .= '<option value="' . $status->id . '" ' . $selected . '>' . $status->lead . '</option>';
                    }
                    $options .= '</select>';
                    return $options;
                })
                ->editColumn('source', function ($row) {
                    return $row->getSource->source;
                })
                ->editColumn('staff', function ($row) {
                    return $row->getStaff->name;
                })
                ->editColumn('created_at', function($row) {
                    $date1 = date('Y-m-d H:i:s', strtotime($row->created_at));
                    $date2 = date('Y-m-d H:i:s');

                    $diff = abs(strtotime($date2) - strtotime($date1));

                    $years = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
                    $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
                    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 
                    $hour = $hours ? $hours.' hrs, ':'';
                    $min = $minuts ? $minuts .' min':'';
                    return $hour.$min.' ago';
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="' . route('lead.show', $row->id) . '" title="View"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('lead.edit', $row->id) . '" title="Edit"><i class="fas fa-pen-square"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'lead']) // Ensure HTML is rendered
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
        $leadfile = LeadFile::where('lead_id',$id)->get();
        return view('admin.lead.show', compact('leads','leadfile'));
    }
    public function edit($id){
        $lead_status = LeadStatus::where('status',1)->get();
        $source = Source::where('status',1)->get();
        $staffs = User::where('role',3)->where('status',1)->get();
        $tags = Tag::where('status',1)->get();
        $countries = Country::get();
        $states = State::get();
        $languages = DefaultLanguage::where('status',1)->get();
        $lead_data = Lead::where('id',$id)->first();
        return view('admin.lead.edit', compact('lead_data','lead_status','source','staffs','tags','countries','states','languages'));
    }

    public function update(StoreLeadRequest $request){
        if($request->isMethod('post')){
            Lead::where('id',$request->lead_id)->Update([
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
        }
        
        return response()->json(['status'=> true, 'msg' => 'Lead added successfully.','redirect_url' => route('lead.show',$request->lead_id)]);
    }
    public function delete($id){
       $delete = Lead::where('id',$id)->delete();
       if($delete){
        return response()->json(['success'=>true,'msg'=>'lead deleted successfully']);
       }
    }

    public function customer(Request $request, $id){
        $lead_status = LeadStatus::where('status',1)->get();
        $source = Source::where('status',1)->get();
        $staffs = User::where('role',3)->where('status',1)->get();
        $tags = Tag::where('status',1)->get();
        $countries = Country::get();
        $states = State::get();
        $languages = DefaultLanguage::where('status',1)->get();
        $lead_data = Lead::where('id',$id)->first();
        
        return view('admin.lead.customer', compact('lead_data','lead_status','source','staffs','tags','countries','states','languages'));
    }

    public function customerUpdate(UpdateLeadRequest $request){
        
        if($request->isMethod('post')){
            $request->skipValidation = true;
            Lead::where('id',$request->lead_id)->Update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'position'=>$request->position,
                    'country'=>$request->country,
                    'state'=>$request->state,
                    'city'=>$request->city,
                    'website'=>$request->website,
                    'company'=>$request->company,
                    'zipcode'=>$request->zipcode,
                    'password'=>$request->password,
                    'converted_customer'=>1
                ]);
            
            
            return response()->json(['status'=> true, 'msg' => 'Lead added successfully.','redirect_url' => route('lead.show',$request->lead_id)]);
        }
    }

    public function updateLeadStatus(Request $request){
        if($request->isMethod('post')){
            Lead::where('id',$request->lead_id)->update([
                'lead'=>$request->status_id
            ]);
            return response()->json(['success'=>true, 'msg'=>'Lead status updated successfully']);
        }
    }
    
    public function export($format)
    {
        //dd($format);
        switch ($format) {
            case 'csv':
                return Excel::download(new LeadsExport, 'leads.csv');
            case 'xlsx':
                return Excel::download(new LeadsExport, 'leads.xlsx');
            case 'pdf':
                $data = Lead::with([
                    'getLeadStatus',
                    'getSource',
                    'getStaff',
                    'getCountry',
                    'getState',
                    'getDefaultLanguage'
                ])->get();
                $pdf = PDF::loadView('admin.lead.export', compact('data'));
                return $pdf->download('leads.pdf');
            default:
                return back();
        }
    }
    public function importLead(){
        $lead_status = LeadStatus::where('status',1)->get();
        $source = Source::where('status',1)->get();
        $staffs = User::where('role',3)->where('status',1)->get();
        $countries = Country::get();
        $states = State::get();
        return view('admin.lead.importlead', compact('lead_status','source','staffs','countries'));
    }

    public function import(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt',
            ]);

            $file = $request->file('file');
            if (!$file->isValid()) {
                return redirect()->back()->with('error', 'Invalid file upload.');
            }

            try {
                Excel::import(new LeadImport, $file);
                $data = Lead::where('import_update',1)->get();
                Lead::where('import_update',1)->update(['lead'=>$request->lead,'source'=>$request->source,'staff'=>$request->staff]);
                return redirect()->back()->with('success', 'Leads imported successfully.');
            } catch (\Exception $e) {
                \Log::error('Import failed:', ['error' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Failed to import leads.');
            }
        }
    }

    public function uploadFile(Request $request){
        $request->validate([
            'attachments.*' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
        ]);
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $name = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $file->move(public_path('uploads'), $name);
                
                LeadFile::create([
                    'lead_id'=>$request->lead_id,
                    'image'=>$name,
                    'status'=>1
                ]);
            }
            $data = LeadFile::where('lead_id',$request->lead_id)->get();
            $arr = '';
            foreach($data as $val){
                $arr .= '<img src="' . asset('uploads/' . $val->image) . '" width="100px">';
            }
        }

        return response()->json(['success' => 'Files uploaded successfully','data'=>$arr]);
    }

    public function addNotes(Request $request){
        dd($request->all());
    }
}
