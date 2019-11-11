@extends('layouts.app')

@section('title', 'Laravel 6 Blade Template')

@section('sidebar')
@parent
  <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
  <p>Hi, {{$records['name']}}</p>

<!-- alert compnent. Also need to add the component in: Providers -> AppServiceProvider.php -> boot() method -->
@alert(['type' => 'success', 'icon' => 'check'])
  Success !
@endalert

<!-- current time -->
The current UNIX timestamp is {{ time() }}.

<br/><br/>

<!-- if else statement -->
@if (count($records) === 1)
  I have one record!
@elseif (count($records) > 1)
  I have multiple records!
@else
  I don't have any records!
@endif

<br/><br/>

<!-- switch statement -->
@switch(count($records))
    @case(1)
        First case...
        @break

    @case(2)
        Second case...
        @break

    @default
        Default case...
@endswitch

<br/><br/>

<!-- for loop statement -->
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
    <br/>
@endfor

<br/>

<!-- foreach statement -->
@foreach ($records as $record)
    <h6>{{ $record }}</h6>
@endforeach

<!-- PHP code -->
@php
  $users = ['Rafiq', 'Towhid', 'Ashraf', 'Tammum', 'ISTVN'];
@endphp

@foreach ($users as $user)
    @if ($user == 'Towhid')
        @continue
    @endif

    @if ($user == 'ISTVN')
        @break
    @endif

    <li>{{ $user }}</li>

@endforeach

<br/>

<!-- loop Variable / Loop first index or last index -->
@foreach ($users as $user)
    @if ($loop->first)
        This is the first iteration.
    @endif

    @if ($loop->last)
        This is the last iteration.
    @endif

    <li>{{ $user }}</li>
@endforeach

<!-- PHP code -->
@php
  $records = [];
@endphp

<!-- forelase statement -->
@forelse ($records as $record)
    <li>{{ $record }}</li>
@empty
    <p>No users</p>
@endforelse

<!-- PHP code -->
@php
  $cnt = 0;
@endphp

<!-- while loop statement -->
@while ($cnt < 5)
    <h6>I'm looping forever.</h6>

    <!-- PHP code -->
    @php
      $cnt++;
    @endphp
@endwhile

<br/>
<div class="line"></div>
<h5><a href="https://laravel.com/docs/6.0/blade#displaying-data">References</a></h5>

@endsection
