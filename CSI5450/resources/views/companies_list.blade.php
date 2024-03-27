
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
                                            <li class="breadcrumb-item active">Companies List</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header table_header">
                    <!-- <div class="col-lg-10"> -->
                        <div class="row">
                    <h4 class="card-title col-lg-8">Companies List</h4>
                 <!-- </div> -->
                    <div class="col-lg-4 pull-right">
                    <a href="{{ route('companies.addoredit') }}" class="btn btn-xs btn-secondary waves-effect waves-light pull-right">Add New Company</a>

                       
                        </div>
</div>
                    <!-- <p class="card-title-desc">
                      For basic styling—light padding and only horizontal
                      dividers—add the base class <code>.table</code> to any
                      <code>&lt;table&gt;</code>.
                    </p> -->
                  </div>
                  <div class="card-body ">
                    <div class="table-responsive">
                      <table class="table mb-0">
                        <!-- table mb-0-->

                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Percentage</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($companies as $company)

                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $company->Name }}</td>
                            <td>{{ $company->Percentage }}</td>
                            
                            <td> <a href="{{ route('companies.addoredit', $company->_id) }}" class="btn btn-xs btn-warning">Edit</a>
</td>
                            <!-- Add other fields as needed -->
                        </tr>
                    @endforeach
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
</div>
                        <!-- end row -->
                        <!-- end row -->
                        <!-- end page title -->

@include('.backend/main_layouts/footer_common')
     

                        


                    
                        
                   