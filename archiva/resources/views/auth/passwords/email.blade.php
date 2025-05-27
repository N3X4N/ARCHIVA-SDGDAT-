@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-…"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/login.css') }}">
    <style>
        /* Oculta cualquier navbar definido en tu layout */
        .navbar,
        nav {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">

                            {{-- Panel Formulario --}}
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/archiva.png') }}" style="width:185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">¿Olvidaste tu contraseña?</h4>
                                    </div>

                                    @if (session('status'))
                                        <div class="alert alert-success">{{ session('status') }}</div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Correo electrónico</label>
                                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                                required autocomplete="email" autofocus
                                                class="form-control @error('email') is-invalid @enderror" />
                                            @error('email')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="text-center pt-1 mb-3">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2"
                                                type="submit">
                                                Enviar enlace de restablecimiento
                                            </button>
                                        </div>

                                        <div class="text-center">
                                            @if (Route::has('login'))
                                                <a class="btn btn-link text-muted" href="{{ route('login') }}">
                                                    Volver a iniciar sesión
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Panel Informativo --}}
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
