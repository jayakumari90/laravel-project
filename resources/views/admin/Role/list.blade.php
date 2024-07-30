@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Roles</h3>
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
          <a href="#">Roles</a>
        </li>
      </ul>
    </div>
    <a href="{{ route('role.add') }}" class="btn btn-info">New Role</a>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Roles</div>
          </div>
          <div class="card-body">
            <div class="col-12 table-responsive">
              <table class="table table-bordered user_datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Role</th>
                    <th scope="col">Created</th>
                    <th scope="col">Status</th>
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
      ajax: "{{ route('role.list') }}",
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'role_type', name: 'role_type'},
        {data: 'created_at', name: 'created_at'},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]            
    });
  });

  function updateRoleStatus(role_id, statusId) {
    $.ajax({
      url: "{{ route('role.updateRoleStatus') }}",
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        role_id: role_id,
        status_id: statusId
      },
      success: function(response) {
        if(response.success) {
          Swal.fire(
            'Updated!',
            'Role status updated successfully.',
            'success'
          ).then(() => {
            window.location.href = "{{ route('role.updateRoleStatus') }}";
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
      var url = '{{ route("lead.export", ":format") }}';
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
