<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Inicio de sesión" />
        <meta name="author" content="GMG software" />
        <title>Cotillón Pide un deseo</title>
        <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div ><h3 class="text-center font-weight-light my-4">Cotillón Pide un deseo</h3></div>

                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar sesión</h3></div>
                                    <div class="card-body">
                                        @if ($errors->any())
                                        @foreach ($errors->all() as $item)
                                            <div class="alert alert-danger alert-dismissible fase show" role="alert">
                                                {{ $item }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endforeach
                                            
                                        @endif
                                        <form action="/login" method="POST">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" />
                                                <label for="inputEmail">Correo electrónico</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                                <label for="inputPassword">Contraseña</label>
                                            </div>
                                            <!--<div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Recordar Contraseña</label>
                                            </div>-->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <!--<a class="small" href="password.html">Olvidaste tu Contraseña?</a>-->
                                                <button type="submit" class="btn btn-primary"><a>Entrar</a></button>
                                                
                                            </div>
                                        </form>
                                    </div>
                                    <!--<div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.html">No tienes cuenta? Registrate!</a></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; GMG Software 2024</div>
                            <div>
                                <a href="#">Visite nuestra web</a>
                                &middot;
                                <a href="#">Instagram &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <!--<script src="js/scripts.js"></script>-->
    </body>
</html>
