@extends('templates.adm2')

@section('title') Login @endsection('title')
@section('icon') <!-- <img src='{{url("/img/icons/newEmployee-light.png")}}' width='35px'> --> @endsection('icon')

@section('content')

<script src='{{url("assets/js/scheduling.js")}}'></script>
<script src='{{url("assets/js/validacao.js")}}'></script>

<section class='contact-section'>
    <div class='container'>
        
        <div class='col-lg-10 offset-md-1'>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class='contact-form' method="POST" name="cadastro" id="cadastro" action='{{ route("adm.login.do") }}'> 
                @csrf
                <input type='hidden' id='is-valid' value='valid'>
                
                <div class="form-grou row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail ') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                     
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class='custom-control-input' type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class='custom-control-label' for="remember">
                                {{ __('Lembrar senha') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class='col-md-12'>
                    <div class='row'><p><br></p></div>
                    <div class='row justify-content-end'>
                        @if (Route::has('password.request'))
                            <a class='site-btn sb-dark' href="{{ route('password.request') }}"> 
                                {{ __('Esqueceu sua senha?') }}
                            </a>
                        @endif

                        <button type="submit" class='site-btn'>
                            {{ __('Entrar') }}
                        </button>
                    </div>
                    <div class='row'><p><br></p></div>
                </div>
            </form>

        </div>	
    </div>
</section>
@endsection
