@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>English Dictionary</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/phrasal_verbs.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="container">
          <phrasal_verbs-component></phrasal_verbs-component>
        </div>
    </body>
</html>
@endsection