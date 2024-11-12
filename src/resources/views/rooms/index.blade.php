@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex ">
                    <div class="col-sm-11">

                        <h2>Salas</h2>
                    </div>
                    <div class="col-sm-1">
                        <a href="{{ route('rooms.register') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
                    </div>


                </div>

                <div class="card-body">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th></th>
                                <th></th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $key => $room)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->description }}</td>
                                <td>

                                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>

                                <td>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de desactivar esta sala?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>


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