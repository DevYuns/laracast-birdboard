
@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="card flex flex-col items-center text-default">
            <div class="mb-6 text-lg underline">
                {{ __('Register') }}
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <label for="name">
                        {{ __('Name') }}
                    </label>

                    <div>
                        <input id="name"
                               type="text"
                               class="border border-b-2 @error('name') is-invalid @enderror"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autocomplete="name"
                               autofocus
                        >

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <label for="email">
                        {{ __('E-Mail Address') }}
                    </label>

                    <div class="border border-b-2">
                        <input id="email"
                               type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required
                               autocomplete="email"
                        >

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password">
                        {{ __('Password') }}
                    </label>

                    <div class="border border-b-2">
                        <input id="password"
                               type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password"
                               required
                               autocomplete="new-password"
                        >

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div>
                        <label for="password-confirm">
                            {{ __('Confirm Password') }}
                        </label>

                        <div class="border border-b-2">
                            <input id="password-confirm"
                                   type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                            >
                        </div>
                    </div>
                    <div class="text-right mt-6">
                        <button type="submit" class="button">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
