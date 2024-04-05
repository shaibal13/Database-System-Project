
@include('.backend/main_layouts/css')
    <body data-layout="vertical" data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

        @include('.backend/main_layouts/header')
     
            <!-- ========== Left Sidebar Start ========== -->

        @include('.backend/main_layouts/sidebar')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
<style>
    .is-open .choices__list--dropdown{
        min-height: 100px !important;
    }
    </style>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">CSI5450</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Owners</a></li>
                                            <li class="breadcrumb-item active">Expensive owners</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">City</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{route('homes.expensivehome')}}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($owner->_id))
                                        @method('PUT')
                                     @endif -->
                                     <!-- @if(isset($homes->_id))
                                        <input type="hidden" name="id" value="{{$homes->_id}}">
                                    @endif -->
                                    <div class="row">
                                                <div class="col-8">
                                                <div class="mb-3">
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">City</label>
                                                        <select class="form-control" data-trigger name="city"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder" required>
                                                            <option value="">This is a placeholder</option>
                                                          @foreach($cities as $city)
                                                            <option value="{{$city}}"
                                                            @php
                                                            if($city_select==$city){
                                                              echo 'selected';
                                                            }
                                                            
                                                            @endphp 
                                                            >{{$city}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                               
                                              
                                                <div class="col-4 pull-right" style="margin-top: 3%;">
                                                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        </div>
                                    </div>
                                     
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>


                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Expensive Homes owner in the city {{!empty($city_select)?$city_select:''}}</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <div class="table-responsive">
                      <table class="table mb-0">
                        <!-- table mb-0-->
                      
                        <thead>
                          <tr>
                            <th>Home Id</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Profession</th>
                            <th>Price</th>
                            <th>Type</th>
                            <!-- <th>Age</th> -->
                           
                            <!-- <th>Address</th>
                            <th>Option</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        @if(!$owners_list->isEmpty())
                            @foreach($owners_list as $owner)
                            @php $ownerModel=new \App\Models\Owners(); 
                                $ownerdetails=$ownerModel->getOwners($owner->_id);
                               
                            @endphp
                                @foreach ($owner->homes as $home) 
<tr>
<td> {{ $home['HomeID']}}</td>
    <td> {{ $ownerdetails->Name}}</td>
    <td> {{ $ownerdetails->Age}}</td>
    <td> {{ $ownerdetails->Profession}}</td>
    <td> {{ $home['Price']}}</td>
    <td> {{ $home['Type']}}</td>
                                                        </tr>

                        @endforeach
                        @endforeach


@else
<tr>
                                <td colspan="6" class="text-center">No homes found.</td>
                            </tr>

                        @endif
                     
                       
                        </tbody>
                      </table>
                    </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <!-- end row -->
                        <!-- end page title -->

@include('.backend/main_layouts/footer_common')
     

                        


                    
                        
                   