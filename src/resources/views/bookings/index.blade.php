@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-around">
                        <div style="margin-right: 8px;">
                            <h2>Reservas</h2>

                        </div>

                        @role('Administrador')
                        <div>
                            <form method="GET" action="{{ route('bookings.index') }}">
                                @csrf
                                <select name="room_id" class="form-control" required onchange="this.form.submit()">
                                    <option value="">Seleccione una sala</option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        @else
                        @endrole


                    </div>




                    <div>
                        <a href="{{ route('bookings.register') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sala</th>
                                <th>Fecha y hora de inicio</th>
                                <th>Fecha y hora final</th>
                                <th>Usuario</th>
                                <th>Estado</th>
                                <th></th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $key => $booking)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $booking->room->name }}</td>
                                <td>{{ $booking->start_time }}</td>
                                <td>{{ $booking->end_time }}</td>
                                <td>{{ $booking->user->name }}</td>

                                <td>
                                    @role('Administrador')
                                    <form action="{{ route('bookings.update_state') }}" method="POST" onsubmit="return confirm('¿Estás seguro de actualizar el estado de la reserva?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name='id' value="{{$booking->id}}">
                                        <select name="state" class="form-control" onchange="this.form.submit()">
                                            <option value="PENDIENTE" {{ $booking->state == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                                            <option value="ACEPTADA" {{ $booking->state == 'ACEPTADA' ? 'selected' : '' }}>ACEPTADA</option>
                                            <option value="RECHAZADA" {{ $booking->state == 'RECHAZADA' ? 'selected' : '' }}>RECHAZADA</option>
                                        </select>
                                        @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </form>
                                    @else

                                    {{ $booking->state }}

                                    @endrole


                                </td>
                                <!-- <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a> -->

                                </td>
                                <td>
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta reserva?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection