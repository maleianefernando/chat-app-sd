@extends('layouts.login')
@section('title', 'Seu telefone')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100" id="code-screen">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px">
            <h4 class="mb-3 text-center">Verificação</h4>
            <div class="mb-3">
                <label for="verification-code" class="form-label">Insira o código recebido</label>
                <input value="code" name="form_type" hidden />
                <input value="{{ $phone }}" name="phone" required hidden />
                <input type="number" class="form-control" id="verification_code" name="verification_code" required />
            </div>
            <button type="submit" class="btn btn-success w-100">Confirmar</button>
        </div>
    </div>
@endsection
