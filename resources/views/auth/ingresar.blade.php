<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Inicio de sesión - Vinculamos</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('public/css/estilos.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href={{-- '{{ asset('public/img/aiep_chico.png') }}' --}} /> {{-- Logito de la pestaña --}}

</head>

<body
    style=" background-color: #515151;border-color: #515151 /*background:  url({{ asset('public/img/Imagen-auth.jpg') }}) */  ;background-size:cover; background-repeat:repeat;background-attachment: fixed;background-position: center;">
    <section class="ftco-section" style="margin-right: 1%; display: flex; align-items:center;">
        <div class="container" style="background: rgba(255,255,255,0.50);  border-radius: 50px; width:500px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="border-radius: 50px; margin: 0 auto;">
                        <img src={{-- "public/img/logoaiep.png" --}} alt="Imagen" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="row mt-4" style="background-color:; width:100%;  margin-left: 0%;" >
                <div class="col-md-10 offset-md-3" style="background-color:;margin: 0 auto;">
                    <form action="{{route('auth.ingresar')}}" class="signin-form" method="POST" style="margin-top: 5%; margin-bottom: 10%;">
                    @csrf

                    @if (Session::has('errorName'))
                        <div class="alert alert-danger alert-dismissible show fade text-center">
                            <div class="alert-body">
                                <strong>{{ Session::get('errorName') }}</strong>
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        </div>
                    @endif

                    @if (Session::has('errorClave'))
                        <div class="alert alert-danger alert-dismissible show fade text-center">
                            <div class="alert-body">
                                <strong>{{ Session::get('errorClave') }}</strong>
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        </div>
                    @endif

                    @if (Session::has('sessionFinalizada'))
                        <div class="alert alert-danger alert-dismissible show fade text-center">
                            <div class="alert-body">
                                <strong>{{ Session::get('sessionFinalizada') }}</strong>
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        </div>
                    @endif

                    @if (Session::has('usuarioRegistrado'))
                        <div class="alert alert-success alert-dismissible show fade text-center">
                            <div class="alert-body">
                                <strong>{{ Session::get('usuarioRegistrado') }}</strong>
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        </div>
                    @endif

                    @if (Session::has('errorCreate'))
                        <div class="alert alert-success alert-dismissible show fade text-center">
                            <div class="alert-body">
                                <strong>{{ Session::get('errorCreate') }}</strong>
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        </div>
                    @endif

                    <!-- Alerta Buena :D -->
                    @if (Session::has('exitoCreacion'))
                        <div class="alert alert-success alert-dismissible show fade text-center">
                            <div class="alert-body">
                                <strong>{{ Session::get('exitoCreacion') }}</strong>
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        </div>
                    @endif

                    <!-- Inicio del Formulario -->
                    <div class="form-group mb-3" style="margin-top:-5%; width:100%;">
                        <label class="label" for="nickname" style="font-size: auto;">Nombre de Usuario</label>
                        <input style="background-color:white; color:black; border: 1px solid #042344;" type="text" class="form-control" placeholder="Ingrese su Nombre de Usuario"
                            name="nickname" id="nickname" value="{{ old('nickname') }}" />
                        @if ($errors->has('nickname'))
                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <strong>{{ $errors->first('nickname') }}</strong>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-group mb-3" style="font-size: auto;">
                        <label class="label" for="clave" style="font-size: auto; width:100%;">Contraseña</label>
                        <input style="background-color:white; color:black; border: 1px solid #042344;" style="" type="password" class="form-control" placeholder="Ingrese su contraseña" required
                            id="clave" name="clave">
                        @if ($errors->has('clave'))
                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    <strong>{{ $errors->first('clave') }}</strong>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit"
                            class="form-control btn rounded submit px-3" style="background-color:#042344; color:white;margin-top:10%;">Ingresar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/js/popper.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/main.js') }}"></script>

</body>

</html>