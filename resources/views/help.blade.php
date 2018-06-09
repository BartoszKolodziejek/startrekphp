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

                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="/help">O grze
                    <span class="sr-only">(current)</span></a>
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
        <div class="window" id="hello" style="overflow: auto">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="text-white"><h2>O grze</h2></div>
                    <div class="text-white" >

                        <h4>Gameplay</h4>

                        <p>Ustawienie startowe są takie same dla wszystkich graczy i inicjowane losowo, gdy administrator otworzy nową grę. Jego rolą jest także ustawienie takich wartości,
                        jak czas trwania, nazwa gry i maksymalna liczba graczy.
                        Gracze są dowódcami statku kosmicznego Enterprise NCC-1701
                        i mają za zadanie eliminację Klingonów,
                        aby w galaktyce zapanowała demokracja.
                        Galaktyka jest złożona z 64 kwadrantów podzielonych na 64 sektory .
                        Statek gwiezdny może się poruszać pomiędzy sektorami i kwadrantami za pomocą komend tekstowych.
                        Statek przy każdym poruszeniu, lub użyciu laserów korzysta z jednostek energii.
                        Celem gry jest zniszczenie każdego klingońskiego statku, nie pozwalając jednocześnie na zniszczenie statku Enterprise.
                        Do zniszczenia statku dochodzi, gdy liczba jednostek energii, lub tarczy spadnie do 0. Gra się kończy również, gdy czas przewidziany
                            przez administratora na rozgrywkę się skończy. Wszystkie komendy wykonywane są po wciśnięciu klawisza enter.</p>




                        <h4>Warp engine (komenda  w lub W)</h4>
                   <p> Warp engine służy do przemieszczania się pomiędzy kwadrantami. Na kżdy ruch zużywana jest energia. Ponadto każdy ruch zajmuje jeden dzień galaktyczny. Na wykonie misji enterprise
                       ma 30 dni galaktycznych.</p>

                        <p>Kurs - numer od 0 to 8 wskazujący kierunek, startując od, z przeciwnym ruchem wskazówek zegara. Dopuszczalne są też wartość pomiędzy, np. 0.5 przesunie statek pomiędzy kierunkiem 0, a 1.</p>
                    <p> 3&nbsp;&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;1</p>
                   <p>\ &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; /</p>
                        <p>4 &nbsp;-&nbsp; E&nbsp; -&nbsp; 0</p>

                        <p>/ &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; \</p>
                        <p>5 &nbsp;&nbsp;&nbsp;&nbsp;  6&nbsp;&nbsp;&nbsp;&nbsp;   7</p>

                        <p>Następnie po spacji należy podać liczbę kroków, jakie ma wykonać enterprise.</p>

                        <h4>Short range engine (komenda s lub S)</h4>

                        <p>Ten silnik na podobnych zasadach jak warp służy do poruszania się po sektorach wewnątrz kwadrantu. Kiedy Enterprise znajdzie się w pobliżu Bazy gwizdnej zostaną uzupełnione zapasy, tj. torpedy, energia i tarcza.</p>

                        <h4>Long range sensors (komenda l lub L)</h4>
                        <p>Komenda ta służy do skanowania kwadrantów w okolicy (tych, które ganiczą z tym, w którym znajduje się enterprise). Pierwsza cyfra oznacza liczbę Klingonów, druga liczbę gwiazd, trzecia liczbę baz.
                            Po wciśnięciu klawisza escape zostanie pokazana ponownie mapa kwadrantu, w którym znajduje się Enterprise.</p>

                        <h4>Phasers (komenda p lub P)</h4>

                        <p> Wytrzeliwana porcja energii w klingonów. Phasery są w stanie przenikać przez gwiazdy i bazy, ale zużywają energię. Po wybraniu komendy, gracz zostanie poproszony o kierunek strzału.</p>
                        <p> 3&nbsp;&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;1</p>
                        <p>\ &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; /</p>
                        <p>4 &nbsp;-&nbsp; E&nbsp; -&nbsp; 0</p>

                        <p>/ &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; \</p>
                        <p>5 &nbsp;&nbsp;&nbsp;&nbsp;  6&nbsp;&nbsp;&nbsp;&nbsp;   7</p>


                        <h4>Torpedy (komenda t lub T)</h4>
                   <p> Niewielka liczba torped jest na wyposażeniu enterprise już na początku misji. Torpedy nie mogą przenikać przez gwiazdy i bazy gwiezdne. po wybraniu komendy zostaniemy poproszeni o wskazanie kierunku.</p>

                        <h4>Galaktyczna mapa ( komenda g lub G)</h4>

                        <p>Pokazuje mapę galaktyki wraz z kwarantami, które zostały zeskanowane przez Enterprise.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
