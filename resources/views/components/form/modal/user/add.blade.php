<!-- Modals add menu -->
<div id="modal-form-add-user" class="modal fade modal-form-user" tabindex="-1" aria-labelledby="modal-form-add-user-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="modal-form" action="{{ route('user.store') }}" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-user-label">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Role Name" name="name">
            <x-form.validation.error name="name" />
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Guard Name" name="email">
            <x-form.validation.error name="email" />
          </div>

          <div class="mb-3">
            <label for="company_id" class="form-label">Perusahaan</label>
            <select class="form-control choices" id="company_id" placeholder="Guard Name" name="company_id">
              <option value="" selected disabled>Choose</option>
              @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
              @endforeach
            </select>
            <x-form.validation.error name="company_id" />
          </div>

          <div class="mb-3">
            <label for="division" class="form-label">Divisi</label>
            <select class="form-control" id="division" style="width:100%" placeholder="Guard Name" name="division_id">
              <option value="" selected disabled>Choose</option>
              {{-- @foreach ($divisions as $division)
                <option value="{{ $division->id }}">{{ $division->name }}</option>
              @endforeach --}}
            </select>
            <x-form.validation.error name="division" />
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role Name</label>
            <select class="form-control choices" id="role" name="role">
              @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
            <x-form.validation.error name="role" />
          </div>

          <div class="mb-3">
            <div class="form-check form-switch form-switch-right form-switch-md">
              <label for="verified" class="form-label">Verified</label>
              <input class="form-check-input code-switcher" type="checkbox" id="tables-small-showcode" name="verified"
                value="1">
            </div>
            <x-form.validation.error name="verified" />
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ">Save</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{-- @push('after-script')
  <script>
    $(document).ready(function() {
      $('#company_id').change(function() {
        var companyId = $(this).val();
        if (companyId) {
          $.ajax({
            url: "{{ route('backsite.getDivisions') }}",
            type: 'GET',
            dataType: 'json',
            data: {
              company_id: companyId
            },
            success: function(data) {
              $('#division').empty();
              $('#division').append('<option value="" selected disabled>Choose</option>');
              $.each(data, function(key, value) {
                $('#division').append('<option value="' + value.id + '">' + value.name +
                  '</option>');
              });
            }
          });
        } else {
          $('#division').empty();
          $('#division').append('<option value="" selected disabled>Choose</option>');
        }
        // console.log(data);
      });
    });
  </script>
@endpush --}}
