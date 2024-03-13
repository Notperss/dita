@extends('layouts.app')

@section('title', 'User Management')

@section('breadcrumb')
  <x-breadcrumb title="User Management" page="User Management" active="Users" route="{{ route('user.index') }}" />
@endsection

@section('content')

  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-user">
            <i class="bi bi-plus-lg"></i>
            Add
          </button>
        </h5>
      </div>
      <div class="card-body">
        <!-- end cardheader -->
        <!-- Hoverable Rows -->
        <table class="table table-hover table-nowrap mb-0" id="table1">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Role</th>
              <th scope="col">Verified</th>
              <th scope="col" class="col-1"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                  @foreach ($user->roles as $role)
                    <span class="badge badge-soft-success">{{ $role->name }}</span>
                  @endforeach
                </td>
                <td>
                  @if (!blank($user->email_verified_at))
                    <span class="badge badge-soft-success">Verified</span>
                  @else
                    <span class="badge badge-soft-danger">Not Verified</span>
                  @endif
                </td>
                {{-- <td>
              <div class="dropdown">
                <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ri-more-2-fill"></i>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                      data-bs-target="#modal-form-edit-user-{{ $user->id }}">
                      Edit
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"
                      onclick="event.preventDefault(); document.getElementById('modal-form-delete-user-{{ $user->id }}').submit()">
                      Delete
                    </a>
                  </li>
                </ul>

                @include('components.form.modal.user.edit')
                @include('components.form.modal.user.delete')
              </div>
            </td> --}}
                <td class="text-center" style="width: 100px;">
                  <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-user-{{ $user->id }}"
                    class="btn icon btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $user->id }}')">
                    <i class="bi bi-x-lg"></i>
                  </a>

                  @include('components.form.modal.user.edit')
                  @include('components.form.modal.user.delete')

                </td>
              </tr>
            @empty
              <tr>
                <th colspan="5" class="text-center">No data to display</th>
              </tr>
            @endforelse
          </tbody>
        </table>
        {{-- <div class="card-footer py-4">
          <nav aria-label="..." class="pagination justify-content-end">
            {{ $users->links() }}
          </nav>
        </div> --}}
      </div>

      @include('components.form.modal.user.add')
    </div>
  </section>
  <script>
    function showSweetAlert(userId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          //   document.getElementById('deleteForm_' + userId).submit();
          document.getElementById('modal-form-delete-user-' + userId).submit();
        }
      });
    }
  </script>
@endsection
