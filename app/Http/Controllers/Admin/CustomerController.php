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
use DataTables;


class CustomerController extends Controller
{
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = User::orderBy('id','desc')->get();
            
            return Datatables::of($data)->addIndexColumn()
                    ->addColumn('action', function($row) {
                    // $btn = '<a href="' . route('customer.show', $row->id) . '" title="View"><i class="fas fa-eye"></i></a>';
                    // $btn .= '<a href="' . route('customer.edit', $row->id) . '" title="Edit"><i class="fas fa-pen-square"></i></a>';
                    // return $btn;
                })
                ->editColumn('created_at', function($row) {
                    return date('Y-m-d H:i:s', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'customer']) // Ensure HTML is rendered
                ->make(true);
        }
    
        return view('admin.customer.list');
    }

    public function add(Request $request){
        $countries = Country::get();
        $languages = DefaultLanguage::where('status',1)->get();
        return view('admin.customer.add',compact('countries','languages'));
    }

    public function store(StoreCustomerRequest $request){
        if($request->isMethod('post')){
            User::Create([
                'company'=>$request->company,
                'vat_number'=>$request->vat_number,
                'phone_number'=>$request->phone_number,
                'website'=>$request->website,
                'groups'=>implode(',',$request->groups),
                'currency'=>$request->currency,
                'default_language'=>$request->default_language,
                'address'=>$request->address,
                'country'=>$request->country,
                'state'=>$request->state,
                'city'=>$request->city,
                'zipcode'=>$request->zipcode,
                'status'=>1
            ]);
            return response()->json(['status'=>true,'success' => 'Customer added successfully.','redirect_url' => route('customer.list')]);
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
                $pdf = PDF::loadView('admin.customer.export', compact('data'));
                return $pdf->download('customer.pdf');
            default:
                return back();
        }
    }

}
