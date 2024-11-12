@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Sala</h1>
    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')



        <div class="form-group">
            <label for="name">Nombre de la Sala</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $room->name) }}" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea id="description" name="description" class="form-control" rows="4" maxlength="100">{{ old('description', $room->description) }}</textarea>
        </div>


        <div class="form-group mt-2">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
@endsection