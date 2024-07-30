<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RoleType;
use DataTables;
class RoleController extends Controller
{
    public function list(Request $request){
        if ($request->ajax()) {
            $data = RoleType::orderBy('id','desc')->get();
            //dd($data);
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-danger" title="Status" onclick="updateRoleStatus(' . $row->id . ',0)">Deactivate</a>';
                } else {
                    $btn = '<a href="javascript:void(0)" class="btn btn-success" title="Status" onclick="updateRoleStatus(' . $row->id . ',1)">Activate</a>';
                }
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('role.edit', $row->id) . '" title="Edit"><i class="fas fa-pen-square"></i></a>';
                return $btn;
            })
            ->rawColumns(['status', 'action']) // Ensure HTML is rendered
            ->make(true);
        }
    
        return view('admin.Role.list');
    }

    public function add(Request $request){
        return view('admin.Role.add');
    }
    public function store(Request $request){
        if($request->isMethod('post')){
            
            RoleType::Create([
                'role_type'=>$request->role_type,
                'status'=>1
            ]);            
            return response()->json(['status'=>true,'success' => 'Role added successfully.','redirect_url' => route('role.list')]);
        }
    }

    public function updateRoleStatus(Request $request){
        if($request->isMethod('post')){
            RoleType::where('id',$request->id)->update([
                'status'=>$request->status
            ]);
            return response()->json(['success'=>true, 'msg'=>'Role status updated successfully']);
        }
    }

    public function edit($id){
        $role = RoleType::where('id', $id)->where('status',1)->first();           
        return view('admin.Role.edit',compact('role'));
    }

    public function update(Request $request){
        if($request->isMethod('post')){
            RoleType::where('id',$request->role_id)->update([
                'role_type'=>$request->role_type
            ]);
            return response()->json(['status'=>true, 'msg'=>'Role updated successfully','redirect_url'=>route('role.list')]);
        }
    }
}
