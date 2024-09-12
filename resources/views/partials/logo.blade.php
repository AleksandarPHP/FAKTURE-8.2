<span class="app_logo">
    @php
    $userDetails = App\Models\UserDetail::find(1);
    @endphp
                @if($userDetails->image)
                <img src="{{ asset('storage/company/res_'.$userDetails->image) }}" alt="photo" class="img-fluid">
                @else
                <img src="{{ asset('assets/images/no_image.png') }}" alt="photo" class="img-fluid">
                @endif
<!--  <img src="{{ asset('assets/images/logo.png') }}" alt="logo"> -->
</span>