@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header','Registrar Cliente'))

@section('auth_body')
    <form action="{{ $register_url }}" method="post" autocomplete="off" class="needs-validation" novalidate>
        @csrf

        {{-- Name field --}}
        <div class="input-group mb-3">
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="ingrese su nombre" pattern=".*\S+.*" autofocus required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user classes_auth_icon"></span>
                </div>
            </div>
            <div class="invalid-feedback">Introduzca nombre</div>
        </div>
        {{--apellidos--}}
        <div class="input-group mb-3">
            <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror"
                   value="{{ old('apellidos') }}" placeholder="ingrese su apellido paterno y materno" pattern=".*\S+.*" autofocus required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-address-card classes_auth_icon"></span>
                </div>
            </div>
            <div class="invalid-feedback">Introduzca su apellido paterno y materno</div>
        </div>
        {{--edad--}}
        <div class="input-group mb-3">
            <input type="number" name="edad" class="form-control @error('edad') is-invalid @enderror"
                   value="{{ old('edad') }}" placeholder="ingrese su edad" pattern=".*\S+.*" autofocus required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="far fa-address-card classes_auth_icon "></span>
                </div>
            </div>
            <div class="invalid-feedback">Introduzca su edad</div>

        </div>
         {{--telefono--}}
         <div class="input-group mb-3">
            <input type="number" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                   value="{{ old('telefono') }}" placeholder="ingrese su nro de telefono" pattern=".*\S+.*" autofocus required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-mobile classes_auth_icon"></span>
                </div>
            </div>
            <div class="invalid-feedback">Introduzca su nro de telefono</div>

        </div>

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="cuenta de usuario" pattern=".*\S+.*" autofocus required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope classes_auth_icon"></span>
                </div>
            </div>
            <div class="invalid-feedback">Introduzca cuenta de usuario</div>

        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder=" ingrese su contraseña" pattern=".*\S+.*" autofocus required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock classes_auth_icon"></span>
                </div>
            </div>
            <div class="invalid-feedback">password corregir</div>

        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   placeholder="verificar su contraseña" pattern=".*\S+.*" autofocus required >
           
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock classes_auth_icon"></span>
                </div>
            </div>
            <div class="invalid-feedback">password diferente</div>

        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block classes_auth_btn btn-flat btn-primary">
            <span class="fas fa-user-plus"></span>
            Registrame
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            Login 
        </a>
    </p>
@stop
