@extends('layouts.login')
@section('title', 'Codigo de verificacao')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100" id="login-screen">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px">
            <h4 class="mb-3 text-center">Entrar no Chat</h4>
            <div class="mb-3">
                <input value="phone" name="form_type" hidden required />
                <label for="contact" class="form-label">Número de telefone</label>
                <input type="number" class="form-control" id="contact" name="phone" placeholder="ex: 258 84xxxxxxx"
                    required />
            </div>
            <button type="submit" class="btn btn-primary w-100" id="send-code-btn">
                Enviar código de verificação
            </button>
        </div>
    </div>
@endsection
