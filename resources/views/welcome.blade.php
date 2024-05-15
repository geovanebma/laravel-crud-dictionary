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
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Bem vindos ao English Dictionary, aqui você pode ter um aprendizado melhor sobre seu inglês.</h3>
                    <span>Aprenda as palavras do cotidiano, estima-se que um falante nativo de inglês tenha um vocabulário ativo composto por cerca de 20.000 a 35.000 palavras. Essas palavras incluem termos de uso comum, vocabulário técnico e especializado, juntamente com expressões idiomáticas e gírias. E tudo isso, você pode aprender e acompanhar por aqui a sua evolução!</span>
                </div>
            </div>
        </div>
    </body>
</html>
@endsection