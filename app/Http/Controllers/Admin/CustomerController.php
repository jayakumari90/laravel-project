<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\CustomerExport;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\User;
use App\Models\Country;
use App\Models\DefaultLanguage;
use App\Models\State;
use App\Models\CustomerBilling;
use App\Models\Note;
use App\Models\Tag;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\LeadStatus;
use DataTables;


class CustomerController extends Controller
{
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = User::orderBy('id','desc')->get();
            
            return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row) {
                    $btn = '<a href="' . route('customer.show', $row->id) . '" title="View"><i class="fas fa-eye"></i></a>';
                    // $btn .= '<a href="' . route('customer.edit', $row->id) . '" title="Edit"><i class="fas fa-pen-square"></i></a>';
                     return $btn;
                })
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i:s', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'customer']) // Ensure HTML is rendered
                ->make(true);
        }
    
        return view('admin.Customer.list');
    }

    public function add(Request $request){
        $countries = Country::get();
        $languages = DefaultLanguage::where('status',1)->get();
        return view('admin.Customer.add',compact('countries','languages'));
    }

    public function store(StoreCustomerRequest $request){
        if($request->isMethod('post')){
            $user = User::Create([
                'company'=>$request->company,
                'vat_number'=>$request->vat_number,
                'phone_number'=>$request->phone_number,
                'website'=>$request->website,
                'groups'=>implode(',',$request->groups),
                'currancy'=>$request->currency,
                'default_language'=>$request->default_language,
                'address'=>$request->address,
                'country'=>$request->country,
                'state'=>$request->state,
                'city'=>$request->city,
                'zipcode'=>$request->zipcode,
                'status'=>1
            ]);
            $lastInsertedId = $user->id;

            return response()->json(['status'=>true,'success' => 'Customer added successfully.','redirect_url' => route('customer.show',$lastInsertedId)]);
        }
    }

    public function show($id){
        $customer = User::where('id', $id)->where('status',1)->first();
        $custbill = CustomerBilling::where('customer_id', $id)->where('status',1)->first();
        $countries = Country::get();
        $languages = DefaultLanguage::where('status',1)->get();
        $states = State::get();
        return view('admin.Customer.show',compact('customer','countries','languages','states','custbill'));
    }

    public function update(StoreCustomerRequest $request){
        if($request->isMethod('post')){
           // dd($request->all());
            User::where('id', $request->customer_id)->update([
                'company'=>$request->company,
                'vat_number'=>$request->vat_number,
                'phone_number'=>$request->phone_number,
                'website'=>$request->website,
                'groups'=>$request->groups,
                'currancy'=>$request->currency,
                'default_language'=>$request->default_language,
                'address'=>$request->address,
                'country'=>$request->country,
                'state'=>$request->state,
                'city'=>$request->city,
                'zipcode'=>$request->zipcode,
                'status'=>1
            ]);
            return response()->json(['status'=> true, 'msg' => 'Customer added successfully.','redirect_url' => route('customer.show',$request->customer_id)]);
        }
    }

    public function updateBillingInfo(Request $request){
        if($request->isMethod('post')){
            CustomerBilling::updateOrCreate([
                'customer_id'=>$request->customer_id,
                'billing_address'=>$request->billing_address,
                'shipping_address'=>$request->shipping_address,
                'billing_city'=>$request->billing_city,
                'shipping_city'=>$request->shipping_city,
                'billing_country'=>$request->billing_country,
                'shipping_country'=>$request->shipping_country,
                'billing_state'=>$request->billing_state,
                'shipping_state'=>$request->shipping_state,
                'billing_zipcode'=>$request->billing_zipcode,
                'shipping_zipcode'=>$request->shipping_zipcode,
                'status'=>1
            ]);   
            return response()->json(['status'=> true, 'msg' => 'Billing address added successfully.','redirect_url' => route('customer.show',$request->customer_id)]);
        }
    }

    public function getnotes(Request $request){
        if($request->isMethod('post')){
            //dd($request->all());
            $note = Note::where('id', $request->id)->first();
            return response()->json(['status'=> true, 'data'=>$note]);
        }
    }
    public function notes(Request $request,$id) {
        if ($request->ajax()) {
            $data = Note::orderBy('id','desc')->get();
            
            return Datatables::of($data)->addIndexColumn()
                ->editColumn('description', function($row) {
                    $note = $row->description;
                    
                    return $note;
                    
                })
                    ->addColumn('action', function($row) {
                    $btn = '<a href="javascript:void(0)" title="Edit" onclick="updateNote('.$row->id.')"> <i class="fas fa-pen-square"></i></a>';
                     return $btn;
                })
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i:s', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'customer']) // Ensure HTML is rendered
                ->make(true);
        }
    
        return view('admin.Customer.notes',compact('id'));
    }

    public function addNotes(Request $request){
        if($request->isMethod('post')){
            if($request->note_id && !empty($request->note_id)){
                Note::where('id',$request->note_id)->update([
                    'description'=>$request->description,
                    'customer_id'=>$request->customer_id,
                    'added_by'=>auth()->user()->id,
                    'status'=>1
                ]);
                return response()->json(['status'=> true, 'msg' => 'Notes updated successfully.','redirect_url' => route('customer.notes',$request->customer_id)]);
            }else{

                Note::create([
                    'description'=>$request->description,
                    'customer_id'=>$request->customer_id,
                    'added_by'=>auth()->user()->id,
                    'status'=>1
                ]);
                return response()->json(['status'=> true, 'msg' => 'Note added successfully.','redirect_url' => route('customer.notes',$request->customer_id)]);
            }
            

        }
    }

    public function export($format)
    {
        switch ($format) {
            case 'csv':
                return Excel::download(new CustomerExport, 'customer.csv');
            case 'xlsx':
                return Excel::download(new CustomerExport, 'customer.xlsx');
            case 'pdf':
                $data = User::where('role',3)->orderBy('id', 'desc')->get();
                $pdf = PDF::loadView('admin.Customer.export', compact('data'));
                return $pdf->download('customer.pdf');
            default:
                return back();
        }
    }

    public function ticket(Request $request, $id){
        $tags = Tag::where('status',1)->get();
        $staffs = User::where('role',3)->where('status',1)->get();
        $projects = Project::where('status',1)->get();
        return view('admin.Customer.ticket',compact('tags','staffs','projects','id'));
    }

    public function storeTicket(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'subject' => 'required',
                'department' => 'required'
            ]);

            if ($validator->fails()) {
                //$error = $this->validationHandle($validator->messages());
                return response()->json([

                    'status'   => false,
        
                    'message'   => 'Validation errors',
        
                    'data'      => $validator->errors()
        
                ]);
                //response()->json(['status' => false, 'message' => $error]);
            }
            $base_url =  url('/');
            if(!empty($request->file('attachment'))){
                $image = $request->attachment;
                $filename = 'user_'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/users');
                $image->move($destinationPath, $filename);
                $attachment = $base_url.'/public/uploads/'.$filename;
            }
            Ticket::create([
                'customer_id'=>$request->customer_id,
                'subject'=>$request->subject,
                'tage'=>$request->tag,
                'assigned'=>$request->staff,
                'name'=>$request->name,
                'email'=>$request->email,
                'priority'=>$request->priority,
                'service'=>$request->service,
                'department'=>$request->department,
                'cc'=>$request->cc,
                'ticket_body'=>$request->ticket_body,
                'knoladge_link'=>$request->knoladge_link,
                'description'=>$request->description,
                'attachment'=>$attachment,
                'status'=>1
            ]);
            return response()->json(['success' => 'Ticket added successfully.','redirect_url'=>route('customer.ticketList',$request->customer_id)]);
        }
    }

    public function ticketList(Request $request,$id) {
        if ($request->ajax()) {
            $data = Ticket::orderBy('id','desc')->get();
            
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if($row->status == 1){
                        $btn = '<a href="javascript:void(0)" class="btn btn-danger" title="Status" onclick="updateTicketStatus('.$row->id.',0)">Deactivate</a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" class="btn btn-success" title="Status" onclick="updateTicketStatus('.$row->id.',1)">Activate</a>';
                    } 
                    return $btn;
                    //return $status;
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="javascript:void(0)" title="Edit" onclick="updateNote('.$row->id.')"> <i class="fas fa-pen-square"></i></a>';
                     return $btn;
                })
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i:s', strtotime($row->created_at));
                })
                ->rawColumns(['status','action', 'customer']) // Ensure HTML is rendered
                ->make(true);
            }
            return view('admin.Customer.ticketList',compact('id'));
    }
    public function updateTicketStatus(Request $request){
        if($request->isMethod('post')){
            Ticket::where('id',$request->id)->update([
                'status'=>$request->status
            ]);
            return response()->json(['success'=>true, 'msg'=>'Lead status updated successfully']);
        }
    }
    
    

}
