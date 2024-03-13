 <div class="col-12 col-md-6 order-md-1 order-last">
   <h3>{{ $title }}</h3>
   <p class="text-subtitle text-muted">List all data from {{ $title }}.</p>
 </div>
 <div class="col-12 col-md-6 order-md-2 order-first">
   <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
     <ol class="breadcrumb">
       {{-- <li class="breadcrumb-item"><a href="{{ route('backsite.dashboard.index') }}">Dashboard</a></li> --}}
       <li class="breadcrumb-item"><a href="{{ $route }}">{{ $page }}</a></li>
       <li class="breadcrumb-item active">{{ $active }}</li>
     </ol>
   </nav>
 </div>
