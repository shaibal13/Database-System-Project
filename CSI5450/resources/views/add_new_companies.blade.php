
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Companies</a></li>
                                            <li class="breadcrumb-item active">Add New Company</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Company</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                  
                                     <form action="{{ url('companies/addorupdateNewCompaniesForm') }}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($company->_id))
                                        @method('PUT')
                                     @endif -->
                                     @if(isset($company->_id))
                                        <input type="hidden" name="id" value="{{ $company->_id ?? '' }}">
                                    @endif
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $company->Name ?? '' }}" id="example-text-input" name="name" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Address</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $company->Address ?? '' }}" id="example-text-input" name="address" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Percentage (%)</label>
                                            <div class="col-md-10">
                                                <input class="form-control" min="1" max="100" step="0.01" type="number" value="{{ $company->Percentage ?? '' }}" id="example-text-input" name="Percentage" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Agents</label>
                                            <div class="col-md-10">
                                            <select class="form-control" data-trigger
                                                            id="choices-multiple-default"
                                                            placeholder="This is a placeholder" name="agents[]" multiple>
                                                            @foreach($agents as $agent)
                                                            <option value="{{$agent->_id}}"
                                                            @php
                                                                if(!empty($existed_agent)){
                                                                    if(in_array($agent->_id,$existed_agent)){
                                                                        echo "selected";
                                                                    }
                                                                }
                                                            @endphp
                                                            
                                                            
                                                            >{{$agent->Name}}</option>  
                                                            @endforeach
                                                        </select>
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
     

                        


                    
                        
                   