<!-- Modals add menu -->
<div id="modal-content-{{ $archive->id }}" class="modal fade " tabindex="-1"
  aria-labelledby="modal-content-{{ $archive->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modal-content-{{ $archive->id }}-label">No. Dokumen :
          {{ $archive->number_document }}
        </h5>
      </div>

      <div class="modal-body">
        {{ \Illuminate\Support\Str::limit($archive->content_file ?? 'N/A', 1000) }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
