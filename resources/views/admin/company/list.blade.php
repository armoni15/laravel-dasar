@extends('admin.layouts.app')

@section('title', 'Companies')

@section('css')

<!-- SweetAlert2 -->
<link rel="stylesheet" href="/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="/assets/admin/plugins/toastr/toastr.min.css">

@endsection

@section('content')

<!-- Header Content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Companies</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/anm/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Companies</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- End Header Contont -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-info card-outline">
            <div class="card-header">
              <h3 class="card-title mt-1"><i class="fas fa-list"></i>&nbsp; List Data Companies</h3>&nbsp;
              &nbsp;<a href="/anm/companies/create" class="btn btn-primary btn-sm" title="Create"><i class="fas fa-plus"></i> Create</a>

              <div class="card-tools mt-1">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="search" id="ajaxSearch" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th><i class="nav-icon fas fa-gear"></i> Action</th>
                  </tr>
                </thead>
                <tbody id="dataList">

                  @if (count($companies) > 0)
                  @foreach ($companies as $company)
                  <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->email }}</td>
                    <td>
                      @if ($company->logo)
                      <img src="{{ asset('storage/images/'.$company->logo) }}" class="attachment-img" width="50" height="50" alt="">
                      @else
                      <img src="{{ asset('storage/images/noimage.jpg') }}" class="attachment-img" width="50" height="50" alt="">
                      @endif
                    </td>
                    <td>
                      <a href="/anm/companies/{{ $company->slug }}/edit" title="Edit" class="btn btn-warning btn-sm rounded-3 shadow-sm"><i class="bi bi-pencil"></i> Edit</a>

                      <button type="button" value="{{ $company->slug }}" title="Delete" class="btn btn-danger btn-sm rounded-3 shadow-sm" id="btnDelete" data-toggle="modal" data-target="#modalDelete">
                        <i class="bi bi-trash3"></i> Delete
                      </button>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td class="text-center" colspan="5">No data results</td>
                  </tr>
                  @endif

                </tbody>
              </table>
              <div class="col-md border-top">
                <div class="mt-3 ml-2 mr-2">
                  {{ $companies->links() }}
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>

  @endsection


  @section('script')

  <!-- SweetAlert2 -->
  <script src="/assets/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="/assets/admin/plugins/toastr/toastr.min.js"></script>

  <!-- Modal -->
  @include('admin.company.modalDelete');
  <!-- EndModal -->

  <script>
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Untuk mengisi input id di modal 
      $(document).on('click', '#btnDelete', function(e) {
        e.preventDefault();
        var del_slug = $(this).val();
        $('#formDelete').attr('action', '/anm/companies/' + del_slug);
      });

    });
  </script>

  @if (session('succes'))
  <script>
    $(document).ready(function() {
      var logSuccess = "{{ session('succes') }}";
      toastr.success(logSuccess);
    });
  </script>
  @endif

  @if (session('error'))
  <script>
    $(document).ready(function() {
      var logError = "{{ session('error') }}";
      toastr.error(logError);
    });
  </script>
  @endif

  @endsection