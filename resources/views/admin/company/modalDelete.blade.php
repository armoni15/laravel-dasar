<!-- Modal Register -->
<div class="modal fade" id="modalDelete">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content" style="background-color: #212529; color:#c2c7d0;">
      <form id="formDelete" action="" method="POST">
        @method('delete')
        @csrf
        <div class="modal-body p-4 text-center">
          <h5 class="mb-0">Are you sure?</h5>

          <p class="mb-0" style="margin-top: 5px; font-size: 14px">
            Select "Yes" if you sure to dalete data
          </p>
        </div>
        <div class="modal-footer flex-nowrap p-0 border-dark">
          <button type="submit" id="btnDestroy" class="btn btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right border-dark">Yes</button>
          <button type="button" class="btn btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-dark" data-dismiss="modal">No</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->