@extends('layouts.master')

@section('title')
    Push Notification
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('push-notification/css/index.css')}}">
@endsection

@section('content')
@include('include.alert')
<div class="card">
    <div class="card-body">
        <div class="new-ntofication">
            <a href="{{route('push-notification.create')}}">
                <button class="btn btn-primary">New Notification</button>
            </a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pushNotification as $key => $item)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->message}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@endsection
