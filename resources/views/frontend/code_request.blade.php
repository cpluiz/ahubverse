@extends('frontend.base')
@section('body')
<h2>Click on the link below to request your code to integrate your chat on Unity</h2>
<a href="https://id.twitch.tv/oauth2/authorize?client_id={{env('TWITCH_CLIENT_ID')}}&redirect_uri={{route('after_login')}}&response_type=code&scope=chat:read+chat:edit+channel:moderate+whispers:read+whispers:edit+channel_editor">request code</a>
@endsection
