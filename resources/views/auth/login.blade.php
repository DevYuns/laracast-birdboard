@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="text-center text-lg mb-8">
            {{ __('Login') }}
        </div>

        <div class="flex justify-center">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email">
                        {{ __('E-Mail Address') }}
                    </label>

                    <div class="mb-5">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="border-b-2 border-gray-500  @error('email') is-invalid @enderror"
                            required
                            autocomplete="email"
                            autofocus
                        >

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="">
                        {{ __('Password') }}
                    </label>
                    <div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="border-b-2 border-gray-500 @error('password') is-invalid @enderror"
                            required
                            autocomplete="current-password"
                        >
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>


                <div class="flex flex-col">
                    <button type="submit" class="button mb-2">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

@endsection
