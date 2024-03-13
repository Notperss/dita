@extends('layouts.app')

@section('title', 'Permission Management')

@section('breadcrumb')
  <x-breadcrumb title="Permission Management" page="Permission Management" active="Permission"
    route="{{ route('permission.index') }}" />
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-permission">
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
            @forelse ($permissions as $permission)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->guard_name }}</td>
                <td>{{ $permission->description }}</td>
                {{-- <td>
                  <div class="dropdown">
                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="ri-more-2-fill"></i>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                          data-bs-target="#modal-form-edit-permission-{{ $permission->id }}">
                          Edit
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#"
                          onclick="event.preventDefault(); document.getElementById('modal-form-delete-permission-{{ $permission->id }}').submit()">
                          Delete
                        </a>
                      </li>
                    </ul>

                    @include('components.form.modal.permission.edit')
                    @include('components.form.modal.permission.delete')
                  </div>
                </td> --}}
                <td style="width: 100px;">
                  <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-permission-{{ $permission->id }}"
                    class="btn icon btn-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $permission->id }}')">
                    <i class="bi bi-x-lg"></i>
                  </a>

                  @include('components.form.modal.permission.edit')
                  @include('components.form.modal.permission.delete')

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

  @include('components.form.modal.permission.add')
  <script>
    function showSweetAlert(permissionId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          //   document.getElementById('deleteForm_' + permissionId).submit();
          document.getElementById('modal-form-delete-permission-' + permissionId).submit();
        }
      });
    }
  </script>
@endsection
