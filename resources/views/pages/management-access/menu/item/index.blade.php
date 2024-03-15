@extends('layouts.app')

@section('title', 'Menu Items')

@section('breadcrumb')
  <x-breadcrumb title="Menu Management" page="Menu Management" active="Item" route="{{ route('menu.index') }}" />
@endsection

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
            data-bs-target="#modal-form-add-menu">
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
              <th scope="col">Icon</th>
              <th scope="col">Route</th>
              <th scope="col">Permission</th>
              <th scope="col">Status</th>
              <th scope="col" class="col-1"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($menuItems as $menuItem)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $menuItem->name }}</td>
                <td>{{ $menuItem->icon }}</td>
                <td>{{ $menuItem->route }}</td>
                <td>{{ $menuItem->permission_name }}</td>
                <td>
                  @if ($menuItem->status)
                    <span class="badge bg-light-success">Show</span>
                  @else
                    <span class="badge bg-light-danger">Hide</span>
                  @endif
                </td>
                {{-- <td>
                  <div class="dropdown">
                    <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="ri-more-2-fill"></i>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                          data-bs-target="#modal-form-edit-menu-{{ $menuItem->id }}">
                          Edit
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#"
                          onclick="event.preventDefault(); document.getElementById('modal-form-delete-menu-{{ $menuItem->id }}').submit()">
                          Delete
                        </a>
                      </li>
                    </ul>

                    @include('components.form.modal.menu-item.edit')
                    @include('components.form.modal.menu-item.delete')

                  </div>
                </td> --}}
                <td style="width: 100px">
                  <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-menu-{{ $menuItem->id }}"
                    class="btn icon btn-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger btn-sm" title="Delete" onclick="showSweetAlert('{{ $menuItem->id }}')">
                    <i class="bi bi-x-lg"></i>
                  </a>

                  @include('components.form.modal.menu-item.edit')
                  @include('components.form.modal.menu-item.delete')

                </td>
              </tr>
            @empty
              <tr>
                <th colspan="5" class="text-center">No data to display</th>
              </tr>
            @endforelse
          </tbody>
        </table>
        <div class="card-footer py-4">
          <nav aria-label="..." class="pagination justify-content-end">
            {{ $menuItems->links() }}
          </nav>
        </div>
      </div>
    </div>
  </section>

  @include('components.form.modal.menu-item.add')
  <script>
    function showSweetAlert(menuId) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // If the user clicks "Yes, delete it!", submit the corresponding form
          //   document.getElementById('deleteForm_' + menuId).submit();
          document.getElementById('modal-form-delete-menu-' + menuId).submit();
        }
      });
    }
  </script>
@endsection
