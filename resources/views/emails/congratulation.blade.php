<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            @php
                include 'css/bootstrap.min.css';
            @endphp
        </style>
    </head>

    <body class="container p-3">
        <header class="container row bg-light p-4 my-4">
            <figure class="img-fluid col-2">
                <img src="{{asset('imagenes/template/logo.png')}}" alt="logo">
            </figure>
        </header>
        <main>
            <h1>Felicidades</h1>
            <h2>Has publicado tu primera anuncio en CIFOPOP!</h2>
            <p>
                Tu nueva anuncio {{$anuncio->titulo.' '.$anuncio->created_at}} ya
                aparece en los resultados.
            </p>
            <p>
                Sigue así, estás colaborando para que CIFOPOP
                se convierta en la primera red de usuarios de
                anuncioa de los CIFO.
            </p>
        </main>
        <footer class="page-footer font-small p-4 bg-light">
            <p>
                Aplicación reversionada por {{$autor}} como prueba final del curso Laravel.
            </p>
            <p>
                Desarrollada haciendo uso de <b>Laravel</b> y <b>Boostrap</b>.
            </p>
        </footer>

    </body>
</html>
