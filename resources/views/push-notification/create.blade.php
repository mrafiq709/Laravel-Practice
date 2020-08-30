@extends('layouts.master')

@section('title')
    Create Push Notification
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('push-notification/css/create.css')}}">
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="create-ntofication">
        <form action="{{route('push-notification.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" class="form-control" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="btn-send">
                <button class="btn btn-primary" type="submit">Send</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection