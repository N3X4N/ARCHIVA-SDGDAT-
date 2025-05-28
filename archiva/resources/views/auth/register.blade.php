<!doctype html>
<html lang="es">

<head>
    <title>Registrar</title>
    <!-- Meta etiquetas requeridas -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('assets/login.css') }}">
</head>

<body>

    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ asset('assets/archiva.png') }}" style="width: 185px;"
                                            alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Sistema de gestión documental</h4>
                                    </div>

                                    <form action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <p>Por favor, regístrate para crear una cuenta</p>
                                        {{-- Nombres --}}
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="nombres">Nombres</label>
                                            <input type="text" name="nombres" id="nombres"
                                                class="form-control @error('nombres') is-invalid @enderror"
                                                value="{{ old('nombres') }}" required autofocus />
                                            @error('nombres')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        {{-- Apellidos --}}
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="apellidos">Apellidos</label>
                                            <input type="text" name="apellidos" id="apellidos"
                                                class="form-control @error('apellidos') is-invalid @enderror"
                                                value="{{ old('apellidos') }}" required />
                                            @error('apellidos')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Correo electrónico</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Correo electrónico" value="{{ old('email') }}" required
                                                autocomplete="email" />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Contraseña</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror" required
                                                autocomplete="new-password" />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password_confirmation">Confirmar
                                                Contraseña</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" class="form-control" required
                                                autocomplete="new-password" />
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                type="submit">Registrarse</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">¿Ya tienes una cuenta?</p>
                                            <a href="{{ route('login') }}" class="btn btn-outline-danger">Iniciar
                                                sesión</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Alcaldía de Tabio</h4>
                                    p class="small mb-0">El sistema de gestión documental para la Alcaldía de Tábio es
                                    una solución tecnológica diseñada para optimizar la administración de documentos
                                    y trámites administrativos. Este sistema permite almacenar fisicamente control ,
                                    estados y
                                    gestionar eficientemente documentos oficiales, facilitando su
                                    acceso y consulta de manera rápida y segura. Además, contribuye a la mejora en
                                    la transparencia, la trazabilidad de los procesos y la reducción del uso de
                                    papel, promoviendo la eficiencia y la sostenibilidad dentro de la institución.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Bibliotecas JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
