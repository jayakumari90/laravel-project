@extends('layouts.admin')

@section('title', 'Leads')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Leads</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Lead Detail</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="w3-bar w3-black">
                                <button class="w3-bar-item w3-button" onclick="openCity('Profile')">Profile</button>
                                <button class="w3-bar-item w3-button" onclick="openCity('Attachment')">Attachment</button>
                                <button class="w3-bar-item w3-button" onclick="openCity('Notes')">Notes</button>
                            </div>      
                            <div id="Profile" class="w3-container w3-display-container city">
                                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                                <h2>Profile</h2>
                                <!-- Profile content -->
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
                            <div id="Attachment" class="w3-container w3-display-container city" style="display:none">
                                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                                <h2>Attachment</h2>
                                <form action="" method="post" id="dropbox-form" enctype="multipart/form-data">
                                  @csrf
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input type="hidden" name="lead_id" value="{{$leads->id}}">
                                            <input type="file" class="form-control" name="attachments[]" id="attachments" multiple>
                                        </div>
                                        <div id="upload-result" class="mt-3"></div>
                                    </div>
                                </form>
                                <div class="col-sm-12" id="result">
                                    @foreach($leadfile as $file)
                                        <img src="{{asset('uploads/').'/'.$file->image}}" width="100px">
                                    @endforeach
                                </div>
                            </div>
                            <div id="Notes" class="w3-container w3-display-container city" style="display:none">
                                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                                <h2>Notes</h2>
                                {!! Form::open(['method' => 'post', 'id'=>'lead-notes']) !!}
            
                                <!-- CSRF Token -->
                                {!! Form::token() !!}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="hidden" name="lead_id" value="{{$leads->id}}">
                                            <textarea class="form-control" name="note" id="note" row="30" col="20"></textarea>
                                        </div>
                                        <div class="col-sm-12" id="date-div" style="display:none">
                                            <label>Date Connected</label>
                                            <input type="date" class="form-control" name="date" id="date">
                                        </div>
                                        <div class="col-sm-12">
                                        <input type="radio" name="is_connacted" class="is_connacted" value="1">I got in touch with this lead<br />
                                        <input type="radio" name="is_connacted" class="is_connacted" value="0">I have not contacted this lead
                                        </div>
                                        <div class="col-sm-6">
                                        <button class="btn btn-info">Save</button>
                                        </div>
                                        <div id="note-result" class="mt-3"></div>
                                    </div>
                                    {!! Form::close() !!}
                                <div class="col-sm-12" id="notes">
                                    @foreach($leadnotes as $notes)

                                    @endforeach
                                </div>
                            </div>
                            <!-- Additional content sections -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.is_connacted').on('click', function(){
        if($(this).val() == 1){
            $('#date-div').show();
        }else{
            $('#date-div').hide();
        }
    })
    $('#lead-notes').on('submit', function(event){
        event.preventDefault();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name=_token]').val()
            }
        });

        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("lead.addNotes") }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#notes').html(response.data);
                $('#note-result').html('<div class="alert alert-success">' + response.success + '</div>');
                setTimeout(() => {
                    $('#note-result').html('');
                }, 1000);
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                let errorHtml = '<div class="alert alert-danger"><ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value + '</li>';
                });
                errorHtml += '</ul></div>';
                $('#note-result').html(errorHtml);
            }
        });
    });
    $('#attachments').on('change', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name=_token]').val()
            }
        });
        let formData = new FormData($('#dropbox-form')[0]);
        
        $.ajax({
            url: '{{ route("lead.uploadFile") }}',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#result').html(response.data);
                $('#upload-result').html('<div class="alert alert-success">' + response.success + '</div>');
                setTimeout(() => {
                    $('#upload-result').html('');
                }, "1000");
                
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                let errorHtml = '<div class="alert alert-danger"><ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value + '</li>';
                });
                errorHtml += '</ul></div>';
                $('#upload-result').html(errorHtml);
            }
        });
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
