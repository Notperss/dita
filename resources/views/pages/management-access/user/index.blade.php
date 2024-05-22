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
              <th scope="col">Company</th>
              <th scope="col">Division</th>
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
                    <span class="badge bg-light-info">{{ $role->name }}</span>
                  @endforeach
                </td>
                <td>
                  {{ $user->company->name ?? 'N/A' }}
                </td>
                <td>
                  {{ $user->division->name ?? 'N/A' }}
                </td>
                <td>
                  @if (!blank($user->email_verified_at))
                    <span class="badge bg-light-success">Active</span>
                  @else
                    <span class="badge bg-light-danger">Inactive</span>
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
                  <div class="btn-group mb-1">
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-user-{{ $user->id }}"
                          class="dropdown-item" title="Edit"><i class="bi bi-pencil"></i> Edit</a>
                        <a class="dropdown-item" title="Delete" onclick="showSweetAlert('{{ $user->id }}')">
                          <i class="bi bi-x-lg"> Delete</i>
                        </a>
                      </div>
                    </div>
                  </div>


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
  <script>
    $(document).ready(function() {
      $('.modal-form-user').on('change', '#company_id', function() {
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


@endsection
