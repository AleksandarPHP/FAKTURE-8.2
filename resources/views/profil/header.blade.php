<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <div class="row">
                <div class="col-12">
                    <h1 class="title">Moj profil</h1>
                </div>
            </div>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a
                        href="{{ url('moj-profil')}}"
                        class="nav-link @if (request()->is('moj-profil')) active @endif"
                        id="nav-1-tab"
                    >
                        Korisnički profil
                    </a>
                    <a
                        href="{{ url('moj-profil/2')}}"
                        class="nav-link @if (request()->is('moj-profil/2')) active @endif"
                        id="nav-2-tab"
                    >
                        Detalji moje fabrike
                    </a>
                    <a
                        href="{{ url('moj-profil/3')}}"
                        class="nav-link @if (request()->is('moj-profil/3')) active @endif"
                        id="nav-3-tab"
                    >
                        Pojedinosti o plaćanju
                    </a>
                    <a
                        href="{{ url('moj-profil/4')}}"
                        class="nav-link @if (request()->is('moj-profil/4')) active @endif"
                        id="nav-4-tab"
                    >
                        Postavke e-pošte
                    </a>
                    <a
                        href="{{ url('moj-profil/5')}}"
                        class="nav-link @if (request()->is('moj-profil/5')) active @endif"
                        id="nav-5-tab"
                    >
                        Postavke faktura
                    </a>
                </div>
            </nav>