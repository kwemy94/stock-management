@extends('layouts.app')

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

    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Profile Information') }}</h3>
                        </div>
                        {{-- @include('profile.partials.update-profile-information-form') --}}
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('auth.name') }} </label>
                                    <input type="text" class="form-control" id="name"
                                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                    <span class="mt-2" :messages="$errors - > get('name')"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    <span class="mt-2" :messages="$errors - > get('email')"></span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Update password') }}</h3>
                        </div>
                        
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="current_password">{{ __('Current Password') }} </label>
                                    <input type="password" name="current_password" class="form-control" id="current_password"
                                        value="" required>
                                    <span class="mt-2" :messages="$errors ->updatePassword->get('current_password')"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('New Password') }} </label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        required>
                                    <span class="mt-2" :messages="$errors ->updatePassword->get('password')"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password') }} </label>
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                                        value="" required>
                                    <span class="mt-2" :messages="$errors ->updatePassword->get('password_confirmation')"></span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
                
            </div>
        </div>
    </section>
@endsection
