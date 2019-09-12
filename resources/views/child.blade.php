@extends('layouts.app')

@section('title', 'Laravel 6 Blade Template')

@section('sidebar')
    @parent
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>Hi, {{$name}}</p>

    @alert(['type' => 'success', 'icon' => 'check'])
      Success !
    @endalert

    The current UNIX timestamp is {{ time() }}.

@endsection
