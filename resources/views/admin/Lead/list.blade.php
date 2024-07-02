@extends('layouts.admin')

@section('title', 'Leads')

@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

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
          
            <div class="col-sm-2">
              <select class="form-control" name="export" id="export" onClick="exportLeads(this.value)">
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
      ajax: "{{ route('lead.list') }}",
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
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
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]            
    });
  });

  function updateLeadStatus(leadId, statusId) {
    $.ajax({
      url: "{{ route('lead.updateLeadStatus') }}",
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        lead_id: leadId,
        status_id: statusId
      },
      success: function(response) {
        if(response.success) {
          Swal.fire(
            'Updated!',
            'Lead status updated successfully.',
            'success'
          ).then(() => {
            window.location.href = "{{ route('lead.list') }}";
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

  function exportLeads(format) {
    if(format != '' && format != 'export'){
      var url = "{{ route('lead.export',":format") }}";
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
                a.download = 'leads.' + format;
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
