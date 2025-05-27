<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\TransferenciaDocumental::class => \App\Policies\TransferenciaDocumentalPolicy::class,
        \App\Models\Perfil::class => \App\Policies\PerfilPolicy::class,
    ];
}
