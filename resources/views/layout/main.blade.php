<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Login Microsoft</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@microsoft/mgt@latest/dist/bundle/mgt-loader.js"></script>
    {{-- <script type="module" src="https://unpkg.com/@microsoft/mgt@latest/dist/bundle/mgt-loader.js"></script> --}}
    {{-- <script src="{{ asset('js/provider.js') }}" type="module"></script> --}}
    @stack('css')
</head>
<body>
    @yield('main')
    {{-- <script>
        const simpleProvider = new SimpleProvider()
    </script> --}}
    @stack('js')
</body>
</html>
