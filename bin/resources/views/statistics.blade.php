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
                <a class="nav-link" href="/">Strona Główna

                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/help">O grze</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/statistics">Statystyki
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/android">Android</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="window" id="hello">
    </div>
    <script src="{{asset('assets/js/statistics-receiver.js')}}"></script>
    @endsection