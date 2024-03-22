
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

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">CSI5450</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Homes</a></li>
                                            <li class="breadcrumb-item active">Add New Homes</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Homes</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{ url('homes/addorupdateNewHomeForm') }}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($owner->_id))
                                        @method('PUT')
                                     @endif -->
                                     @if(isset($homes->_id))
                                        <input type="hidden" name="id" value="{{ $homes->_id ?? '' }}">
                                    @endif
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Floor Space (sqft)</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $homes->FloorSpace ?? '' }}" id="example-text-input" name="FloorSpace" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Floors</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $homes->Floors ?? '' }}" id="example-text-input" name="Floors" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">BedRooms</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $homes->BedRooms ?? '' }}" id="example-text-input" name="BedRooms" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">BathRooms</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $homes->BathRooms ?? '' }}" id="example-text-input" name="BathRooms" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">LandSize (sqft)</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number"  value="{{ $homes->LandSize ?? '' }}" id="example-text-input" name="LandSize" required>
                                                <span style="color:red;"> 1 acre= 43,560 square ft. </span>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">YearConstructed</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number"  min="1900" max="2099"  value="{{ $homes->YearConstructed ?? '' }}" id="example-text-input" name="YearConstructed" required>
                                            </div>
                                        </div>
                                        <h5> Location</h5>
                                        <div class="mb-3 row">
                                            <div class="col-lg-3">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Street</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  value="{{ $location->Street ?? '' }}" id="example-text-input" name="Street" required>
                                            </div>
</div>


<div class="col-lg-3">
                                            <label for="example-text-input" class="col-md-2 col-form-label">City</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  value="{{ $location->City ?? '' }}" id="example-text-input" name="City" required>
                                            </div>
</div>
<div class="col-lg-3">
                                            <label for="example-text-input" class="col-md-2 col-form-label">State</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  value="{{ $location->State ?? '' }}" id="example-text-input" name="State" required>
                                            </div>
</div>
<div class="col-lg-3">
                                            <label for="example-text-input" class="col-md-4 col-form-label">County</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  value="{{ $location->County ?? '' }}" id="example-text-input" name="County" required>
                                            </div>
</div>
                                        </div>
                                       
                                        <div class="mb-3 row">
                                        <div class="col-lg-6">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Zip</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" min="10000" max="99999"  value="{{ $location->Zip ?? '' }}" id="example-text-input" name="Zip" required>
                                            </div>
</div> <div class="col-lg-6">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Unit number</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text"  value="{{ $location->Apt ?? '' }}" id="example-text-input" name="Apt">
                                            </div>
</div>
</div>
                                        <div class="mt-4 pull-right">
                                                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <!-- end row -->
                        <!-- end page title -->

@include('.backend/main_layouts/footer_common')
     

                        


                    
                        
                   