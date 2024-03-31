
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Agents</a></li>
                                            <li class="breadcrumb-item active">Add New Agent</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Agent</h4>
                                        <!-- <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                                    </div>
                                    <div class="card-body">
                                     <!-- <form action="{{ url('agents/addNewagents')}}" method="post"> -->
                                     <!-- <form action="{{ isset($agent->id) ? url('agents/update/' . $agent->id) : url('agents/addNewagents') }}" method="post"> -->
                                     <form action="{{ url('agents/addorupdateNewAgentForm') }}" method="post">
   
                                     @csrf
                                     <!-- @if(isset($agent->_id))
                                        @method('PUT')
                                     @endif -->
                                     @if(isset($agent->_id))
                                        <input type="hidden" name="id" value="{{ $agent->_id ?? '' }}">
                                    @endif
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $agent->Name ?? '' }}" id="example-text-input" name="name" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-date-input" class="col-md-2 col-form-label">Birth Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" value="{{ $agent->dob ?? '2019-08-19' }}" name="dob" id="example-date-input">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Address</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $agent->address ?? '' }}" id="example-text-input" name="address" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Company</label>
                                            <div class="col-md-10">
                                            <select class="form-control" data-trigger
                                                            id="choices-multiple-default"
                                                            placeholder="This is a placeholder" name=companies[] multiple>
                                                            @foreach($companies as $company)
                                                            <option value="{{$company->_id}}"
                                                            @php
                                                                if(!empty($existed_company)){
                                                                    if(in_array($company->_id,$existed_company)){
                                                                        echo "selected";
                                                                    }
                                                                }
                                                            @endphp
                                                            
                                                            
                                                            >{{$company->Name}}</option>  
                                                            @endforeach
                                                        </select>
                                            </div>
                                        </div>
                                        <div id="percentage-fields-container"></div>

                                        <!-- <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Income</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $agent->Income ?? '' }}" id="example-text-input" name="income" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Age (years)</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="number" value="{{ $agent->Age ?? '' }}" id="example-text-input" name="age" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-text-input" class="col-md-2 col-form-label">Profession</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" value="{{ $agent->Profession ?? '' }}" id="example-text-input" name="profession" required>
                                            </div>
                                        </div> -->
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
<!-- <script>
    document.getElementById('choices-multiple-default').addEventListener('change', function() {
        var selectedCompanies = Array.from(this.selectedOptions).map(option => option.value);
        var container = document.getElementById('percentage-fields-container');

        // Clear previous percentage fields
        container.innerHTML = '';

        // Create a percentage field for each selected company
        selectedCompanies.forEach(function(companyId) {
            // Find the option element to get the company name
            var companyOption = document.querySelector('#choices-multiple-default option[value="' + companyId + '"]');
         
            var companyName = companyOption ? companyOption.text : '';
           
            var input='<div class="mb-3 row"> <label for="example-text-input" class="col-md-5 col-form-label">'+'Percentage for ' + companyName + ': '+'</label><div class="col-md-7"><input class="form-control" type="number" min="1" max="100" step="0.01" value="" id="example-text-input" name="company_percentage[' + companyName + ']" required>'+
                                          '</div></div>';
         
            container.innerHTML += input;
            
        });
    });
</script> -->



                        


                    
                        
                   