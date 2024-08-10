@extends('layouts.admin')

@section('title', 'Leads')

@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<style>
    .custom-file-input{
        outline: auto;
        color: darkgray;
    }
</style>
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
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Leads</div>
          </div>
          <div class="card-body">
          
          <a href="{{ asset('assets/sample_import_file.csv') }}" class="btn btn-success">Download Sample</a>

            <div class="col-12 table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Position</th>
                    <th scope="col">Company</th>
                    <th scope="col">Description</th>
                    <th scope="col">Country</th>
                    <th scope="col">Zip	</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Address</th>
                    <th scope="col">Status</th>
                    <th scope="col">Source</th>
                    <th scope="col">Email</th>
                    <th scope="col">Website</th>
                    <th scope="col">Phonenumber</th>
                    <th scope="col">Lead value	</th>
                    <th scope="col">Tag</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jhon</td>
                        <td>CEO</td>
                        <td>Company name</td>
                        <td>Test</td>
                        <td>India</td>
                        <td>323232</td>
                        <td>Jaipur	</td>
                        <td>Rajasthan</td>
                        <td>Address</td>
                        <td>New</td>
                        <td>FB</td>
                        <td>test@gmail.com	</td>
                        <td>http://google.com</td>
                        <td>7894569878</td>
                        <td>30</td>
                        <td>tag1,tag2</td>
                    </tr>
                </tbody>
              </table>
            </div>
            <br />
            <form action="{{ route('lead.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="form-group" app-field-wrapper="file_csv">
                        <label for="leads"><small class="req text-danger">* </small>Choose CSV File</label>
                        <input type="file" name="file" class="custom-file-input" id="customFile">
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="leads"><small class="req text-danger">* </small>Lead</label>
                        <select class="form-select select2" id="leads" name="lead">
                        <option value=""></option>
                        @foreach($lead_status as $lead)
                        <option value="{{ $lead->id}}">{{ $lead->lead}}</option>
                        @endforeach
                        </select>  
                        <span id="lead-err" class="error"></span>                       
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
                
</div>
                <button class="btn btn-primary">Import Users</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
