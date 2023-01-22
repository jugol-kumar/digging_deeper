@extends('layouts.app')

@section('content')
    <div id="chatting">
        <chat name="{{ Auth::user()->name }}"></chat>
    </div>
@endsection
