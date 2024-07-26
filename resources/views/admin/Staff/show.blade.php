@extends('layouts.admin')
@section('title', 'View Staff')
@section('content')
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
            <h3 class="fw-bold mb-3">Staff</h3>
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
             
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                         <h2>Staff Details</h2>
                            <div class="row">
                            <div class="col-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                            <th scope="col">Name : </th>
                                            <td>{{$staff->name}}</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Email : </th>
                                            <td>{{$staff->email}}</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Phone</th>
                                            <td>{{$staff->phone_number}}</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Address</th>
                                            <td>{{$staff->address}}</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Position</th>
                                            <td>{{$staff->position}}</td>
                                            </tr>
                                            <th scope="col">Department</th>
                                            <td>{{$staff->department}}</td>
                                            </tr>
                                            <tr>
                                            <th scope="col">Created</th>
                                            <td>{{$staff->created_at}}</td>
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
$('#customer-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        let selectedGroups = $('#groups').val();
        console.log("selectedGroups",selectedGroups);
        formData.append('groups', selectedGroups); 
        $.ajax({
            url: "{{ route('customer.update') }}",
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
            }
        });
    });
    $('#billing-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        
        $.ajax({
            url: "{{ route('customer.updatebill') }}",
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
            }
        });
    });
    function openCity(cityName) {
        var i;
        var x = document.getElementsByClassName("city");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(cityName).style.display = "block";
    }
    </script>
@endsection