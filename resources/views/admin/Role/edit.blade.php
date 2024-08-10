@extends('layouts.admin')
@section('title', 'Edit Role')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Role</h3>
            <!-- <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                <a href="#">
                    <i class="icon-home"></i>
                </a>
                </li>
                <li class="separator">
                <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                <a href="#">Leads</a>
                </li>
                <li class="separator">
                <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                <a href="#">Add New Leads</a>
                </li>
                
            </ul> -->
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <!-- <div class="card-title">Form Elements</div> -->
                </div>
                <div class="card-body">
                {!! Form::open(['method' => 'post', 'id'=>'role-form']) !!}
            
                <!-- CSRF Token -->
                {!! Form::token() !!}
                <div class="row">
                    <input type="hidden" name="role_id" id="role_id" value="{{$role->id}}">
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="role"><small class="req text-danger">* </small>Role</label>
                            <input type="text" id="role_type" name="role_type" value="{{$role->role_type}}">
                            
                            <span id="role_type-err" class="error"></span>                       
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Features</th>
                            <th>Capabilities</th>
                        </tr>
                        @if($permission->count() > 0)
                        @foreach($permission as  $val)
                        <tr>
                            <td>{{ucfirst($val->module_name)}}</td>
                            <td>
                                <input type="checkbox" name="permissions[{{$val->module_name}}][]" @if($val->can_view_own == 1) {{'checked'}} @endif value="view_own">View (Own)
                                <input type="checkbox" name="permissions[{{$val->module_name}}][]" @if($val->can_view == 1) {{'checked'}} @endif value="view">View (Global)
                                <input type="checkbox" name="permissions[{{$val->module_name}}][]" @if($val->can_create == 1) {{'checked'}} @endif value="create">Create
                                <input type="checkbox" name="permissions[{{$val->module_name}}][]" @if($val->can_edit == 1) {{'checked'}} @endif value="edit">Edit

                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>Lead</td>
                            <td>
                                <input type="checkbox" name="permissions[lead][]" value="view_own">View (Own)
                                <input type="checkbox" name="permissions[lead][]" value="view">View (Global)
                                <input type="checkbox" name="permissions[lead][]" value="create">Create
                                <input type="checkbox" name="permissions[lead][]"  value="edit">Edit

                            </td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td>
                                <input type="checkbox" name="permissions[customer][]" value="view_own">View (Own)
                                <input type="checkbox" name="permissions[customer][]" value="view">View (Global)
                                <input type="checkbox" name="permissions[customer][]"  value="create">Create
                                <input type="checkbox" name="permissions[customer][]" value="edit">Edit

                            </td>
                        </tr>
                        <tr>
                            <td>Staff</td>
                            <td>
                                <input type="checkbox" name="permissions[staff][]"  value="view_own">View (Own)
                                <input type="checkbox" name="permissions[staff][]"  value="view">View (Global)
                                <input type="checkbox" name="permissions[staff][]"  value="create">Create
                                <input type="checkbox" name="permissions[staff][]"  value="edit">Edit

                            </td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>
                                <input type="checkbox" name="permissions[role][]" value="create">Create
                                <input type="checkbox" name="permissions[role][]" value="edit">Edit

                            </td>
                        </tr>
                        @endif
                    </table>

                <div class="card-action">
                <button class="btn btn-success">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$('#role-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('role.update') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log('data',data);
                if(data.status){
                    window.location.href= data.redirect_url;
                }else{
                    let errors = data.data;
                    for (let key in errors) {
                        $('#'+key+'-err').text(errors[key]);
                    }
                }
            },
        });
    });
    </script>
@endsection