@extends('admin.layouts.app')

@section('title', 'Edit '.$company->name)

@section('content')

<!-- Header Content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit {{ $company->name }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/anm/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/anm/companies">Companies</a></li>
            <li class="breadcrumb-item active">Edit</li>
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
              <h3 class="card-title"><i class="nav-icon fas fa-list"></i>&nbsp; Form Edit</h3>
            </div>
            <!-- /.card-header -->

            <form action="/anm/companies/{{ $company->slug }}" method="POST" enctype="multipart/form-data">
              @method('PUT')
              @csrf
              <div class="card-body">
                <div class="row justify-content-evenly">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="editName">Name <span style="color: red;">*</span></label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="editName" value="{{ old('name', $company->name) }}" required>
                      @error('name')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="editSlug">Slug <span style="color: red;">*</span></label>
                      <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="editSlug" value="{{ old('slug', $company->slug) }}" required>
                      @error('slug')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="editEmail">Email <span style="color: red;">*</span></label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="editEmail" value="{{ old('email', $company->email) }}" required>
                      @error('email')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Website <span style="color: red;">*</span></label>
                      <textarea class="form-control @error('website') is-invalid @enderror" name="website" rows="3" required>{{ old('website', $company->website) }}</textarea>
                      @error('website')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-5">
                    <div class="form-group">
                      <label for="editLogo">Logo</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" name="logo" id="editLogo" value="{{ old('logo') }}">
                          <label class="custom-file-label" for="inputLogo">Choose file</label>
                        </div>
                      </div>
                      <small>
                        <cite>
                          &nbsp;<i class="bi bi-exclamation-triangle-fill"></i> Note : Diisi jika ingin mengubah logo
                        </cite>
                      </small>
                      @error('logo')
                      <p><small class="text-danger">{{ $message }}</small></p>
                      @enderror
                    </div>
                    @if ($company->logo)
                    <img id="previewImage" src="{{ asset('storage/images/'.$company->logo) }}" class="attachment-img col-sm-5" alt="">
                    @else
                    <img id="previewImage" src="{{ asset('storage/images/noimage.jpg') }}" class="attachment-img col-sm-5" alt="">
                    @endif
                    <span id="fileSize" class="mt-2 ml-2"></span>
                  </div>
                </div>
              </div>
              <input type="hidden" name="id" value="{{ $company->id }}">
              <!-- /.card-body -->

              <div class="card-footer">
                <div class="float-right">
                  <a href="/anm/companies" class="btn btn-danger">Cancel</a>
                  <button type="submit" class="btn btn-primary">Update</button>
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
    $('#editLogo').change(function() {
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
    $(document).on('change', '#editName', function(e) {
      e.preventDefault();
      $.ajax({
        url: "/anm/companies/checkslug",
        type: 'GET',
        data: {
          name: $('#editName').val()
        },
        success: function(response) {
          $('#editSlug').val(response.slug);
        }
      });
    });
  </script>

  @endsection