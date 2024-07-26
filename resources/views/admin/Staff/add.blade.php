@extends('layouts.admin')
@section('title', 'Add Customer')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Staff</h3>
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
                    <div class="row">
                            <h2>Customer Details</h2>
                            {!! Form::open(['method' => 'post', 'id'=>'staff-form']) !!}
                
                                <!-- CSRF Token -->
                                {!! Form::token() !!}
                            
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="name"><small class="req text-danger"></small>Name</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                    <span id="name-err" class="error"></span>                       
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="email"><small class="req text-danger"></small>Email</label>
                                    <input type="text" class="form-control" name="email" id="email">
                                    <span id="email-err" class="error"></span>                       
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="company"><small class="req text-danger"></small>Phone</label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number">
                                    <span id="phone_number-err" class="error"></span>                       
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="website"><small class="req text-danger"></small>Address</label>
                                    <textarea class="form-control" name="address" id="address" row="50" col="30"></textarea>
                                    <span id="website-err" class="error"></span>                       
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <input type="text" class="form-control" id="position" placeholder="Position" name="position" />
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="department">Member Departments</label><br/>
                                    <input type="checkbox" name="department[]" value="Marketing" />Marketing<br/>
                                    <input type="checkbox" name="department[]" value="Sales" />Sales<br/>
                                    <input type="checkbox" name="department[]" value="Abuse" />Abuse
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
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$(".select2").select2({
    multiple: true,
});
$('#staff-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: "{{ route('staff.store') }}",
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
    $('#billing-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: "{{ route('customer.updatebill') }}",
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
            }
        });
    });
    function openCity(cityName) {
        var i;
        var x = document.getElementsByClassName("city");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(cityName).style.display = "block";
    }
    </script>
@endsection