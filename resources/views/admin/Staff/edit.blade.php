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
              
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                  <div class="row">
                                {!! Form::open(['method' => 'post', 'id'=>'staff-form']) !!}     
                                <!-- CSRF Token -->
                                {!! Form::token() !!}                       
                                <input type="hidden" id="staff_id" name="staff_id" value="{{$staff->id}}">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="name"><small class="req text-danger">* </small>Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{$staff->name}}">
                                        <span id="name-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="email"><small class="req text-danger"></small>Email</label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{$staff->email}}">
                                        <span id="email-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="phone_number"><small class="req text-danger"></small>Phone</label>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{$staff->phone_number}}">
                                        <span id="phone_number-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="address"><small class="req text-danger"></small>Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="{{$staff->address}}">
                                        <span id="address-err" class="error"></span>                       
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control" id="position" placeholder="Position" name="position" value="{{$staff->position}}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="department">Member Departments</label><br/>
                                        
                                        <input type="checkbox" name="department[]" value="Marketing" {{ (!empty($staff->department) && in_array('Marketing', explode(',', $staff->department))) ? 'checked' : '' }} />Marketing<br/>
                                        <input type="checkbox" name="department[]" value="Sales" {{ (!empty($staff->department) && in_array('Sales', explode(',', $staff->department))) ? 'checked' : '' }} />Sales<br/>
                                        <input type="checkbox" name="department[]" value="Abuse" {{ (!empty($staff->department) && in_array('Abuse', explode(',', $staff->department))) ? 'checked' : '' }} />Abuse
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
$('#lead-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        let selectedTags = $('#tasks').val();
        console.log("selectedTags",selectedTags);
        formData.append('tag', selectedTags); 
        $.ajax({
            url: "{{ route('lead.update') }}",
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