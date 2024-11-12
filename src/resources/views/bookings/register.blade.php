@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar reserva') }}</div>

                <div class="card-body">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="room_id" class="form-label">Sala</label>
                            <select name="room_id" id="room_id" class="form-control" required>
                                <option value="">Seleccione una sala</option>
                                @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                            @error('room_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="reservation_date" class="form-label">Fecha de la Reserva</label>
                            <input type="date" name="reservation_date" id="reservation_date" class="form-control" required>
                            @error('reservation_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_time" class="form-label">Hora de Inicio</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">

                            <button type="submit" class="btn btn-primary">Reservar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection