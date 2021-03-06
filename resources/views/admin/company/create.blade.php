@extends('admin.layouts.app')

@section('title', 'Create Company')

@section('content')

<!-- Header Content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Company</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/anm/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/anm/companies">Companies</a></li>
            <li class="breadcrumb-item active">Create</li>
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
        <div class="col-10">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="nav-icon fas fa-list"></i>&nbsp; Form Create</h3>
            </div>
            <!-- /.card-header -->

            <form action="/anm/companies" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="row justify-content-evenly">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="inputName">Name <span style="color: red;">*</span></label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputName" value="{{ old('name') }}" required>
                      @error('name')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="inputSlug">Slug <span style="color: red;">*</span></label>
                      <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="inputSlug" value="{{ old('slug') }}" required>
                      @error('slug')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="inputEmail">Email <span style="color: red;">*</span></label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail" value="{{ old('email') }}" required>
                      @error('email')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Website <span style="color: red;">*</span></label>
                      <textarea class="form-control @error('website') is-invalid @enderror" name="website" rows="3" required>{{ old('website') }}</textarea>
                      @error('website')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label for="inputLogo">Logo <span style="color: red;">*</span></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" name="logo" id="inputLogo" value="{{ old('logo') }}" required>
                          <label class="custom-file-label" for="inputLogo">Choose file</label>
                        </div>
                      </div>
                      @error('logo')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <img id="previewImage" src="/images/noimage.jpg" class="attachment-img col-sm-5" alt="">
                    <span id="fileSize" class="mt-2 ml-2"></span>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <div class="float-right">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>
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

  <!-- Custom-file-input -->
  <script src="/assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Custom-file-input
    $(function() {
      bsCustomFileInput.init();
    });

    // Image preview before upload
    $('#inputLogo').change(function() {
      $('#fileSize').html('');
      var reader = new FileReader();
      reader.onload = (e) => {
        $('#previewImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
      // fileName = this.files[0].name;
      fileSize = Math.round(this.files[0].size / 1024);
      $('#fileSize').html('Size (<strong>' + fileSize + '</strong> KB)')
    });

    // Ajax slug
    $(document).on('change', '#inputName', function(e) {
      e.preventDefault();
      $.ajax({
        url: "/anm/companies/checkslug",
        type: 'GET',
        data: {
          name: $('#inputName').val()
        },
        success: function(response) {
          $('#inputSlug').val(response.slug);
        }
      });
    });
  </script>

  @endsection