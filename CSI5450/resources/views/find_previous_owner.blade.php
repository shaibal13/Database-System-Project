
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Owner</a></li>
                                            <li class="breadcrumb-item active">Previous Owner</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Find previous Owner of a Home</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{route('homes.previousOwner')}}" method="post">
   
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
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">Homes list</label>
                                                        <select class="form-control" data-trigger name="home_id"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder" required>
                                                            <option value="">This is a placeholder</option>
                                                            @foreach($homes as $home)
                                                            <option value="{{$home->_id}}"
                                                            @php 
                                                            if($home_id==$home->_id){
                                                                echo "selected";
                                                            } 
                                                            @endphp
                                                            
                                                            >Home Id: {{$home->HomeID}}</option>
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
                                        <h4 class="card-title">Previous owners of Home Id: {{!empty($home_details)?$home_details->HomeID:''}}</h4>
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
                          <th>#</th>
                            <th>Name</th>
                            <th>SSN</th>
                            <th>Family Member</th>
                            <th>Income</th>
                            <th>Age</th>
                            <th>Profession</th>
                            
                            <!-- <th>Address</th>
                            <th>Option</th> -->
                          </tr>
                        </thead>
                        <tbody>
                     
                       @if(!$owners->isEmpty())
                            @php $i=0; @endphp
                            @foreach ($owners as $owners)
                                    @php $owner= $owners->ownerDetails; @endphp
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $owner->Name }}</td>
                                    <td>{{ $owner->SSN }}</td>
                                    <td>{{ $owner->Familymember }}</td>
                                    <td>{{ $owner->Income }}</td>
                                    <td>{{ $owner->Age }}</td>
                                    <td>{{ $owner->Profession }}</td>
                                    
                                   
                                    <td></td>
                                </tr>
                         @endforeach
                        @else
                             <tr>
                                <td colspan="9" class="text-center">No Previous Owner found.</td>
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
     

                        


                    
                        
                   