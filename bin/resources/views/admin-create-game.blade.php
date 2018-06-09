@extends('layouts.admin')
@section('content')


    <form role="from" method="GET" action="{{url('admin/created')}}" id="form" >
        {{ csrf_field() }}
        <div class="text-info">
            <h2>
                Stwórz grę!
            </h2>

            <div class="form" action="admin/created">
                <div class="form-group">
                    <label class="label-st">Nazwa gry</label>
                <input type="text" class="form-control" name="name-game">
                </div>

                <div class="form-group">
                    <label class="label-st">Maksymalna liczba graczy</label>
                    <input type="number" class="form-control" name="number-of-players">
                </div>
                <div class="form-group">
                    <label class="label-st">Czas gry w minutach</label>
                    <input type="number" class="form-control" name="minutes">
                </div>

                <div class="form-group">

                    <button type="submit" class="btn btn-primary" id="create-game" href="#create-game">
                        <span class="text-white" >create game</span>
                    </button>
                </div>
            </div>


        </div>

    </form>



    <div id="waiting-div">

    </div>

@endsection