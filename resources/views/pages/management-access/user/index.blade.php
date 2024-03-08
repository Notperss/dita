@extends('layouts.app')

@section('title', 'User')
@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>User</h3>
          <p class="text-subtitle text-muted">List all data from the user.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
              <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Master Data</a></li>
              <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          <a href="{{ route('backsite.user.create') }}" class="btn btn-primary"> <i class="bi bi-plus-lg"></i>
            Add data</a>
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-striped" id="table1">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">NIK</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Email</th>
              <th class="text-center">Tipe User</th>
              <th class="text-center">Perusahaan</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $user->detail_user->nik ?? 'N/A' }}</td>
                <td class="text-center">{{ $user->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $user->email ?? 'N/A' }}</td>
                <td class="text-center">{{ $user->detail_user->type_user->name ?? '' }}</td>
                <td class="text-center">{{ $user->detail_user->company->name ?? '' }}</td>
                <td class="text-center">
                  @if ($user->detail_user->status == 1)
                    Aktif
                  @elseif($user->detail_user->status == 2)
                    Tidak Aktif
                  @else
                    N/A
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('backsite.user.edit', $user->id) }}" class="btn icon btn-primary" title="Edit"><i
                      class="bi bi-pencil"></i></a>
                  <a class="btn icon btn-danger" title="Delete" onclick="showSweetAlert('{{ $user->id }}')"
                    {{-- @if (DB::table('departments')->where('user_id', $user->id)->exists()) style="display: none;" @endif --}}>
                    <i class="bi bi-x-lg"></i>
                  </a>

                  <form id="deleteForm_{{ $user->id }}"
                    action="{{ route('backsite.user.destroy', encrypt($user->id)) }}" method="POST">
                    @method('DELETE')
                    @csrf
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
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
          document.getElementById('deleteForm_' + userId).submit();
        }
      });
    }
  </script>
@endsection
