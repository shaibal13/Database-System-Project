
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Homes</a></li>
                                            <li class="breadcrumb-item active">Find the most expensive home an owner ever bought</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Owner choice</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{route('homes.mostExpensiveHome')}}" method="post">
   
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
                                                        <label for="choices-single-default" class="form-label font-size-13 text-muted">Owner list</label>
                                                        <select class="form-control" data-trigger name="appliances_maker"
                                                            id="choices-single-default"
                                                            placeholder="This is a search placeholder" required>
                                                            <option value="">This is a placeholder</option>
                                                            @foreach($owner as $owner)
                                                            <option value="{{$owner}}"
                                                            @php
                                                                if(!empty($owner_name)){
                                                                    if($owner_name==$owner){
                                                                        echo "selected";
                                                                    }
                                                                }
                                                            @endphp
                                                            
                                                            >{{$owner}}</option>
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
                                        <h4 class="card-title">Most expensive homes:</h4>
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
                            <th>Price</th>

                          </tr>
                        </thead>
                        <tbody>
                     
                       @if(!empty($homes))
                            @foreach ($homes as $home)
                                <tr>
                                    <td>{{ $home-> HomeId }}</td>
                                    <td>{{ $home -> price}}</td>
                                </tr>
                         @endforeach
                        @else
                             <tr>
                                <td colspan="9" class="text-center">No homes found.</td>
                            </tr>
                        @endif





                        
                        <!-- @if(!empty($homeDeatil))
                        @foreach ($homeDetail as $home)
                            <div>Home ID: {{ $home['HomeId'] ?? 'N/A' }}</div>
                            <div>Price: ${{ $home['price'] ?? 'N/A' }}</div>
                        @endforeach
                        @else
                            <div>No home found for the specified owner.</div>
                        @endif -->


                        
                       
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
     

                        


                    
                        
                   