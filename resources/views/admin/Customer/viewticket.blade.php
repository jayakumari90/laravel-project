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
                                <li><a href="{{route('customer.show', $id)}}">Profile</a></li>
                                <li><a href="{{ route('customer.notes',$id)}}">Notes</a></li>
                                <!-- <li><a href="#">Invoice</a></li> -->
                                <li><a href="{{ route('customer.ticketList',$id)}}">Tickets</a></li>
                                <!-- <li><a href="#">Attachment</a></li> -->
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
                        <table class="table table-bordered">
                            <tr>
                                <th>Subject</th>
                                <td>{{$ticket->subject}}</td>
                                <th>Tags</th>
                                <td>{{$ticket->tags}}</td>
                            </tr>
                            <tr>
                                <th>Assigned</th>
                                <td>{{$ticket->assigned}}</td>
                                <th>Name</th>
                                <td>{{$ticket->name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$ticket->email}}</td>
                                <th>Priority</th>
                                <td>{{$ticket->priority}}</td>
                            </tr>
                            <tr>
                                <th>Service</th>
                                <td>{{$ticket->service}}</td>
                                <th>Department</th>
                                <td>{{$ticket->department}}</td>
                            </tr>
                            <tr>
                                <th>CC</th>
                                <td>{{$ticket->cc}}</td>
                                <th>Ticket Body</th>
                                <td>{{$ticket->ticket_body}}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{$ticket->description}}</td>
                                <th>Attachment</th>
                                <td><a href="{{asset('uploads/').'/'.$ticket->attachment}}" target="_blank"><img src="{{asset('uploads/').'/'.$ticket->attachment}}" width="100px"></a></td>
                            </tr>
                        </table>

                            {!! Form::open(['method' => 'post', 'id'=>'ticket-form']) !!}
                            
                                <!-- CSRF Token -->
                                {!! Form::token() !!}
                                <div class="row">
                                
                                 <input type="hidden" name="customer_id" id="customer_id" value="{{$ticket->customer_id}}">           
                                 <input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticket->id}}">           
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <textarea class="form-control" id="note" name="note" row="3" col="50"></textarea>
                                    </div>
                                </div>
                                
                                <div class="card-action">
                                    <button class="btn btn-success">Submit</button>
                                </div>
                                {!! Form::close() !!}
                                <div class="col-sm-12" id="notes">
                                    @foreach($ticketnotes as $notes)
                                    <!-- @if(Auth::user()->avatar && !empty(Auth::user()->avatar))
                                        <img src="{{asset(Auth::user()->avatar)}}" class="img-radius shadow" alt="User-Profile-Image" style="height:30px;" />
                                    @else
                                        <img src="{{asset('assets/img/profile.jpg')}}" class="img-radius shadow" alt="User-Profile-Image" style="height:30px;" />
                                    @endif -->
                                    <h3>{{$notes->getCustomer->name}}</h3><p>Note added:{{date('d-m-Y H:i', strtotime($notes->created_at))}}</p><p>{{$notes->note}}</p>
                                    @endforeach
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
$('#ticket-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
       
        $.ajax({
            url: "{{ route('customer.storeTicketNote') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log('data',data.redirect_url);
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