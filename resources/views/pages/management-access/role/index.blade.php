@extends('layouts.app')

@section('title', 'Role Management')

@section('breadcrumb')
  <x-breadcrumb title="Role Management" page="Role Management" active="Role" route="{{ route('role.index') }}" />
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-role">
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
              <th scope="col">Guard</th>
              <th scope="col">Description</th>
              <th scope="col" class="col-1"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($roles as $role)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $role->name }}</td>
                <td>{{ $role->guard_name }}</td>
                <td>{{ $role->description }}</td>
                {{-- <td>
                  <div class="dropdown">
                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="ri-more-2-fill"></i>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                          data-bs-target="#modal-form-edit-role-{{ $role->id }}">
                          Edit
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#"
                          onclick="event.preventDefault(); document.getElementById('modal-form-delete-role-{{ $role->id }}').submit()">
                          Delete
                        </a>
                      </li>
                    </ul>

                    @include('components.form.modal.role.edit')
                    @include('components.form.modal.role.delete')
                  </div>
                </td> --}}

                <td style="width: 100px;">
                  <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-role-{{ $role->id }}"
                    class="btn icon btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $role->id }}')">
                    <i class="bi bi-x-lg"></i>
                  </a>

                  @include('components.form.modal.role.edit')
                  @include('components.form.modal.role.delete')

                </td>
              </tr>
            @empty
              <tr>
                <th colspan="5" class="text-center">No data to display</th>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </section>
  @include('components.form.modal.role.add')
  <script>
    function showSweetAlert(roleId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          //   document.getElementById('deleteForm_' + roleId).submit();
          document.getElementById('modal-form-delete-role-' + roleId).submit();
        }
      });
    }
  </script>
@endsection
