@extends('layouts.admin')
@section('title', 'Add Ticket')
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
            <h3 class="fw-bold mb-3">Ticket</h3>
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
                                <li><a href="{{ route('customer.notes',$id)}}">Notes</a></li>
                                <li><a href="#">Invoice</a></li>
                                <li><a href="{{ route('customer.ticketList',$id)}}">Tickets</a></li>
                                <li><a href="#">Attachment</a></li>
                            </ul>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                    <!-- <div class="card-title">Form Elements</div> -->
                    </div>
                    <div class="card-body">
                    {!! Form::open(['method' => 'post', 'id'=>'ticket-form']) !!}
                
                    <!-- CSRF Token -->
                    {!! Form::token() !!}
                    <input type="hidden" name="customer_id" id="cust_id" value="{{$id}}">
                    <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="subject"><small class="req text-danger">* </small>Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject">
                            <span id="subject-err" class="error"></span>                       
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="tages">Tages</label>
                            <select class="form-select select2" name="tag[]" id="tfgyhtygfuytutyyu" multiple="multiple">
                            
                            @foreach($tags as $tag)
                            <option value="{{ $tag->tag_name}}">{{ $tag->tag_name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="staff">Assigned</label>
                            <select class="form-select select2" id="staff" name="staff">
                                <option value=""></option>
                                @foreach($staffs as $staff)
                                <option value="{{ $staff->id}}">{{ $staff->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">   
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email">   
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority"> 
                                <option value="">Select</option>
                                <option value="Low">Low</option>    
                                <option value="Medium">Medium</option>    
                                <option value="High">High</option>    
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="staff">Service</label>
                            <select class="form-control" id="service" name="service">   
                                <option value="">Select</option>
                                <option value="Test">Test</option>
                                <option value="Test1">Test1</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <select class="form-control" id="department" name="department">  
                                <option value="">Select</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Sales">Sales</option>
                                <option value="Abuse">Abuse</option>
                            </select>
                            <span id="department-err" class="error"></span>   
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="cc">CC</label>
                            <input type="text" class="form-control" id="cc" name="cc">  
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <label for="ticket_body">Ticket Body</label>
                            <select class="form-control" id="ticket_body" name="ticket_body">  
                                <option value="">Select</option>
                                <option value="Next Came">Next Came</option>
                                <option value="OURS They">OURS They</option>
                                <option value="They all set down again very sadly and quitly, and.">They all set down again very sadly and quitly, and.</option>
                                <option value="Alice continously replied: but I">Alice continously replied: but I</option>
                                <option value="Duchess asked, with another dig of her sister">Duchess asked, with another dig of her sister</option>
                            </select> 
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                            <input type="text" class="form-control" name="body" id="body">                        
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-4">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description"  name="description" row="100" col="70">  </textarea> 
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-4">
                        <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control" id="attachment"  name="attachment"> 
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
$('#ticket-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        let selectedTags = $('#tfgyhtygfuytutyyu').val();
        console.log("selectedTags",selectedTags);
        formData.append('tag', selectedTags); 
        $.ajax({
            url: "{{ route('customer.storeTicket') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log('data',data);
                if(data.status){
                    window.location.href=data.redirect_url;
                }else{
                    let errors = data;
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