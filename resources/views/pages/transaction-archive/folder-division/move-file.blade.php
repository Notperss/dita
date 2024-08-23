<!-- Modals add menu -->
<div id="modal-form-move-menu-{{ $file->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-move-menu-{{ $file->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog  modal-md">
    <div class="modal-content">
      <form action="{{ route('folder.moveFile', $file->id) }}" method="post" id="move_{{ $file->id }}">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-move-menu-{{ $file->id }}-label"> Pindah File </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="folderId" class="form-label">Pilih Folder <code style="color:red;">*</code></label>
            {{-- <input type="text" class="form-control" id="name" placeholder="Folder Name" name="name"
              value="{{ $descendant->name }}"> --}}
            <select name="folderId" id="folderId" class="form-control choices">
              <option value="" selected disabled> Choose</option>
              @foreach ($allFolders as $fol)
                <option value="{{ $fol->id }}">{{ $fol->name }}</option>
              @endforeach
            </select>
            <x-form.validation.error name="name" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <a href="#" class="btn btn-primary" onclick="move({{ $file->id }})">Update</a>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  function move(fileId) {
    Swal.fire({
      title: 'Are you sure?',
      // text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Update It!'
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user clicks "Yes, delete it!", submit the corresponding form
        document.getElementById('move_' + fileId).submit();
      }
    });
  }
</script>
