@extends('layouts.app')


@section('navi-bar')
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            @if(Auth::guest())
                <li class="nav-item">
                    <a class="nav-link" href="/login">Zaloguj się
                        <span class="sr-only">(current)</span></a>
                </li>
            @elseif(Auth::user()->admin())
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="text"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #32383e">

                        <p>
                            <a class="text2" href="/logout">wyloguj się </a>
                        </p>
                        <p>
                            <a class="text2" href="/home">moje gry</a>
                        </p>

                        <p>
                    <a class="text2" href="/admin">panel administracyjny</a>
                </p>
                </div>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="text"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: #32383e">

                        <p>
                            <a class="text2" href="/logout">wyloguj się </a>
                        </p>
                        <p>
                            <a class="text2" href="/home">moje gry</a>
                        </p>


                    </div>




                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="/">Strona Główna
                    <span class="sr-only">(current)</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/help">O grze</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/statistics">Statystyki</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/android">Android</a>
            </li>
        </ul>
    </div>
@endsection


@section('content')
<div class="container">
    <div class="window" id="hello">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="text-white"><h2>Panel użytkownika</h2></div>

                <div class="text-white">
                    <p style="line-height:10">   Witaj w panelu użytkownika! </p>
                </div>
                <p style="line-height:20; alignment: center; margin-left: 20%" > <button class="btn btn-primary" id="available"> Dostępne gry</button>
                    <button class="btn btn-primary" id="my-games"> Moje gry</button>
                </p>

            </div>
        </div>
    </div>
</div>
@endsection
