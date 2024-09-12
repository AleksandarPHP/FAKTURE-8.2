@extends('partials.container') @section('content')
<div class="container-fluid app_content">
    <div class="row">
        <div class="col app_content_left">@include('partials.app_nav')</div>
        <div class="col app_content_right">
            @include('partials.app_header')
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="title">Klijenti</h1>
                </div>
                <div class="col-lg-3">
                    <a
                        href=" {{ url('klijenti/create') }}"
                        class="add_btn"
                        >Klijenti <i class="fas fa-user-plus"></i
                    ></a>
                </div>
            </div>

            <div class="invoice-table mt-5">
                <table width="100%" class="table-style viewManageTable">
                    <tbody>
                        <tr>
                            <td class="table-heading" style="width: 14px">
                                <input style="display: none" type="checkbox" />
                            </td>
                            <td class="table-heading">Naziv</td>
                            <td class="table-heading">PDV-ID</td>
                            <td class="table-heading">Uredi</td>
                            <td class="table-heading">Kopiraj</td>
                            <td class="table-heading">Izbriši</td>
                        </tr>
                        @if ($clients->total())
                        @foreach ($clients as $client)
                        <tr>
                            <td><input style="display: none" type="checkbox" name="id[]" value="{{ $client->id }}" /> </td>
                            <td> <b style="text-transform: uppercase">{{ $client->first_name }} </b> </td>
                            <td>{{ $client->pdv_id }}<span style="white-space: nowrap"></span></td>
                            <td><a href="{{ url('klijenti/'.$client->id.'/edit') }}"><i class="fa-solid fa-pen-to-square" style="color: #4a8fac;"></i></td>
                            <td><i class="fa-solid fa-copy" style="color: #4a8fac;"></i></td>
                            <td><a href="#" onclick="event.preventDefault();if(confirm('Da li ste sigurni?'))document.getElementById('delete-form').submit();"><i class="fa-solid fa-trash" style="color: #4a8fac;"></i></a></td>
                            <form id="delete-form" action="{{ url('klijenti/'.$client->id)}} " method="POST" style="display: none;">
                              @csrf
                              @method('DELETE')
                            </form>
                        </tr>
                        @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="6" ><b>Nema navedenih kijenata</b></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
