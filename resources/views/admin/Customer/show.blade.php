@extends('layouts.admin')
@section('title', 'Edit Customer')
@section('content')
<style>
#sidebar {
    background: #ffffff;
    width: 200px;
    height: 100%;
    display: block;
    position: absolute;
    left: 0px;
    top: 0px;
    transition: left 0.3s linear;
}

#sidebar.visible{
	left:0px;
	transition:left 0.3s linear;
}

#sidebar ul{
	margin:0px;
	padding:0px;
}

#sidebar ul li{
	list-style:none;
}

#sidebar ul li a {
    background: #ffffff;
    color: #ccc;
    border-bottom: 1px solid #c8c5c5;
    display: block;
    width: 277px;
    padding: 10px;
    text-decoration: none;
}

#sidebar-btn{
	display:inline-block;
	vertical-align: middle;
	width:20px;
	height:15px;
	cursor:pointer;
	margin:20px;
	position:absolute;
	top:0px;
	right:-60px;
}

#sidebar-btn span{
	height:1px;
	background:#111;
	margin-bottom:5px;
	display:block;
}

#sidebar-btn span:nth-child(2){
	width:75%;
}

#sidebar-btn span:nth-child(3){
	width:50%;
}
</style>
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
              <div class="col-md-3">
                <div class="card">                  
                  <div class="card-body">
                    <div id="sidebar">

                        <ul>
                            <li><a href="#">Profile</a></li>
                            <li><a href="{{ route('customer.notes',$customer->id)}}">Notes</a></li>
                            <li><a href="#">Invoice</a></li>
                            <li><a href="{{ route('customer.ticket',$customer->id)}}">Tickets</a></li>
                            <li><a href="#">Attachment</a></li>
                        </ul>


                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="w3-bar w3-black">
                            <button class="w3-bar-item w3-button" onclick="openCity('Customer')">Profile</button>
                            <button class="w3-bar-item w3-button" onclick="openCity('Billing')">Billing & Shipping</button>
                        </div>   
                        <div id="Customer" class="w3-container w3-display-container city">
                            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>                      
                            <h2>Customer Details</h2>
                            <div class="row">
                                {!! Form::open(['method' => 'post', 'id'=>'customer-form']) !!}     
                                <!-- CSRF Token -->
                                {!! Form::token() !!}                       
                                <input type="hidden" id="customer_id" name="customer_id" value="{{$customer->id}}">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="company"><small class="req text-danger">* </small>Company</label>
                                        <input type="text" class="form-control" name="company" id="company" value="{{$customer->company}}">
                                        <span id="company-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="company"><small class="req text-danger"></small>VAT Number</label>
                                        <input type="text" class="form-control" name="vat_number" id="vat_number" value="{{$customer->vat_number}}">
                                        <span id="vat_number-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="company"><small class="req text-danger"></small>Phone</label>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{$customer->phone_number}}">
                                        <span id="vat_number-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="website"><small class="req text-danger"></small>Website</label>
                                        <input type="text" class="form-control" name="website" id="website" value="{{$customer->website}}">
                                        <span id="website-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="groups"><small class="req text-danger"></small>Groups</label>
                                        <select class="form-select select2" name="groups[]" id="groups" multiple="multiple">                        
                                        <option value="High Budget" {{ (isset($customer->groups) && in_array("High Budget", explode(",",$customer->groups))) ? 'selected="selected"':''}}>High Budget</option>
                                        <option value="Low Budget" {{ (isset($customer->groups) && in_array("Low Budget", explode(",",$customer->groups))) ? 'selected="selected"':''}}>Low Budget</option>
                                        <option value="VIP" {{ (isset($customer->groups) && in_array("VIP", explode(",",$customer->groups))) ? 'selected="selected"':''}}>VIP</option>
                                        <option value="Wholesaler" {{ (isset($customer->groups) && in_array("Wholesaler", explode(",",$customer->groups))) ? 'selected="selected"':''}}>Wholesaler</option>
                                        </select>
                                        <span id="groups-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="currency"><small class="req text-danger"></small>Currency</label>
                                        <select class="form-control" name="currency" id="currency">
                                            <option value=""></option>
                                            <option value="USD" {{ (isset($customer->currancy) && $customer->currancy == 'USD')?'selected="selected"':''}}>USD <small class="text-muted">$</small></option>
                                            <option value="EUR" {{ (isset($customer->currancy) && $customer->currancy == 'EUR')?'selected="selected"':''}}>EUR <small class="text-muted">€</small></option>
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
                                            <option value="{{$language->id}}" {{(isset($customer->default_language) && $customer->default_language == $language->id) ?'selected="selected"':''}}>{{$language->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="default_language-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="address"><small class="req text-danger"></small>Address</label>
                                        <textarea class="form-control" name="address" id="address">{{$customer->address}}</textarea>
                                        <span id="address-err" class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="country"><small class="req text-danger"></small>Country</label>
                                        <select class="form-control" name="country" id="country">
                                            <option value="">Select</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{(isset($customer->country) && $customer->country == $country->id)?'selected="selected"':''}}>{{$country->name}}
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
                                            @foreach($states as $state)
                                                <option value="{{$customer->state}}" {{ (isset($customer->state) && $customer->state == $state->id)?'selected="selected"':''}}>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="state-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="city"><small class="req text-danger"></small>City</label>
                                        <input type="text" class="form-control" name="city" id="city" value="{{$customer->city}}">
                                        <span id="city-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="zipcode"><small class="req text-danger"></small>Zip Code</label>
                                        <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{$customer->zipcode}}">
                                        <span id="zipcode-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success">Submit</button>
                                </div>
                                {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div id="Billing" class="w3-container w3-display-container city">
                            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                            <h2>Billing & Shipping</h2>
                            {!! Form::open(['method' => 'post', 'id'=>'billing-form']) !!}     
                                <!-- CSRF Token -->
                                {!! Form::token() !!}  
                            <input type="hidden" id="customer_id" name="customer_id" value="{{$customer->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_address"><small class="req text-danger">* </small>Billing Address</label><label style="float:right"> Same as Customer Info</label>
                                        <textarea class="form-control" name="billing_address" id="billing_address">{{(isset($custbill->billing_address) && !empty($custbill->billing_address))?$custbill->billing_address:''}}</textarea>
                                        <span id="billing_address-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_address"><small class="req text-danger">* </small>Shipping Address</label><label style="float:right"> Copy as Customer Info</label>
                                        <textarea class="form-control" name="shipping_address" id="shipping_address">{{(isset($custbill->shipping_address) && !empty($custbill->shipping_address))?$custbill->shipping_address:''}}</textarea>
                                        <span id="shipping_address-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_city"><small class="req text-danger">* </small>City</label>
                                        <input type="text" class="form-control" name="billing_city" id="billing_city" value="{{(isset($custbill->billing_city) && !empty($custbill->billing_city))?$custbill->billing_city:''}}">
                                        <span id="billing_city-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_city"><small class="req text-danger">* </small>City</label>
                                        <input type="text" class="form-control" name="shipping_city" id="shipping_city" value="{{(isset($custbill->shipping_city) && !empty($custbill->shipping_city))?$custbill->shipping_city:''}}">
                                        <span id="shipping_city-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_country"><small class="req text-danger">* </small>Country</label>
                                        <select class="form-control" name="billing_country" id="billing_country">
                                            <option value="">Select</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{ (!empty($custbill->billing_country) && $custbill->billing_country == $country->id)?'selected="selected"':''}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="billing_country-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_country"><small class="req text-danger">* </small>Country</label>
                                        <select class="form-control" name="shipping_country" id="shipping_country">
                                            <option value="">Select</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{ (!empty($custbill->shipping_country) && $custbill->shipping_country == $country->id)?'selected="selected"':''}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="shipping_country-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_state"><small class="req text-danger">* </small>State</label>
                                        <select class="form-control" name="billing_state" id="billing_state">
                                            <option value="">Select</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ (!empty($custbill->billing_state) && $custbill->billing_state == $country->id)?'selected="selected"':''}}>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="billing_state-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_state"><small class="req text-danger">* </small>State</label>
                                        <select class="form-control" name="shipping_state" id="shipping_state">
                                            <option value="">Select</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ (!empty($custbill->shipping_state) && $custbill->shipping_state == $country->id)?'selected="selected"':''}}>{{$state->name}}</option>
                                                @endforeach
                                        </select>
                                        <span id="shipping_state-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="billing_zipcode"><small class="req text-danger">* </small>Zipcode</label>
                                        <input type="text" class="form-control" name="billing_zipcode" id="billing_zipcode" value="{{(!empty($custbill->billing_zipcode))?$custbill->billing_zipcode:''}}">
                                        <span id="billing_zipcode-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shipping_zipcode"><small class="req text-danger">* </small>Zipcode</label>
                                        <input type="text" class="form-control" name="shipping_zipcode" id="shipping_zipcode" value="{{!empty($custbill->shipping_zipcode)?$custbill->shipping_zipcode:''}}">
                                        <span id="shipping_zipcode-err" class="error"></span>                       
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
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
      $('.select2').select2({        
            templateResult: function (data) {
                console.log(data.text);
                return $('<span>').text(data.text).addClass(data.classes); // Preserve classes
            }
        });
        $(".smartsearch_keyword").select2({
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
        let selectedGroups = $('#groups').val();
        console.log("selectedGroups",selectedGroups);
        formData.append('groups', selectedGroups); 
        $.ajax({
            url: "{{ route('customer.update') }}",
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