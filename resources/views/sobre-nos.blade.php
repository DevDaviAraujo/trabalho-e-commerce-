@extends('index')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sobre-nos.css') }}">
@endpush

@section('conteudo')

<h1 class="Titulo">CONHEÇA NOSSA HISTORIA</h1> 

<p class="historia"> 🏆 Nossa História,

Uma equipe apaixonada por tecnologia que busca facilitar o dia a dia das pessoas com soluções criativas e eficientes.

Tudo começou em 2025, quando cinco amigos — Heitor, Breno, Davi e André — decidiram transformar uma paixão em algo maior. O que antes era apenas um interesse compartilhado por tênis, estilo e tecnologia, virou o ponto de partida para criar um site dedicado ao universo dos tênis.

Unindo diferentes talentos, cada um trouxe algo único para o projeto: design, programação, marketing, criatividade e, claro, muita vontade de fazer acontecer. A ideia era simples, mas ambiciosa — criar um espaço online onde amantes de tênis pudessem descobrir, comparar e comprar seus modelos favoritos de forma prática e confiável.

Mesmo começando pequenos, o grupo acreditou que todo grande passo começa com um primeiro passo firme. E assim nasceu o projeto — com o objetivo de unir estilo, inovação e autenticidade em cada detalhe do site.

Hoje, seguimos crescendo, aprendendo e aprimorando a plataforma, sempre com o mesmo espírito que nos uniu desde o início: a paixão por tênis e o desejo de criar algo incrível juntos. </p>
<div class="logo5 mx-auto"> <img src="{{ asset('storage/asset/logo3.avif') }}" alt="logo5"> </div> 

@endsection
