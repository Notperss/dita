{{-- <section class="section">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Change Password</h5>
        </div>
        <div class="card-body">
          <form action="#" method="get">
            <div class="form-group my-2">
              <label for="current_password" class="form-label">Current Password</label>
              <input type="password" name="current_password" id="current_password" class="form-control"
                placeholder="Enter your current password" value="1L0V3Indonesia">
            </div>
            <div class="form-group my-2">
              <label for="password" class="form-label">New Password</label>
              <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter new password" value="">
            </div>
            <div class="form-group my-2">
              <label for="confirm_password" class="form-label">Confirm Password</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                placeholder="Enter confirm password" value="">
            </div>

            <div class="form-group my-2 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section> --}}



<!-- Modals add menu -->
<div id="modal-form-edit-password-{{ auth()->user()->id }}" class="modal fade" tabindex="-1"
  aria-labelledby="modal-form-edit-password-{{ auth()->user()->name }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('user-password.update', auth()->user()->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-password-{{ auth()->user()->id }}-label">Change Password
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="form-group my-2">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control"
              placeholder="Enter your current password">
          </div>
          <div class="form-group my-2">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
          </div>
          <div class="form-group my-2">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
              placeholder="Enter confirm password">
          </div>

          <div class="form-group my-2 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
          {{-- <div class="mb-3">
            <label for="roles[]" class="form-label">Role Name</label>
            <select class="form-control choices multiple-remove" id="roles[]" name="roles[]" multiple="multiple">
              @foreach ($roles as $role)
                <option @selected($permission->hasRole($role->name)) value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
            </select>
            <x-form.validation.error name="roles" />
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" class="form-control" id="description" placeholder="Permission description" name="description">{{ $permission->description }}</textarea>
            <x-form.validation.error name="description" />
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ">Update</button>
        </div> --}}
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
