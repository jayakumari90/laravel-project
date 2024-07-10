@extends('layouts.admin')
@section('title', 'Add Customer')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Customer</h3>
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
                {!! Form::open(['method' => 'post', 'id'=>'customer-form']) !!}
            
                <!-- CSRF Token -->
                {!! Form::token() !!}
                <div class="row">
                    <div class="w3-bar w3-black">
                        <button class="w3-bar-item w3-button" onclick="openCity('Customer')">Profile</button>
                        <button class="w3-bar-item w3-button" onclick="openCity('Billing')">Billing & Shipping</button>
                    </div>   
                    <div id="customer" class="w3-container w3-display-container city">
                        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                        <h2>Customer Details</h2>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="company"><small class="req text-danger">* </small>Company</label>
                                <input type="text" class="form-control" name="company" id="company">
                                <span id="company-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="company"><small class="req text-danger"></small>VAT Number</label>
                                <input type="text" class="form-control" name="vat_number" id="vat_number">
                                <span id="vat_number-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="company"><small class="req text-danger"></small>Phone</label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number">
                                <span id="vat_number-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="website"><small class="req text-danger"></small>Website</label>
                                <input type="text" class="form-control" name="website" id="website">
                                <span id="website-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="groups"><small class="req text-danger"></small>Groups</label>
                                <select class="form-select select2" name="groups[]" id="groups" multiple="multiple">                        
                                <option value="High Budget">High Budget</option>
                                <option value="Low Budget">Low Budget</option>
                                <option value="VIP">VIP</option>
                                <option value="Wholesaler">Wholesaler</option>
                                </select>
                                <span id="groups-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="currency"><small class="req text-danger"></small>Currency</label>
                                <select class="form-control" name="currency" id="currency">
                                    <option value="USD">USD <small class="text-muted">$</small></option>
                                    <option value="EUR">EUR <small class="text-muted">€</small></option>
                                </select>
                                <span id="currency-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="default_language"><small class="req text-danger"></small>Default Language</label>
                                <select class="form-control" name="default_language" id="default_language">
                                    <option value="">Select</option>
                                    @foreach($languages as $language)
                                    <option value="{{$language->id}}">{{$language->name}}</option>
                                    @endforeach
                                </select>
                                <span id="default_language-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="address"><small class="req text-danger"></small>Address</label>
                                <input type="text" class="form-control" name="address" id="address">
                                <span id="address-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="country"><small class="req text-danger"></small>Country</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="">Select</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}
                                    @endforeach
                                </select>
                                <span id="country-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="state"><small class="req text-danger"></small>State</label>
                                <select class="form-control" name="state" id="state">
                                    <option value="">Select</option>
                                    
                                </select>
                                <span id="state-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="city"><small class="req text-danger"></small>City</label>
                                <input type="text" class="form-control" name="city" id="city">
                                <span id="city-err" class="error"></span>                       
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="zipcode"><small class="req text-danger"></small>Zip Code</label>
                                <input type="text" class="form-control" name="zipcode" id="zipcode">
                                <span id="zipcode-err" class="error"></span>                       
                            </div>
                        </div>
                    </div>
                
                
                <div class="card-action">
                <button class="btn btn-success">Submit</button>
                <button class="btn btn-danger">Cancel</button>
                </div>
                {!! Form::close() !!}
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
        $('#country').on('change', function() {
    var country = $(this).val();
    $.ajax({
        url: '{{ route('getStates') }}',
        type: 'POST',
        data: {
            country: country,
            _token: '{{ csrf_token() }}' // Include the CSRF token
        },
        success: function(data) {
            $('#state').empty(); // Clear existing options
            $.each(data, function(index, item) {
                $('#state').append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        }
    });
});
$('#customer-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: "{{ route('customer.store') }}",
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