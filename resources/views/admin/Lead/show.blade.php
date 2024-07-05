@extends('layouts.admin')
@section('title', 'Leads')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Leads</h3>
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
        
      </ul> -->
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Lead Detail</div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-1">
                  <a href="{{route('lead.edit',$leads->id)}}" title="edit lead"><i class="fas fa-pen-square"></i>Edit</a>
              </div>
              <div class="col-sm-3">
                <select class="form-control" id="lead_more" name="lead_more">
                  <option value="">More</option>
                  <option value="7">Mark as Lost</option>
                  <option value="2">Mark as Junk</option>
                  <option value="delete">Delete Lead</option>
                </select>
              </div>
              <div class="col-sm-3">
                <div class="cutomer-btn"></div>
              </div>
            </div>
            <div class="col-12 table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Name : </th>
                  <td>{{$leads->name}}</td>
                </tr>
                <tr>
                  <th scope="col">Company : </th>
                  <td>{{$leads->company}}</td>
                </tr>
                <tr>
                  <th scope="col">Email : </th>
                  <td>{{$leads->email}}</td>
                </tr>
                <tr>
                  <th scope="col">Phone</th>
                  <td>{{$leads->phone}}</td>
                </tr>
                <tr>
                  <th scope="col">Address</th>
                  <td>{{$leads->address}}</td>
                </tr>
                <tr>
                  <th scope="col">Position</th>
                  <td>{{$leads->position}}</td>
                </tr>
                <tr>
                  <th scope="col">Country</th>
                  <td>{{$leads->getCountry->name}}</td>
                </tr>
                <tr>
                  <th scope="col">State</th>
                  <td>{{$leads->getState->name}}</td>
                </tr>
                <tr>
                  <th scope="col">Value</th>
                  <td>{{$leads->lead_value}}</th>
                </tr>
                <tr>
                  <th scope="col">Tag</th>
                  <td>{{$leads->tag}}</td>
                </tr>
                <tr>
                  <th scope="col">Assigned</th>
                  <td>{{$leads->getStaff->name}}</td>
                </tr>
                <tr>
                  <th scope="col">Status</th>
                  <td>{{$leads->getLeadStatus->lead}}</td>
                </tr>
                <tr>
                  <th scope="col">Source</th>
                  <td>{{$leads->getSource->source}}</td>
                </tr>
                <tr>
                  <th scope="col">Website</th>
                  <td>{{$leads->website}}</td>
                </tr>
                <tr>
                  <th scope="col">Default Language</th>
                  <td>{{$leads->getDefaultLanguage->name}}</td>
                </tr>
                <tr>
                  <th scope="col">Description</th>
                  <td>{{$leads->description}}</td>
                </tr>
                <tr>
                  <th scope="col">Public Lead</th>
                  <td>{{($leads->lead_public==1)?'Yes':'No'}}</td>
                </tr>
                <tr>
                  <th scope="col">Contacted Today</th>
                  <td>{{($leads->contacted_today==1)?'Yes':'No'}}</td>
                </tr>
                <tr>
                  <th scope="col">Created</th>
                  <td>{{$leads->created_at}}</td>
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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$('#lead_more').on('change', function() {
  if ($(this).val() != 'delete') {
    var tag = `<a href="{{ route('lead.customer',$leads->id) }}" title="Convert to Customer" class="btn btn-success">Convert to Customer</a>`;
    $('.cutomer-btn').html(tag);
  } else {
    Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to delete this lead?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "{{ route('lead.delete',$leads->id) }}",
          method: "GET",
          data: {
            _token: "{{ csrf_token() }}",
            lead_id: {{ $leads->id }}
          },
          success: function(response) {
            if(response.success) {
              Swal.fire(
                'Deleted!',
                'The lead has been deleted.',
                'success'
              ).then(() => {
                window.location.href = "{{ route('lead.list') }}";
              });
            } else {
              Swal.fire(
                'Error!',
                'There was an error deleting the lead.',
                'error'
              );
            }
          }
        });
      }
    });
  }
});
</script>
@endsection
