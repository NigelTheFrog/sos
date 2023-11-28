@extends('layouts.app')

@section('content')

<div class="container-xl">
    <div class="row justify-content-md-center">
        <div class="col-3">
            <div class="d-block text-center pb-3">
                <h3><strong>Stock Opname System</strong></h3>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="col">
                            <label for="username" class="col-md-4 col-form-label text-start">{{ __('Username') }}</label>
                        </div>
                        <div class="col">                            
                            <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                        
                        </div>                        

                        <div class="col-md-0">
                            <label for="password" class="col-md-4 col-form-label text-start">{{ __('Password') }}</label>
                        </div>

                        <div class="col mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                            
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
            <div class="text-muted small text-center pt-2">
                Developed by Kristiawan Wicaksono
            </div>
        </div>
        <div class="col-3">
            <img height="400" src="{{asset('assets/images/Checkingboxes.png')}}">
        </div>
        
    </div>
</div>
@endsection
