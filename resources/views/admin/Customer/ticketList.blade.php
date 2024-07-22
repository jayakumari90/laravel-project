@extends('layouts.admin')
@section('title', 'Ticket')
@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<style>
    /* Your existing styles */
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
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div id="sidebar">
                            <ul>
                                <li><a href="{{ route('customer.show', $id) }}">Profile</a></li>
                                <li><a href="#">Notes</a></li>
                                <li><a href="#">Invoice</a></li>
                                <li><a href="#">Tickets</a></li>
                                <li><a href="#">Attachment</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('customer.ticket', $id) }}" class="btn btn-success" style="float:right">New Ticket</a>
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-bordered user_datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Tags</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Priority</th>
                                        <th scope="col">Last Reply</th>
                                        <th scope="col">Created</th>
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
</div>

<!-- Modal for updating notes -->
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
                            <textarea class="form-control" name="description" id="des-updated" rows="4"></textarea>
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
        ajax: {
            url: "{{ route('customer.ticketList', $id) }}",
            type: 'GET',
            dataType: 'json',
            error: function(xhr, error, code) {
                console.log('Error:', error);
                console.log('Code:', code);
                console.log('Response:', xhr.responseText);
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'subject', name: 'subject'},
            {data: 'tags', name: 'tags'},
            {data: 'department', name: 'department'},
            {data: 'service', name: 'service'},
            {data: 'status', name: 'status'},
            {data: 'priority', name: 'priority'},
            {data: 'reply', name: 'reply'},
            {data: 'created_at', name: 'created_at'}
        ]
    });
});

function addNotes() {
    $("#addnotes").toggle();
}

function updateTicketStatus(id, status) {
    $.ajax({
      url: "{{ route('customer.updateTicketStatus') }}",
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        id:id,
        status:status
      },
      success: function(response) {
        if(response.success) {
          Swal.fire(
            'Updated!',
            'Ticket status updated successfully.',
            'success'
          ).then(() => {
            $('.user_datatable').DataTable().ajax.reload();
          });
        } else {
          Swal.fire(
            'Error!',
            'Internal server error.',
            'error'
          );
        }
      }
    });
  }
</script>
@endsection
