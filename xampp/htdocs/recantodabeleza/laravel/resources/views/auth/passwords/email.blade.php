@extends('templates.adm')

@section('title') Resgatar Senha @endsection('title')
@section('icon') <img src='{{url("/img/icons/newEmployee-light.png")}}' width='35px'> @endsection('icon')
<!-- adicionar uma imagem pra o resgatar senha -->

@section('content')
    
<section class='contact-section'>
    <div class='container'>
        
        <div class='col-lg-10 offset-md-1'>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form class='contact-form'  method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class='col-md-12'>
                    <div class='row'><p><br></p></div>
                    <div class='row justify-content-end'>
                        <button type="submit"  class='site-btn'>
                            {{ __('Enviar senha redefinir ligação') }}
                        </button>
                    </div>
                    <div class='row'><p><br></p></div>
                </div>
            </form>
        </div>
    </div>  
</section>


@endsection