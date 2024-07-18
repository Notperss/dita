<!-- Modals add menu -->
<div id="modal-form-edit-menu-{{ $descendant->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-menu-{{ $descendant->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <form action="{{ route('folder.update', $descendant->id) }}" method="post" id="update_{{ $descendant->id }}">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-menu-{{ $descendant->id }}-label">Edit Folder
            ({{ $descendant->name }})</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name <code style="color:red;">*</code></label>
            <input type="text" class="form-control" id="name" placeholder="Folder Name" name="name"
              value="{{ $descendant->name }}">
            <x-form.validation.error name="name" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <a href="#" class="btn btn-primary" onclick="update({{ $descendant->id }})">Update</a>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  function update(descendantId) {
    Swal.fire({
      title: 'Are you sure?',
      // text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Update It!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('update_' + descendantId).submit();
      }
    });
  }
</script>
