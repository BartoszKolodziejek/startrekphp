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
    <div class="window" id="hello">



                    <form class="window" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="text"><h2>Rejestracja</h2></div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="text">Nazwa</label>

                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="alert-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="text">E-Mail</label>


                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="alert-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>


                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="text">Hasło</label>


                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="alert-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>


                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="text">Powtórz Hasło</label>


                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="alert-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        <div class="text">
                        <div class="form-group">
                                <div class="button">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Zarejestruj się
                                </button>

                                </div>
                            <a class="text-white" href="/login">Mam już konto</a>
                        </div>
                        </div>
                    </form>
                </div>
@endsection
