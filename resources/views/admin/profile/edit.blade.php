@extends('admin.layouts.app')

@section('dashboard-content')
    {{-- <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout> --}}

    <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">

                {{-- PROFILE --}}
                <div class="col-md-6">
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ __('Profil mis à jour avec succès') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user mr-1"></i>
                                {{ __('Informations du profil') }}
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('Nom') }}</label>
                                    <input type="text" name="name" class="form-control form-control-sm"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control form-control-sm" value="{{ $user->email }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-save mr-1"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6">
                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success alert-dismissible shadow-sm">
                            <i class="fas fa-lock mr-1"></i>
                            {{ __('Mot de passe mis à jour') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-key mr-1"></i>
                                {{ __('Sécurité') }}
                            </h3>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('Mot de passe actuel') }}</label>
                                    <input type="password" name="current_password" class="form-control form-control-sm"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Nouveau mot de passe') }}</label>
                                    <input type="password" name="password" class="form-control form-control-sm" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Confirmation') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-sm"
                                        required>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-shield-alt mr-1"></i> Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
