<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateLeadRequest;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\StaffExport;
use App\Imports\StaffImport;
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
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = User::whereIn('role',[3,4])->orderBy('id','desc')->get();
            
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($row) {
                if($row->status == 1){
                    $btn = '<a href="javascript:void(0)" class="btn btn-danger" title="Status" onclick="updateStaffStatus('.$row->id.',0)">Deactivate</a>';
                }else{
                    $btn = '<a href="javascript:void(0)" class="btn btn-success" title="Status" onclick="updateStaffStatus('.$row->id.',1)">Activate</a>';
                } 
                return $btn;
                //return $status;
            })
            ->editColumn('last_login', function($row) {
                return date('Y-m-d H:i:s', strtotime($row->created_at));
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="' . route('staff.show', $row->id) . '" title="View"><i class="fas fa-eye"></i></a>';
                 return $btn;
            })
            ->rawColumns(['status','action']) // Ensure HTML is rendered
            ->make(true);
        }
    
        return view('admin.Staff.list');
    }

    public function updateStaffStatus(Request $request){
        if($request->isMethod('post')){
            User::where('id',$request->id)->update([
                'status'=>$request->status
            ]);
            return response()->json(['success'=>true, 'msg'=>'Staff status updated successfully']);
        }
    }

    public function add(Request $request){
        return view('admin.Staff.add');
    }

    public function store(StoreStaffRequest $request){
        if($request->isMethod('post')){
            $user = User::Create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone_number'=>$request->phone_number,
                'address'=>$request->address,
                'position'=>$request->position,
                'department'=>implode(',',$request->department),
                'status'=>1
            ]);
            $lastInsertedId = $user->id;

            return response()->json(['status'=>true,'success' => 'Staff added successfully.','redirect_url' => route('staff.show',$lastInsertedId)]);
        }

        
    }
    public function show($id){
        $staff = User::where('id', $id)->where('status',1)->first();        
        return view('admin.Staff.show',compact('staff'));
    }

    public function edit($id){        
        $staff = Staff::where('id',$id)->first();
        return view('admin.Staff.edit', compact('staff'));
    }

    public function export($format)
    {
        switch ($format) {
            case 'csv':
                return Excel::download(new StaffExport, 'staff.csv');
            case 'xlsx':
                return Excel::download(new StaffExport, 'staff.xlsx');
            case 'pdf':
                $data = User::whereIn('role',[3,4])->with('getRole')->orderBy('id', 'desc')->get();
                $pdf = PDF::loadView('admin.Staff.export', compact('data'));
                return $pdf->download('staff.pdf');
            default:
                return back();
        }
    }

   

}
