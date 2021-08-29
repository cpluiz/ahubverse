@extends('frontend.base')
@push('page_header')
    <style type="text/css">{!! include public_path('css/frontend/twitch/config.min.css') !!}</style>
@endpush
@section('body')
<div class="d-none">
    <li id="list-template" class="list-group-item d-flex justify-content-between align-items-center">
        <span class="streamerName"></span>
        <span class="removeStreamer">Remove from list</span>
    </li>
</div>
<section>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-10 col-md-6">
                        <ul id="streamersList" class="list-group">
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10">
                        <label for="streamerName" class="form-label">Adicionar novo streamer na lista</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">https://twitch.tv/</span>
                            <input type="text" class="form-control" id="streamerName" aria-describedby="basic-addon3">
                        </div>
                        <span id="addStreamer">Adicionar Streamer</span>
                    </div>
                </div>
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
$(function() {
    $('#streamersList').on('DOMSubtreeModified', function(){
        updateRemoveListener();
    });
    $("#addStreamer").on('click', function(){
        let streamerName = $('#streamerName').val();
        if(streamerName.length > 1){
            if(document.getElementById(streamerName))
                return;
            let newStreamer = $('#list-template').clone();
            newStreamer.attr('id', streamerName);
            newStreamer.find('.streamerName').text(streamerName)
            $("#streamersList").append(newStreamer);
        }
    });
    const updateRemoveListener = function(){
        $(".removeStreamer").off('click');
        $(".removeStreamer").on('click', function(){removeStreamerFromList($(this))});
    }
    const removeStreamerFromList = function(el){
        el.parent().remove();
    }
});
</script>
@endpush
