@extends('layouts.app')
@section('navi-bar')

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/login">Zaloguj się
                    <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/">Strona Główna

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

<div class="window"id="hello">



                    <form  class="window" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="text" ><label><h2>Zalguj się</h2></label></div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="text" >E-Mail</label>

                            <div class="form">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="alert-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="text">Hasło</label>

                            <div class="form">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="alert-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">

                                    <label class="text" >
                                        <input type="checkbox" name="remember"> Zapamiętaj Mnie
                                    </label>
                        </div>
                        <div class="text">

                        <div class="form-group">
                            <div class="button">
                            <button type="submit" class="btn btn-primary">
                                <i class="text"></i> Login
                            </button>
                            </div>
                                <a class="text-white" href="/register">Nie masz konta?</a>
                        </div>
                        </div>
                    </form>


</div>
@endsection
