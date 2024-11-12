@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar sala') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rooms.store') }}">

                        @csrf

                        <div class="form-group">
                            <label for="name">Nombre de la Sala</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required maxlength="100">

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción de la Sala</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" maxlength="100">{{ old('description') }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Guardar') }}
                            </button>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection