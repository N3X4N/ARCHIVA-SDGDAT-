@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/login.css') }}">
@endpush

@section('content')
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">

                            {{-- Panel de Formulario --}}
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/archiva.png') }}" style="width:185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">¿Olvidaste tu contraseña?</h4>
                                    </div>

                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Correo electrónico</label>
                                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                                required autocomplete="email" autofocus
                                                class="form-control @error('email') is-invalid @enderror" />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                type="submit">
                                                Enviar enlace de restablecimiento
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Panel Informativo --}}
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Alcaldía de Tabio</h4>
                                    <p class="small mb-0">
                                        El sistema de gestión documental para la Alcaldía de Tábio es una solución
                                        tecnológica diseñada para optimizar la administración de documentos y trámites.
                                        Permite controlar estados y gestionar documentos oficiales de forma rápida,
                                        segura y sostenible.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-…" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/login.css') }}">
@endpush

@section('content')
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('assets/archiva.png') }}" style="width:185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Confirmar contraseña</h4>
                                    </div>

                                    <p>Por favor, confirma tu contraseña antes de continuar.</p>

                                    <form method="POST" action="{{ route('password.confirm') }}">
                                        @csrf
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Contraseña</label>
                                            <input id="password" type="password" name="password" required
                                                class="form-control @error('password') is-invalid @enderror">
                                            @error('password')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                type="submit">
                                                Confirmar contraseña
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Alcaldía de Tabio</h4>
                                    <p class="small mb-0">El sistema de gestión documental para la Alcaldía de Tábio…</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
