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
                    <li class="breadcrumb-item active">Agents List</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header table_header">
                  <div class="row">
                    <h4 class="card-title col-lg-8">Agents List</h4>
                    <div class="col-lg-4 pull-right">
                      <a href="{{ route('agents.addoredit') }}" class="btn btn-xs btn-secondary waves-effect waves-light pull-right">Add New Agent</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table mb-0">
                      <thead>
                        <tr>
                          <th>Agent Id</th>
                          <th>Name</th>
                          <th>Birth Date</th>
                          <th>Address</th>
                          <th>Total Earn</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($agents as $agent)
                        <tr>
                          <td>{{ $agent->AgentId }}</td> 
                          <td>{{ $agent->Name }}</td>
                          <td>{{ $agent->dob }}</td>
                          <td>{{ $agent->address }}</td>
                           <td>
                             
                             @php
                             $TotalEarn=  new App\Models\Saleshistory();
                             $Earning= $TotalEarn->getCommission($agent->_id);
                             echo $Earning;
                             @endphp
                           </td>

                          <td>
                            <div class="btn-group" role="group" aria-label="Agent Actions">
                              <a href="{{ route('agents.addoredit', $agent->_id) }}" class="btn btn-warning btn-xs" style="width: 70px; margin-right: 8px;">Edit</a>

                              <form action="{{ route('agents.delete', $agent->_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this agent?');" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs" style="width: 70px;">Delete</button>
                              </form>
                            </div>
                          </td>


                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->
        </div>
      </div>
      @include('.backend/main_layouts/footer_common')
    </div>
  </div>