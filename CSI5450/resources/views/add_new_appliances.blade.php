
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Appliances</a></li>
                                            <li class="breadcrumb-item active">Add New Appliances</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Appliances</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{ url('appliances/addorupdateNewApplianceForm') }}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($owner->_id))
                                        @method('PUT')
                                     @endif -->
                                     @if(isset($appliances->_id))
                                        <input type="hidden" name="id" value="{{ $appliances->_id ?? '' }}">
                                    @endif
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Model Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $appliances->ModelName ?? '' }}" id="example-text-input" name="ModelName" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Year</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" min="1900" max="2099" value="{{ $appliances->Year ?? '' }}" id="example-text-input" name="Year" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Maker</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $appliances->Maker ?? '' }}" id="example-text-input" name="Maker" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $appliances->Name ?? '' }}" id="example-text-input" name="Name" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Price</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" min="1" step="0.01" value="{{ $appliances->Price ?? '' }}" id="example-text-input" name="Price" required>
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
     

                        


                    
                        
                   