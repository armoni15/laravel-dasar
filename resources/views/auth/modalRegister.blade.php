<!-- Modal Register -->
<div class="modal fade" id="modalRegister">
  <div class="modal-dialog modal-dialog-centered">
    <div class=" modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register a new membership</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="registerForm" method="POST">
        @csrf
        <div class="modal-body">
          <div class="card-body register-card-body">
            <div class="input-group">
              <input type="text" name="name" id="regName" class="form-control" placeholder="Name" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <small class="text-danger" id="regNameError"></small>

            <div class="input-group mt-3">
              <input type="text" name="username" id="regUsername" class="form-control" placeholder="Username" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-at"></span>
                </div>
              </div>
            </div>
            <small class="text-danger" id="regUsernameError"></small>

            <div class="input-group mt-3">
              <input type="email" name="email" id="regEmail" class="form-control" placeholder="Email" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <small class="text-danger" id="regEmailError"></small>

            <div class="input-group mt-3">
              <input type="password" name="password" id="regPassword" class="form-control" placeholder="Password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <small class="text-danger" id="regPasswordError"></small>

            <div class="input-group mt-3">
              <input type="password" name="password_confirmation" id="regConfPassword" class="form-control" placeholder="Confirm password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer justify-content-between ml-3 mr-3">
          <div class="col-6">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
                I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <div class="col-4">
            <button id="btnResgister" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Jquery Modal Register -->
<script>
  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Ajax cek username
    $(document).on('change', '#regUsername', function(e) {
      e.preventDefault();
      $.ajax({
        url: "/anm/register/checkusername",
        type: 'GET',
        data: {
          username: $('#regUsername').val()
        },
        success: function(response) {
          if (response.status == 400) {
            $('#regUsernameError').html('&nbsp;<span class="fas fa-exclamation-triangle"></span> ' + response.errors);
          } else {
            $('#regUsernameError').html('');
          }
        }
      });
    });

    $(document).on('click', '#btnResgister', function(e) {
      e.preventDefault();
      $.ajax({
        url: "/anm/register",
        type: 'POST',
        dataType: "json",
        data: {
          name: $('#regName').val(),
          username: $('#regUsername').val(),
          email: $('#regEmail').val(),
          password: $('#regPassword').val(),
          password_confirmation: $('#regConfPassword').val(),
        },
        success: function(response) {
          if (response.status == 400) {
            $('#modalRegister').modal('show');

            if (response.errors.name) {
              $('#regNameError').html(response.errors.name);
            } else {
              $('#regNameError').html('');
            }

            if (response.errors.username) {
              $('#regUsernameError').html(response.errors.username);
            } else {
              $('#regUsernameError').html('');
            }

            if (response.errors.email) {
              $('#regEmailError').html(response.errors.email);
            } else {
              $('#regEmailError').html('');
            }

            if (response.errors.password) {
              $('#regPasswordError').html(response.errors.password);
            } else {
              $('#regPasswordError').html('');
            }
          } else {
            $('.form-control').val('');
            $('.text-danger').html('');
            $('#modalRegister').modal('hide');
            toastr.success(response.message)
            // Toast.fire({
            //   icon: 'success',
            //   title: response.message
            // })
          }
        }
      });
    });

    $('.close').click(function(e) {
      $('.form-control').val('');
      $('.text-danger').html('');
    });
  });
</script>
<!-- End Jquery Modal Register -->