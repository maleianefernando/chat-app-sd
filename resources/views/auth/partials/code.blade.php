@extends('layouts.login')
@section('title', 'Seu telefone')

@section('content')
    <form method="POST" action="/login/code">
        @csrf
        <div class="container d-flex justify-content-center align-items-center min-vh-100" id="code-screen">
            <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px">
                <h4 class="mb-3 text-center">Verificação</h4>
                @if(Session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="mb-3">
                    <div class="form-group">
                        <label for="verification-code" class="form-label">Insira o código recebido</label>
                        <input value="code" name="form_type" hidden />
                        <input value="{{ $phone }}" name="phone" required hidden />
                        <input type="number" class="form-control" id="verification_code" name="verification_code"
                            required />

                        <label for="verification-code" class="form-label">Nos diga o seu nome de utilizador</label>
                        <input type="text" class="form-control" id="username" name="username" />
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Confirmar</button>
            </div>
        </div>
    </form>
@endsection
