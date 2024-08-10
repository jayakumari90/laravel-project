@extends('layouts.admin')

@section('title', 'Customer')

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
      <h3 class="fw-bold mb-3">Customer</h3>
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
          <a href="#">Customer</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Customer</div>
          </div>
          <div class="card-body">
          
          <a href="{{ asset('assets/sample_customer_import_file.csv') }}" class="btn btn-success">Download Sample</a>

            <div class="col-12 table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Position</th>
                    <th scope="col">Company</th>
                    <th scope="col">Vat</th>
                    <th scope="col">Country</th>
                    <th scope="col">Zip	</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Address</th>
                    <th scope="col">Website</th>
                    <th scope="col">Billing Address</th>
                    <th scope="col">Billing City</th>
                    <th scope="col">Billing State</th>
                    <th scope="col">Billing Zip</th>
                    <th scope="col">Shipping Country</th>                    
                    <th scope="col">Shipping Street</th>
                    <th scope="col">Shipping City</th>
                    <th scope="col">Shipping State</th>
                    <th scope="col">Shipping Zip</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jack</td>
                        <td>Jack@gmail.com</td>
                        <td>7894569874</td>
                        <td>SEO</td>
                        <td>Test</td>
                        <td>DFF133</td>
                        <td>India</td>
                        <td>326589</td>
                        <td>Jaipur</td>
                        <td>Rajasthan	</td>
                        <td>c-45,sodala	</td>
                        <td>http://google.com	</td>
                        <td>Billing Address</td>
                        <td>Jaipur</td>
                        <td>Rajasthan	</td>
                        <td>235689	</td>
                        <td>India	</td>
                        <td>street	</td>
                        <td>Jaipur	</td>
                        <td>Rajasthan	</td>
                        <td>789859	</td>
                    </tr>
                </tbody>
              </table>
            </div>
            <br />
            <form action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="groups"><small class="req text-danger"></small>Groups</label>
                        <select class="form-select select2" name="groups[]" id="groups" multiple="multiple">                        
                        <option value="High Budget">High Budget</option>
                        <option value="Low Budget">Low Budget</option>
                        <option value="VIP">VIP</option>
                        <option value="Wholesaler">Wholesaler</option>
                        </select>
                        <span id="groups-err" class="error"></span>                       
                    </div>
                </div>
                
              </div>
                <button class="btn btn-primary">Import Customer</button>
            </form>
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
</script>
@endsection
