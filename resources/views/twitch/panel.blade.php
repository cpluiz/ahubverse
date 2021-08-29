@extends('frontend.base')
@push('page_header')
    <style type="text/css">{!! include public_path('css/frontend/twitch/config.min.css') !!}</style>
@endpush
@section('body')
<section>
    <div class="container">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<!--import jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!--import extension helper library -->
<script src="https://extension-files.twitch.tv/helper/v1/twitch-ext.min.js"></script>
<script type="text/javascript">
    window.Twitch.ext.onAuthorized(function(auth) {
        console.log('The Helix JWT is ', auth.helixToken);
    });
</script>
@endpush
