    <header>
      <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
          <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0">
              {{-- <li class="nav-item dropdown me-1">
                <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class='bi bi-envelope bi-sub fs-4'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li>
                    <h6 class="dropdown-header">Mail</h6>
                  </li>
                  <li><a class="dropdown-item" href="#">No new mail</a></li>
                </ul>
              </li> --}}
              @if (Auth::check())
                <li class="nav-item dropdown me-3">
                  <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                    data-bs-display="static" aria-expanded="false">
                    <i class='bi bi-bell bi-sub fs-4'></i>
                    <span class="badge badge-notification bg-danger">
                      {{ DB::table('folder_item_files')->whereDate('date_notification', today())->whereNotNull('notification')->where('company_id', auth()->user()->company_id)->where('division_id', auth()->user()->division_id)->count() }}
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                    aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-header">
                      <h6>Notifications Files Folder</h6>
                    </li>
                    @php
                      $files = App\Models\TransactionArchive\FolderDivision\FolderItemFile::whereNotNull('notification')
                          ->where('company_id', auth()->user()->company_id)
                          ->where('division_id', auth()->user()->division_id)
                          ->whereDate('date_notification', today())
                          ->take(5)
                          ->get();
                    @endphp

                    @forelse ($files as $file)
                      <li class="dropdown-item notification-item">
                        <a class="d-flex align-items-center" href="{{ route('folder.show', $file->folder->id) }}">
                          {{-- <div class="notification-icon bg-primary">
                          <i class="bi bi-cart-check"></i>
                        </div> --}}
                          <div class="notification-text ms-4">
                            <p class="notification-title font-bold">{{ $file->number }}</p>
                            <p class="notification-subtitle font-thin text-sm">{{ $file->notification }},
                              {{ Carbon\Carbon::parse($file->date_notification)->translatedFormat('d F Y ') ?? 'N/A' }}
                            </p>
                          </div>
                        </a>
                      </li>

                    @empty
                      <li>
                        <p class="text-center py-2 mb-0">Empty</p>
                      </li>
                    @endforelse
                    <li>
                      <p class="text-center py-2 mb-0"><a href="{{ route('folder.index') }}">See all notification</a>
                      </p>
                    </li>
                  </ul>
                </li>
              @endif

            </ul>
            <div class="dropdown">
              <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-menu d-flex">
                  <div class="user-name text-end me-3">
                    <h6 class="mb-0 text-gray-600">{{ Auth::user()->name ?? '' }}</h6>
                    @if (Auth::check())
                      <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->getRoleNames()->first() ?? '' }}</p>
                    @else
                      <p class="mb-0 text-sm text-gray-600">Guest</p>
                    @endif
                  </div>
                  <div class="user-img d-flex align-items-center">
                    <div class="avatar avatar-md">
                      @if (Auth::check() && Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="avatar">
                      @else
                        <img src="{{ asset('./assets/compiled/jpg/1.jpg') }}" alt="avatar">
                      @endif

                    </div>
                  </div>
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                style="min-width: 11rem;">
                @if (Auth::check())
                  <li>
                    <h6 class="dropdown-header">Hello, {{ Auth::user()->name ?? '' }}</h6>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                        class="icon-mid bi bi-person me-2"></i> My
                      Profile</a>
                  </li>
                  @can('admin')
                    <li><a class="dropdown-item" href="https://nugrohos-organization.gitbook.io/data-input-tapersip"
                        target="_blank"><i class="icon-mid bi bi-info-circle me-2"></i>
                        User Guide</a></li>
                  @endcan
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                      <span>Logout</span>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </a>
                  </li>
                @else
                  <li>
                    <h6 class="dropdown-header">Hello, Guest!</h6>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('login') }}">
                      <i class="icon-mid bi bi-box-arrow-right me-2"></i> Login
                    </a>
                    </a>
                  </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </header>
