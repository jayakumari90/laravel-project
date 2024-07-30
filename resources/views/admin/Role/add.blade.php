@extends('layouts.admin')
@section('title', 'Add Role')
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
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="role_type"><small class="req text-danger">* </small>Role</label>
                        <input type="text" class="form-control" id="role_type" name="role_type">
                        <span id="role_type-err" class="error"></span>                       
                    </div>
                </div>
                
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
            url: "{{ route('role.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log('data',data);
                if(data.status){
                    window.location.href=data.redirect_url;
                }else{
                    let errors = data.data;
                    for (let key in errors) {
                        $('#'+key+'-err').text(errors[key]);
                    }
                }
            },
            // error: function(response) {
            //     let errors = response.data.msg;//.responseJSON.errors;
            //     console.log('errors',errors)
            //     for (let key in errors) {
            //         $('#'+key).text(errors[key]);
            //     }
            // }
        });
    });
    </script>
@endsection