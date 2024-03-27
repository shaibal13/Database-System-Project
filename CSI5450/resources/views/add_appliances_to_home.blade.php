
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                            <li class="breadcrumb-item active">Add New Appliances to Home</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add Appliances to home id: {{$homes->HomeID}}</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('owners/addNewOwners')}}" method="post"> -->
                                     <!-- <form action="{{ isset($owner->id) ? url('owners/update/' . $owner->id) : url('owners/addNewOwners') }}" method="post"> -->
                                     <form action="{{ url('homes/addorupdateNewApplianceForm') }}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($owner->_id))
                                        @method('PUT')
                                     @endif -->
                                     @if(isset($homes->_id))
                                        <input type="hidden" name="id" value="{{$homes->_id}}">
                                    @endif
                                    <div class="row">
                                                <div class="">
                                                    <div class="mb-3">
                                                        <label for="choices-multiple-default" class="form-label font-size-13 text-muted"> appliances to Home</label>
                                                        <select class="form-control" data-trigger
                                                            id="choices-multiple-default"
                                                            placeholder="This is a placeholder" name=appliances[] multiple>
                                                            @foreach($appliances as $appliance)
                                                            <option value="{{$appliance->ModelName}}"
                                                            @php
                                                                if(!empty($existed_appliances)){
                                                                    if(in_array($appliance->ModelName,$existed_appliances)){
                                                                        echo "selected";
                                                                    }
                                                                }
                                                            @endphp
                                                            >{{$appliance->ModelName}}</option>
                                                           
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                              
                                                <div class="mt-4 pull-right">
                                                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                                        </div>
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
     

                        


                    
                        
                   