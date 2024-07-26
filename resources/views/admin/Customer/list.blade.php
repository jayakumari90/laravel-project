@extends('layouts.admin')

@section('title', 'Customer')

@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<style>
  a {
	outline: none;
	text-decoration: none;
	color: #555;
}
a:hover, a:focus {
	outline: none;
	text-decoration: none;
}
img {
	border: 0;
}
input, textarea, select {
	outline: none;
	resize: none;
	font-family: 'Muli', sans-serif;
}
a, input, button {
	outline: none !important;
}
 button::-moz-focus-inner {
 border: 0;
}
h1, h2, h3, h4, h5, h6 {
	margin: 0;
	padding: 0;
	font-weight: 700;
	color: #202342;
	font-family: 'Muli', sans-serif;
}
img {
	border: 0;
	vertical-align: top;
	max-width: 100%;
	height: auto;
}
ul, ol {
	margin: 0;
	padding: 0;
	list-style: none;
}
p {
	margin: 0 0 15px 0;
	padding: 0;
}

.container-fluid{
	max-width: 1900px;
}

/* Common Class */
.pd-5{padding: 5px;}
.pd-10{padding: 10px;}
.pd-20{padding: 20px;}
.pd-30{padding: 30px;}
.pb-10{padding-bottom: 10px;}
.pb-20{padding-bottom: 20px;}
.pb-30{padding-bottom: 30px;}
.pt-10{padding-top: 10px;}
.pt-20{padding-top: 20px;}
.pt-30{padding-top: 30px;}
.pr-10{padding-right: 10px;}
.pr-20{padding-right: 20px;}
.pr-30{padding-right: 30px;}
.pl-10{padding-left: 10px;}
.pl-20{padding-left: 20px;}
.pl-30{padding-left: 30px;}
.px-30{padding-left: 30px; padding-right: 30px;}
.px-20{padding-left: 20px; padding-right: 20px;}
.py-30{padding-top: 30px; padding-bottom: 30px;}
.py-20{padding-top: 20px; padding-bottom: 20px;}
.mb-30{margin-bottom: 30px;}
.mb-50{margin-bottom: 50px;}

.font-30{font-size: 30px; line-height: 1.46em;}
.font-24{font-size: 24px; line-height: 1.5em;}
.font-20{font-size: 20px; line-height: 1.5em;}
.font-18{font-size: 18px; line-height: 1.6em;}
.font-16{font-size: 16px; line-height: 1.75em;}
.font-14{font-size: 14px; line-height: 1.85em;}
.font-12{font-size: 12px; line-height: 2em;}

.weight-300{font-weight: 300;}
.weight-400{font-weight: 400;}
.weight-500{font-weight: 500;}
.weight-600{font-weight: 600;}
.weight-700{font-weight: 700;}
.weight-800{font-weight: 800;}

.text-blue{color: #1b00ff;}
.text-dark{color: #000000;}
.text-white{color: #ffffff;}
.height-100-p{height: 100%;}
.bg-white{background: #ffffff;}
.border-radius-10{
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
}
.border-radius-100{
	-webkit-border-radius: 100%;
	-moz-border-radius: 100%;
	border-radius: 100%;
}
.box-shadow{
	-webkit-box-shadow: 0px 0px 28px rgba(0, 0, 0, .08);
	-moz-box-shadow: 0px 0px 28px rgba(0, 0, 0, .08);
	box-shadow: 0px 0px 28px rgba(0, 0, 0, .08);
}

.gradient-style1{
	background-image: linear-gradient( 135deg, #43CBFF 10%, #9708CC 100%);
}
.gradient-style2{
	background-image: linear-gradient( 135deg, #72EDF2 10%, #5151E5 100%);
}
.gradient-style3{
	background-image: radial-gradient( circle 732px at 96.2% 89.9%,  rgba(70,66,159,1) 0%, rgba(187,43,107,1) 92% );
}
.gradient-style4{
	background-image: linear-gradient( 135deg, #FF9D6C 10%, #BB4E75 100%);
}

/* widget style 1 */

.widget-style1{
	padding: 20px 10px;
}
.widget-style1 .circle-icon{
	width: 60px;
}
.widget-style1 .circle-icon .icon{
	width: 60px;
	height: 60px;
	background: #ecf0f4;
	display: flex;
	align-items: center;
	justify-content: center;
}
.widget-style1 .widget-data{
	width: calc(100% - 150px);
	padding: 0 15px;
}
.widget-style1 .progress-data{
	width: 90px;
}
.widget-style1 .progress-data .apexcharts-canvas{
	margin: 0 auto;
}

.widget-style2 .widget-data{
	padding: 20px;
}

.widget-style3{
	padding: 30px 20px;
}
.widget-style3 .widget-data{
	width: calc(100% - 60px);
}
.widget-style3 .widget-icon{
	width: 60px;
	font-size: 45px;
	line-height: 1;
}

.apexcharts-legend-marker{
	margin-right: 6px !important;
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
     <a href="{{ route('customer.add') }}" class="btn btn-info">New Customer</a>
    <a href="{{ route('customer.importcustomer') }}" class="btn btn-info">Import Customer</a>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Customer</div>
            <div class="row">
            <div class="container-fluid pt-5 mt-5 pb-5">
	
              <!-- Widget Style 1 Start -->
                <div class="row">
                  <div class="col-xl-4 mb-50">
                    <div class="bg-white box-shadow border-radius-10 height-100-p widget-style1">
                      <div class="d-flex flex-wrap align-items-center">
                        <div class="widget-data">
                          <div class="weight-800 font-18">{{$totalcustomer}}</div>
                          <div class="weight-500">Total Customers</div>
                        </div>
                        <div class="progress-data">
                          <div id="chart"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 mb-50">
                    <div class="bg-white widget-style1 border-radius-10 height-100-p box-shadow">
                      <div class="d-flex flex-wrap align-items-center">
                        <div class="widget-data">
                          <div class="weight-800 font-18">{{$totalactive}}</div>
                          <div class="weight-500">Active Customers</div>
                        </div>
                        <div class="progress-data">
                          <div id="chart2"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 mb-50">
                    <div class="bg-white box-shadow border-radius-10 height-100-p widget-style1">
                      <div class="d-flex flex-wrap align-items-center">
                        <div class="widget-data">
                          <div class="weight-800 font-18">{{$totalinactive}}</div>
                          <div class="weight-500">Inactive Customers</div>
                        </div>
                        <div class="progress-data">
                          <div id="chart3"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
          
            <div class="col-sm-2">
              <select class="form-control" name="export" id="export" onClick="exportCustomers(this.value)">
                <option value="">Export</option>
                <option value="xlsx">Excel</option>
                <option value="csv">Csv</option>
                <option value="pdf">Pdf</option>
                <!-- <option value="print">Print</option> -->
              </select>
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-bordered user_datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Company</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Active</th>
                    <th scope="col">Groups</th>
                    <th scope="col">Date Created</th>
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
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>s
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function() {
    var table = $('.user_datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('customer.list') }}",
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'company', name: 'company'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'phone_number', name: 'phone_number'},
        {data: 'status', name: 'status'},
        {data: 'groups', name: 'groups'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]            
    });
  });

  function exportCustomers(format) {
    if(format != '' && format != 'export'){
      var url = '{{ route("customer.export", ":format") }}';
        url = url.replace(':format', format);
        $.ajax({
            url: url,
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data) {
                var blob = new Blob([data], { type: data.type });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'customer.' + format;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX call failed: ' + textStatus + ', ' + errorThrown);
            }
        });
    }
    
  }
  
</script>
@endsection
