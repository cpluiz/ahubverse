@extends('frontend.base')

@push('page_header')
    <style>
        #unity-canvas{ background: transparent; }
        body{margin: 0 !important}
    </style>
@endpush

@section('body')
    <canvas id="unity-canvas" style="width: 100vw !important; height: 100vh !important; max-width: 100%; max-height: 100%; background:transparent;"></canvas>
    <script src="{{(secure_asset('js/Build/js.loader.js'))}}"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const myParam = urlParams.get('channelName');
        const storedChannelName = localStorage.getItem('channelName');
        @if(Session::has('channelID'))
        window.channelID = {{Session::get('channelID')}}
        @endif
        if(myParam != null)
            localStorage.setItem('channelName', myParam);
        else if(storedChannelName != null)
            urlParams.set('channelName', storedChannelName);
        createUnityInstance(document.querySelector("#unity-canvas"), {
            dataUrl: "{{secure_asset('js/Build/js.data.unityweb')}}",
            frameworkUrl: "{{secure_asset('js/Build/js.framework.js.unityweb')}}",
            codeUrl: "{{secure_asset('js/Build/js.wasm.unityweb')}}",
			streamingAssetsUrl: "StreamingAssets",
			companyName: "HUB Tech",
			productName: "AhubVerse",
			productVersion: "1.0",
            matchWebGLToCanvasSize: true, // Uncomment this to separately control WebGL canvas render size and DOM element size.
            devicePixelRatio: 1, // Uncomment this to override low DPI rendering on high DPI displays.
        }).then((unityInstance) => {
            window.unityInstance = unityInstance;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@endsection