@extends('layouts.admin')
@section('title', 'Leads')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Leads</h3>
      <ul class="breadcrumbs mb-3">
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
        
      </ul>
    </div>
    <a href="{{ route('lead.add') }}" class="btn btn-info">New Lead</a>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Leads</div>
          </div>
          <div class="card-body">
            <!-- <div class="card-sub">
              This is the basic table view of the ready dashboard :
            </div> -->
            <div class="col-12 table-responsive">
            <table class="table table-bordered user_datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Company</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Value</th>
                  <th scope="col">Tag</th>
                  <th scope="col">Assigned</th>
                  <th scope="col">Status</th>
                  <th scope="col">Source</th>
                  <th scope="col">Created</th>
                  <th scope="col">Action</th>
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
<script>
  $(function () {
    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('lead.list') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'company', name: 'company'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'lead_value', name: 'lead_value'},
            {data: 'tag', name: 'tag'},
            {data: 'staff', name: 'staff'},
            {data: 'lead', name: 'lead'},
            {data: 'source', name: 'source'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    
  });
</script>
@endsection
