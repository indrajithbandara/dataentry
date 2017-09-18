@extends('layouts.main')

@section('content')
    @if(Request::is('home'))
        <div id="dashboard-app">
            <dashboard></dashboard>
        </div>
    @endif

    @if(Request::is('settings'))
        <div id="settings-app">
            <settings></settings>
        </div>
    @endif
@endsection
