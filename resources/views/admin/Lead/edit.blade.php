@extends('layouts.admin')
@section('title', 'Edit Lead')
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
                <div class="card-header">
                <!-- <div class="card-title">Form Elements</div> -->
                </div>
                <div class="card-body">
                {!! Form::open(['method' => 'post', 'id'=>'lead-form']) !!}
            
                <!-- CSRF Token -->
                {!! Form::token() !!}
                <div class="row">
                    <input type="hidden" name="lead_id" id="lead_id" value="{{$lead_data->id}}">
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="leads"><small class="req text-danger">* </small>Lead</label>
                        <select class="form-select select2" id="leads" name="lead">
                        <option value=""></option>
                        @foreach($lead_status as $lead)
                        <option value="{{ $lead->id}}" {{ ($lead_data->lead && $lead_data->lead == $lead->id) ? 'selected="selected"' : '' }}>{{ $lead->lead}}</option>
                        @endforeach
                        </select>  
                        <span id="lead-err" class="error"></span>                       
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="source"><small class="req text-danger">* </small>Source</label>
                        <select class="form-select select2" id="sources" name="source">
                            <option value=""></option>
                            @foreach($source as $val)
                            <option value="{{ $val->id}}" {{ ($lead_data->source && $lead_data->source == $val->id) ? 'selected="selected"' : '' }}>{{ $val->source}}</option>
                            @endforeach
                        </select>
                        <span id="source-err" class="error"></span> 
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="staff">Assigned</label>
                        <select class="form-select select2" id="staff" name="staff">
                            <option value=""></option>
                            @foreach($staffs as $staff)
                            <option value="{{ $staff->id}}" {{ ($lead_data->staff && $lead_data->staff == $staff->id) ? 'selected="selected"' : '' }}>{{ $staff->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="tages">Tages</label>
                        <select class="form-select select2" name="tag[]" id="tasks" multiple="multiple">
                        
                        @foreach($tags as $tag)
                        <option value="{{ $tag->tag_name}}" {{ ($lead_data->tag && in_array($tag->tag_name,explode(",",$lead_data->tag))) ? 'selected="selected"' : '' }}>{{ $tag->tag_name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="cname" placeholder="Name" name="name" value="{{($lead_data->name)?$lead_data->name:''}}" />
                        <span id="name-err" class="error"></span> 
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="cemail" placeholder="Email" name="email" value="{{($lead_data->email)?$lead_data->email:''}}" />
                        <span id="email-err" class="error"></span> 
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone-no" placeholder="Phone" name="phone" value="{{($lead_data->phone)?$lead_data->phone:''}}" />
                        <span id="phone-err" class="error"></span> 
                    </div>
                </div>
                               
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" row="3" col="15">{{ ($lead_data->address)?$lead_data->address:''}}</textarea>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" class="form-control" id="position" placeholder="Position" name="position" value="{{($lead_data->position)?$lead_data->position:''}}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select class="form-select" id="country" name="country">
                        <option value=""></option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{($lead_data->country && $lead_data->country == $country->id)?'selected="selected"':''}}>{{ $country->name }}</option>
                        @endforeach
                        </select>   
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="state">State</label>
                        <select class="form-select" id="state" name="state">
                        <option value=""></option>
                        @foreach($states as $state)
                        <option value="{{$state->id}}" {{($lead_data->state && $lead_data->state == $state->id)?'selected="selected"':''}}>{{ $state->name}}</option>
                        @endforeach
                        </select>   
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" placeholder="City" name="city" value="{{($lead_data->city)?$lead_data->city:''}}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" class="form-control" id="website" placeholder="Website" name="website" value="{{($lead_data->website)?$lead_data->website:''}}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="lead_value">Lead Value</label>
                        <input type="text" class="form-control" id="lead_value" placeholder="Lead Value" name="lead_value" value="{{($lead_data->lead_value)?$lead_data->lead_value:''}}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="default_language">Default Language</label>
                        <select class="form-select select2" id="default_language" name="default_language">
                        <option value=""></option>
                        @foreach($languages as $language)
                        <option value="{{$language->id}}" {{($lead_data->default_language && $lead_data->default_language == $language->id)?'selected="selected"':''}}>{{$language->name}}
                        @endforeach
                        </select>   
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" id="company" placeholder="Company" name="company" value="{{($lead_data->company)?$lead_data->company:''}}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea row="3" col="15" class="form-control" id="description" placeholder="Description" name="description">{{($lead_data->description)?$lead_data->description:''}}</textarea>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <input type="checkbox" id="is_public" name="is_public" value="1" {{($lead_data->lead_public && $lead_data->lead_public == 1)?'checked':''}}> Public    
                        <input type="checkbox" id="contacted_today" name="contacted_today" value="1" {{($lead_data->contacted_today && $lead_data->contacted_today == 1)?'checked':''}}> Contacted Today    
                    </div>
                </div>
                
                <div class="card-action">
                <button class="btn btn-success">Submit</button>
                <button class="btn btn-danger">Cancel</button>
                </div>
                {!! Form::close() !!}
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
$('#lead-form').on('submit', function(event) {
    event.preventDefault();
        let formData = new FormData(this);
        let selectedTags = $('#tasks').val();
        console.log("selectedTags",selectedTags);
        formData.append('tag', selectedTags); 
        $.ajax({
            url: "{{ route('lead.update') }}",
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
            },
            // error: function(response) {
            //     let errors = response.data.msg;//.responseJSON.errors;
            //     console.log('errors',errors)
            //     for (let key in errors) {
            //         $('#'+key).text(errors[key]);
            //     }
            // }
        });
    });
    </script>
@endsection