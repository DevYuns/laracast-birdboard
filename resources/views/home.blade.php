@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="flex flex-col items-center">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class=" mb-4">You are logged in!</p>
                <div class="text-xl">
                    Go on to
                    <a href="/projects" class="underline">the Project page</a>
                </div>
            </div>
        </div>
    </div>
@endsection
