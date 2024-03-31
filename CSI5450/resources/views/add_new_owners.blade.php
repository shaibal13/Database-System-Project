
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Owners</a></li>
                                            <li class="breadcrumb-item active">Add New Owner</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Owner</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{ url('owners/addorupdateNewOwnerForm') }}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($owner->_id))
                                        @method('PUT')
                                     @endif -->
                                     @if(isset($owner->_id))
                                        <input type="hidden" name="id" value="{{ $owner->_id ?? '' }}">
                                    @endif
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $owner->Name ?? '' }}" id="example-text-input" name="name" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">SSN</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $owner->SSN ?? '' }}" id="example-text-input" name="ssn" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Family member</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $owner->Familymember ?? '' }}" id="example-text-input" name="familymember" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Income</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $owner->Income ?? '' }}" id="example-text-input" name="income" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Age (years)</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $owner->Age ?? '' }}" id="example-text-input" name="age" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Profession</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $owner->Profession ?? '' }}" id="example-text-input" name="profession" required>
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
     

                        


                    
                        
                   