@extends('partials.container')

@section('content')
<div class="container-fluid app_content">
  <div class="row">
    <div class="col app_content_left">
      @include('partials.app_nav')
    </div>
    <div class="col app_content_right">
      @include('partials.app_header')
      <div class="row">
        <div class="col-6">
          <h1 class="title">Postavke</h1>
        </div>
        <div class="col-6">
          <a href="{{ url('postavke/create') }}" class="add_btn">Novi radnik <i class="fas fa-user-plus"></i></a>
        </div>
      </div>
      <div class="workers">
        @if(count($users) == 0)
        <h6>Nema nijedan radnik za prikazivanje.</h6>
        @endif
        @foreach ($users as $user)
        <div class="row worker">
          <div class="col-md-5">
            <div class="worker_name">
              @if($user->image)
              <img src="{{ asset('storage/users/res_'.$user->image) }}" alt="photo">
              @else
              <img src="{{ asset('assets/images/no_image.png') }}" alt="photo">
              @endif
              <h4>{{ $user->name }}</h4>
            </div>
          </div>
          <div class="col-md-7 text-right">
            @if($user->is_admin)
            <div class="worker_type">
              <i class="fas fa-user-shield"></i> Admin
            </div>
            @else
            <div class="worker_type">
              <i class="far fa-user"></i> Radnik
            </div>
            @endif
            @if($user->is_active)
            <div class="worker_status active">
              Aktivan
            </div>
            @else
            <div class="worker_status inactive">
              Neaktivan
            </div>
            @endif
            <a href="{{ url('postavke/'.$user->id.'/edit') }}" class="worker_edit">
              <i class="fas fa-edit"></i>
            </a>
          </div>
        </div>
        @endforeach
      </div>
      @if($users->hasPages())
      {{ $users->links() }}
      @endif
      @include('partials.app_copyright')
    </div>
  </div>
</div>
@endsection