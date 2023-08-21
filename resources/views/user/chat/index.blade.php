@extends('layouts.app')
@section('content')
<div class="contents">
    <div class="container-fluid">
        <br>
        <div id="chat">
            <chat-vue id="{{$campaign->id}}" />
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection
