
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Sales</a></li>
                                            <li class="breadcrumb-item active">Sales history</li>
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
                    <h4 class="card-title col-lg-8">Appliances List</h4>
                 <!-- </div> -->
                    
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
                            <th>Home Id</th>
                            <th>Owner </th>
                            <th>Seller </th>
                            <th>Agent</th>
                            <th>Agent Company</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Agent Commision</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach($sales_details as $sale)

                        <tr>
                            <td>{{ \App\Models\Homes::getHome($sale->HomeId)->HomeID }}</td>
                            <td>{{  \App\Models\Owners::getOwners($sale->OwnerId)->Name }}</td>
                            <td>{{ !empty($sale->PreviousOwnerId)? \App\Models\Owners::getOwners($sale->PreviousOwnerId)->Name:"" }}</td>
                           
                            <td>{{  \App\Models\Agents::getAgents($sale->Agent)->Name }}</td>
                            <td>{{  \App\Models\Companies::getCompanies($sale->Company)->Name }}</td>
                            <td>{{  $sale->price }}</td>
                            <td>{{ Date('M-D-Y',$sale->date_saling) }}</td>
                            <td>{{  $sale->agentcommision }}</td>
                            
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
     

                        


                    
                        
                   