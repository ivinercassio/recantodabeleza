<!DOCTYPE html>
<html lang='zxx'>
<head>
	<title>@yield('title')</title>
	<meta charset='UTF-8'> 
	<meta name='description' content=' Divisima | eCommerce Template'>
	<meta name='keywords' content='divisima, eCommerce, creative, html'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<!-- Favicon -->
	<link href='{{url("/img/faviconAdm.png")}}' rel='shortcut icon'/>

	<!-- Google Font -->
	<link href='https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i' rel='stylesheet'>

    <!-- Fullcalendar -->
    <link href='{{asset("assets/fullcalendar/lib/main.css")}}' rel='stylesheet' />
    <link href='{{asset("assets/fullcalendar/fullcalendar.css")}}' rel='stylesheet'>

    <!-- Autocomplete -->
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

	<!-- Stylesheets -->
	<link rel='stylesheet' href='{{url("/assets/css/bootstrap.min.css")}}'/>
	<link rel='stylesheet' href='{{url("/assets/css/font-awesome.min.css")}}'/>
	<link rel='stylesheet' href='{{url("/assets/css/flaticon.css")}}'/>
	<link rel='stylesheet' href='{{url("/assets/css/slicknav.min.css")}}'/>
	<link rel='stylesheet' href='{{url("/assets/css/jquery-ui.min.css")}}'/>
	<link rel='stylesheet' href='{{url("/assets/css/owl.carousel.min.css")}}'/>
	<link rel='stylesheet' href='{{url("/assets/css/animate.css")}}'/>
	<link rel='stylesheet' href='{{url("/assets/css/style.css")}}'/> 
	<link rel='stylesheet' href='{{url("/assets/css/theme.default.css")}}'/>

    <!--====== Javascripts & Jquery ======-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='{{url("/assets/js/jquery-3.2.1.min.js")}}'></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
	<script src='{{url("/assets/js/bootstrap.min.js")}}'></script>
	<script src='{{url("/assets/js/jquery.slicknav.min.js")}}'></script>
	<script src='{{url("/assets/js/owl.carousel.min.js")}}'></script>
	<script src='{{url("/assets/js/jquery.nicescroll.min.js")}}'></script>
	<script src='{{url("/assets/js/jquery.validate.min.js")}}'></script>
	<script src='{{url("/assets/js/jquery.zoom.min.js")}}'></script>
	<script src='{{url("/assets/js/jquery-ui.min.js")}}'></script>
	<script src='{{url("/assets/js/jquery.mask.min.js")}}'></script>
    <script src='{{url("/assets/js/validator.min.js")}}'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script> 
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js'></script>
    <script src='{{url("/assets/js/jquery.quicksearch.js")}}'></script>
    <script src='{{url("/assets/js/jquery.tablesorter.min.js")}}'></script>
    <script src='{{url("/assets/js/moment-with-locales.min.js")}}'></script>
    <script src='{{url("/assets/js/locale-moment_pt-br.js")}}'></script>
	<script src='{{url("/assets/js/main.js")}}'></script>
	<script src='{{url("/assets/js/projeto.js")}}'></script>
	<script src='{{url("/assets/js/validacao.js")}}'></script>
    <script src='{{asset("assets/fullcalendar/script.js")}}'></script>
    
</head>
<body>
    <!-- Page Preloder -->
    <section class='footer-section'>        
    @if(Auth::check() === false)
        return redirect()->route('adm.login');
    @endif
        <div class='container'>
            <div id='preloder'>
                <div class='loader'></div>
            </div>
            <div class='text-center'>
                <a href='{{url("/adm")}}'><img src='{{url("/img/logo-light.png")}}' alt=''></a>                    
                <div class='col-md-2 offset-md-11'>
                    <a href='{{ route("adm.login")}}' title='Login'><img src='{{url("/img/icons/user-light.png")}}' alt='Login'></a>
                    <a href="#" title='Compras'><img src='{{url("/img/icons/cart.png")}}' alt='Compras'></a>
                    @if(Auth::check())
                        <p class='light'>{{ Auth::user()->name }}<br>
                        {{ app(App\Http\Controllers\UserController::class)->getCategory() }}</p>
                    @else
                        <p class='light'>Visitante</p>
                    @endif
                </div>  
            </div>
            <!-- Header section -->
            <header class='header-section'>
                <nav class='main-navbar'>
                    <div class='container text-center'>
                        <!-- menu -->
                        <ul class='main-menu'>
                            <li><a href='{{url("/adm")}}'>Home</a></li>
                            <li><a href='#' class='none'>Cortes</a> 
                                <ul class='sub-menu text-left'> 
                                    <li><a href='#'>Feminino</a></li>
                                    <li><a href='#'>Masculino</a></li>
                                    <li><a href='#'>Infantil</a></li>
                                </ul>
                            </li>
                            <li><a href='#' class='none'>Coloração</a> 
                                <ul class='sub-menu text-left'>
                                    <li><a href='#'>Morenas</a></li>
                                    <li><a href='#'>Loiras</a></li>
                                    <li><a href='#'>Ruivas</a></li>
                                </ul>
                            </li>
                            <li><a href='#' class='none'>Make-up</a> 
                                <ul class='sub-menu text-left'>
                                    <li><a href='#'>Dia-a-dia</a></li>
                                    <li><a href='#'>Para noite</a></li>
                                    <li><a href='#'>Noivas</a></li>
                                </ul>
                            </li>
                            <li><a href='#'>Depilação & Sobrancelha</a>
                                <ul class='sub-menu text-left'>
                                    <li><a href='#'>Depilação à laser</a></li>
                                    <li><a href='#'>Depilação com cera</a></li>
                                    <li><a href='#'>Sobrancelha com renda</a></li>
                                    <li><a href='#'>Sobrancelha comum</a></li>
                                </ul>
                            </li>
                            <li><a href='#'>Masculino</a>
                                <ul class='sub-menu text-left'>
                                    <li><a href='#'>Barba e bigode</a></li>
                                    <li><a href='#'>Pintura de cabelo</a></li>
                                    <li><a href='#'>Descoloração de cabelo</a></li>
                                </ul>
                            </li>
                            <li><a href='#'>Produtos</a>
                                <ul class='sub-menu text-left'>
                                    <li><a href='#'>Shampoo e condicionador</a></li>
                                    <li><a href='#'>Cremes para hidratação</a></li>
                                    <li><a href='#'>Barbearia</a></li>
                                </ul>
                            </li>
                            <li><a href='#'>Ofertas</a></li>
                        </ul>
                    </div>
                </nav>
            </header>
        </div>
    </section>
    <!-- Header section end -->
    
    <!-- Page info -->
    <section class='features-section'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-0 p-0 feature'></div>
                <div class='col-md-12 p-0 feature'>
                    <div class='feature-inner'>
                             @yield('icon')
                             <img scr='{{url("/img/blog-thumbs/line.png")}}' width='10px'>
                        <h2> @yield('title') </h2>  
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page info end -->

    @yield('content')

</body>
</html>