<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('assets/css/simple-sidebar.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="/admin">
                    Panel Administracyjny
                </a>
            </li>
            <li>
                <a href="/admin/create" id="create">Stwórz grę</a>
            </li>
            <li>
                <a href="/delete/users">Usuń użytkowników</a>
            </li>
            <li>
                <a href="/delete/games">Usuń grę</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
          <p> @yield('content')</p>
            <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Otwórz menu</a>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="{{asset('assets/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/jquery/jquery.slim.js')}}"></script>
<script src="{{asset('assets/jquery/ajax.js')}}"></script>
<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
<script src="{{asset('assets/js/waiting.js')}}"></script>

</body>

</html>
