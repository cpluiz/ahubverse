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
        createUnityInstance(document.querySelector("#unity-canvas"), {
            dataUrl: "{{secure_asset('js/Build/js.data')}}",
            frameworkUrl: "{{secure_asset('js/Build/js.framework.js')}}",
            codeUrl: "{{secure_asset('js/Build/js.wasm')}}",
            streamingAssetsUrl: "StreamingAssets",
            companyName: "DefaultCompany",
            productName: "TwitchInteraction",
            productVersion: "1.0",
            matchWebGLToCanvasSize: true, // Uncomment this to separately control WebGL canvas render size and DOM element size.
            devicePixelRatio: 1, // Uncomment this to override low DPI rendering on high DPI displays.
        }).then((unityInstance) => {
            window.unityInstance = unityInstance;
        });
    </script>
@endsection
