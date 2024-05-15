<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>English Dictionary</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('tools/jquery.min.js') }}" defer></script>
    <script src="{{ asset('tools/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('tools/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('tools/icons.js') }}" defer></script>
    <script src="{{ asset('tools/popper.min.js') }}" defer></script>
    <script src="{{ asset('tools/translate.min.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('tools/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    English Dictionary
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <a class="nav-link" href="{{ route('dictionary') }}">
                            <button class="btn btn-primary d-inline-flex align-items-center" type="button">
                                Dictionary
                                <i class="bi bi-arrow-right-circle"></i>
                            </button>
                        </a>
                        <a class="nav-link" href="{{ route('phrasal_verbs') }}">
                            <button class="btn btn-success d-inline-flex align-items-center" type="button">
                                Phrasal Verbs
                                <i class="bi bi-arrow-right-circle"></i>
                            </button>
                        </a>
                        <a class="nav-link" href="{{ route('dictionary') }}">
                            <button class="btn btn-warning d-inline-flex align-items-center" type="button">
                                Practice
                                <i class="bi bi-arrow-right-circle"></i>
                            </button>
                        </a>
                        <a class="nav-link" href="{{ route('dictionary') }}">
                            <button class="btn btn-danger d-inline-flex align-items-center" type="button">
                                Resume
                                <i class="bi bi-arrow-right-circle"></i>
                            </button>
                        </a>
                        <a class="nav-link" href="{{ route('insert') }}">
                            <button class="btn btn-info d-inline-flex align-items-center" type="button">
                                Insert
                                <i class="bi bi-arrow-right-circle"></i>
                            </button>
                        </a>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 background_standard">
            @yield('content')
        </main>
    </div>
</body>
</html>
