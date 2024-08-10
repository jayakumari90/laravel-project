@extends('layouts.admin')
@section('title', 'Notes')
@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
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
    color: #21258a;
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
                  <div class="card-body">
                    <button class="btn btn-success" style="float:right" onclick="addNotes()">New Note</button>
                    <div class="col-sm-12" id="addnotes" style="display:none">
                        {!! Form::open(['method' => 'post', 'id'=>'notes-form']) !!}     
                                <!-- CSRF Token -->
                        {!! Form::token() !!}  
                            <input type="hidden" name="customer_id" id="customer_id" value="{{$id}}">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="description"><small class="req text-danger">* </small>Notes Description</label>
                                    <textarea class="form-control" name="description" id="description" row="50" col="30"></textarea>
                                    <span id="description-err" class="error"></span>                       
                                </div>
                            </div>
                            <div class="card-action">
                                    <button class="btn btn-success">Submit</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                  <div class="col-12 table-responsive">
                            <table class="table table-bordered user_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Added From</th>
                                    <th scope="col">Date Added</th>
                                    <th scope="col">Optiona</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                </div>
              </div>
            </div>
        
    </div>
</div>
<div class="modal" tabindex="-1" id="openModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['method' => 'post', 'id'=>'notes-update']) !!}     
        {!! Form::token() !!}          
      <div class="modal-body">
        <input type="hidden" name="note_id" id="note_id">
        <input type="hidden" name="customer_id" id="cust_id">
        <div class="col-md-12">
            <div class="form-group">
                <label for="description"><small class="req text-danger">* </small>Notes Description</label>
                <textarea class="form-control" name="description" id="des-updated" row="150" col="30"></textarea>
                <span id="description-err" class="error"></span>                       
            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    {!! Form::close() !!}
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>

$(document).ready(function() {
    var table = $('.user_datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('customer.notes',$id) }}",
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'description', name: 'description'},
        {data: 'added_by', name: 'added_by'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action'}
      ]            
    });
  });
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
$('#notes-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('customer.addnotes') }}",
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
$('#notes-update').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('customer.addnotes') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log('data',data);
                if(data.status){
                    $('#openModal').hide();
                    $('.user_datatable').DataTable().ajax.reload();
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
function addNotes(){
    $("#addnotes").toggle();
  }
function updateNote(id){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});  
    $.ajax({
            url: "{{ route('customer.getnotes') }}",
            type: 'POST',
            data: {
            'id': id,
        },
            // processData: false,
            // contentType: false,
            success: function(data) {
                console.log('data',data);
                if(data.status){
                    $('#note_id').val(id);
                    $('#cust_id').val(data.data.customer_id);
                    $('#des-updated').text(data.data.description);
                    $('#openModal').show();
                }else{
                    let errors = data.data;
                    for (let key in errors) {
                        $('#'+key+'-err').text(errors[key]);
                    }
                }
            }
        });
    
}
    </script>
@endsection