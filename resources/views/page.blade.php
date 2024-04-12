@extends('layout.master')

    <!-- #### Area Content ###-->
    @section('contenu')
        @foreach($tabSection AS $sect)
            @php($var = 'data'.ucfirst($sect['vue']))
            @php($$var = $data[$sect['vue']] ?? [])
            @include("sections.$sect[vue]", compact($var))
        @endforeach
    @endsection