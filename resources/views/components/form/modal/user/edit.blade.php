<!-- Modals add menu -->
<div id="modal-form-edit-user-{{ $user->id }}" class="modal fade modal-form-user-edit" tabindex="-1"
  aria-labelledby="modal-form-edit-user-{{ $user->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('user.update', $user->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-user-{{ $user->id }}-label">Edit User ({{ $user->name }})
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Role Name" name="name"
              value="{{ $user->name }}">
            <x-form.validation.error name="name" />
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Guard Name" name="email"
              value="{{ $user->email }}">
            <x-form.validation.error name="email" />
          </div>

          <div class="mb-3">
            <label for="company_id" class="form-label">Perusahaan</label>
            <select class="form-control choices" id="company_id" name="company_id">
              <option value="" selected disabled>Choose</option>
              @foreach ($companies as $company)
                <option value="{{ $company->id }}" {{ $company->id == $user->company_id ? 'selected' : '' }}>
                  {{ $company->name }}</option>
              @endforeach
            </select>
            <x-form.validation.error name="company_id" />
          </div>

          <div class="mb-3">
            <label for="division_id" class="form-label">Divisi</label>
            <select class="form-control" id="division_id" name="division_id">
              <option value="" selected disabled>Choose</option>
              @php
                $divs = DB::table('divisions')
                    ->where('company_id', $user->company_id)
                    ->get();
              @endphp
              @foreach ($divs as $div)
                <option value="{{ $div->id }}" {{ $div->id == $user->division_id ? 'selected' : '' }}>
                  {{ $div->name }}
                </option>
              @endforeach
            </select>
            <x-form.validation.error name="division_id" />
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role Name</label>
            <select class="form-control" id="role" name="role" data-choices data-choices-removeItem>
              @foreach ($roles as $role)
                <option @selected($user->hasRole($role->name)) value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
            <x-form.validation.error name="role" />
          </div>

          <div class="mb-3">
            <div class="form-check form-switch form-switch-right form-switch-md">
              <label for="verified" class="form-label">Verified</label>
              <input class="form-check-input code-switcher" type="checkbox" id="tables-small-showcode" name="verified"
                value="1" @checked(!blank($user->email_verified_at))>
            </div>
            <x-form.validation.error name="verified" />
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ">Update</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
  $(document).ready(function() {
    $(document).on('change', '[id^="modal-form-edit-user-"] #company_id', function() {
      var modalId = $(this).closest('.modal').attr('id');
      var userId = modalId.split('-').pop(); // Extracting user ID from modal ID
      var companyId = $(this).val();

      if (companyId) {
        // AJAX request to fetch divisions for the selected company
        $.ajax({
          url: "{{ route('getDivisions') }}",
          type: 'GET',
          dataType: 'json',
          data: {
            company_id: companyId
          },
          success: function(data) {
            $('#' + modalId + ' #division_id').empty();
            $('#' + modalId + ' #division_id').append(
              '<option value="" selected disabled>Choose</option>');
            $.each(data, function(key, value) {
              $('#' + modalId + ' #division_id').append('<option value="' + value.id + '">' + value
                .name + '</option>');
            });
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      } else {
        $('#' + modalId + ' #division_id').empty();
        $('#' + modalId + ' #division_id').append('<option value="" selected disabled>Choose</option>');
      }
    });
  });
</script>
