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
          <div class="card card-lightblue card-outline">
            <div class="card-header">
              <div class="row justify-content-between">
                <div class="col-md-6 mt-1 mb-1">
                  <div class="card-tools float-left">
                    <div class="input-group input-group-sm" style="width: 52px;">
                      <select class="custom-select" id="selectRows">
                        <option @if (session('rowCompanies') == 5) selected @endif value="5">5</option>
                        <option @if (session('rowCompanies') == 10) selected @endif value="10">10</option>
                        <option @if (session('rowCompanies') == 15) selected @endif value="15">15</option>
                        <option @if (session('rowCompanies') == 20) selected @endif value="20">20</option>
                      </select>
                    </div>
                  </div>
                  <h3 class="card-title mt-1">&nbsp; List Data Companies</h3>&nbsp;
                  &nbsp;<a href="/anm/companies/create" class="btn btn-primary btn-sm" title="Create"><i class="fas fa-plus"></i> Create</a>
                </div>

                <div class="col-md-3 mt-1">
                  <div class="card-tools float-right">
                    <div class="input-group input-group-sm" style="width: 180px;">
                      <input type="text" name="search" id="ajaxSearch" class="form-control float-right" placeholder="Search">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="fas fa-search"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <!-- /.card-header -->
            <div id="dataList" class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th><i class="bi bi-gear-wide-connected"></i> Action</th>
                  </tr>
                </thead>
                <tbody>

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
            <input type="hidden" id="ajaxPage" name="ajax_page" value="1">
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

      // Untuk mengisi ref slug di modal delete
      $(document).on('click', '#btnDelete', function(e) {
        e.preventDefault();
        var del_slug = $(this).val();
        $('#formDelete').attr('action', '/anm/companies/' + del_slug);
      });

      function fetchData(page, row, search) {
        $.ajax({
          url: "/anm/companies/fetch?page=" + page + "&row=" + row + "&search=" + search,
          success: function(data) {
            $('#dataList').html('');
            $('#dataList').html(data);
          }
        })
      }

      $(document).on('keyup', '#ajaxSearch', function(e) {
        e.preventDefault();
        var search = $('#ajaxSearch').val();
        var page = $('#ajaxPage').val();
        var row = $('#selectRows').val();
        fetchData(page, row, search);
      });

      $(document).on('change', '#selectRows', function(e) {
        e.preventDefault();
        var search = $('#ajaxSearch').val();
        var page = $('#ajaxPage').val();
        var row = $('#selectRows').val();
        fetchData(page, row, search);
      });

      $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var search = $('#ajaxSearch').val();
        var row = $('#selectRows').val();
        var page = $(this).attr('href').split('page=')[1];
        $('#ajaxPage').val(page);
        $('li').removeClass('active');
        $(this).parent().addClass('active');
        fetchData(page, row, search);
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