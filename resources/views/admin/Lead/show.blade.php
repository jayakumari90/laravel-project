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
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Lead Detail</div>
          </div>
          <div class="card-body">
            <!-- <div class="card-sub">
              This is the basic table view of the ready dashboard :
            </div> -->
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

@endsection
