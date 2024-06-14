<script>
  updateList = function() {
    var input = document.getElementById('file');
    var output = document.getElementById('fileList');
    var children = "";
    for (var i = 0; i < input.files.length; ++i) {
      children += '<li>' + input.files.item(i).name + '</li>';
    }
    output.innerHTML = '<ul>' + children + '</ul>';
  }
</script>
<div class="modal fade" id="modalupload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
        <a href="{{ url()->previous() }}" type="button" class="close btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <form class="form" action="{{ route('backsite.folder.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="id" id="id" value="{{ $id }}">

          <div class="form-group row">
            <label class="col-md-4 form-label" for="number">Nomor
              <code style="color:red;">*</code></label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="number" name="number">
              @if ($errors->has('number'))
                <p style="font-style: bold; color: red;">
                  {{ $errors->first('number') }}</p>
              @endif
            </div>
          </div>

          {{-- <div class="form-group row">
            <label class="col-md-4 form-label" for="name">Perihal
              <code style="color:red;">*</code></label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="name" name="name">
              @if ($errors->has('name'))
                <p style="font-style: bold; color: red;">
                  {{ $errors->first('name') }}</p>
              @endif
            </div>
          </div> --}}

          <div class="form-group row">
            <label class="col-md-4 form-label" for="date">Tanggal
              <code style="color:red;">*</code></label>
            <div class="col-md-8">
              <input type="date" class="form-control" id="date" name="date">
              @if ($errors->has('date'))
                <p style="font-style: bold; color: red;">
                  {{ $errors->first('date') }}</p>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-4 form-label" for="description">Keterangan
            </label>
            <div class="col-md-8">
              <textarea type="text" class="form-control" id="description" name="description"></textarea>
              @if ($errors->has('description'))
                <p style="font-style: bold; color: red;">
                  {{ $errors->first('description') }}</p>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-md-4 label-control" for="file">File
              <code style="color:red;">*</code></label>
            <div class="col-md-8">
              <input type="file" class="form-control" id="file" name="file[]" onchange="updateList()" multiple>
              <label class="form-label" for="file" aria-describedby="file">Pilih
                File</label>
            </div>
            @if ($errors->has('file'))
              <p style="font-style: bold; color: red;">
                {{ $errors->first('file') }}</p>
            @endif
            <p class="col-md-4">Selected File :</p>
            <div id="fileList" style="word-break: break-all"></div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <a href="{{ url()->previous() }}" style="width:120px;" class="btn btn-warning">
            Cancel
          </a>

          <button type="submit" style="width:120px;" class="btn btn-primary"
            onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini ?')">
            Simpan
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
