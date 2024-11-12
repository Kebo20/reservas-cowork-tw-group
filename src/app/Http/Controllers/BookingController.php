<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{


    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('Administrador')) {
            $roomId = $request->get('room_id');
            if (isset($roomId)) {
                $bookings = Booking::where('status', 1)->where('room_id', $roomId)->get();
            } else {
                $bookings = Booking::where('status', 1)->get();
            }
        } else {
            $bookings = Booking::where('status', 1)->where('user_id', Auth::user()->id)->get();
        }
        $rooms = Room::where('status', 1)->get();

        return view('bookings.index', compact('bookings', 'rooms'));
    }

    public function register()
    {
        $rooms = Room::where('status', 1)->get();
        return view('bookings.register', compact('rooms'));
    }

    public function show($roomId)
    {
        $booking = Booking::findOrFail($roomId);
        $rooms = Room::where('status', 1)->get();
        return view('bookings.show', compact('booking', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $start_time = Carbon::parse($validated['reservation_date'] . ' ' . $validated['start_time']);
        $end_time = $start_time->copy()->addHour();  // Sumar una hora

        if ($start_time->isPast()) {
            return back()->withErrors(['reservation_date' => 'La fecha de inicio debe ser una fecha y hora futura.']);
        }

        $where_start_time = $start_time->copy()->addMinute();
        $where_end_time = $end_time->copy()->addMinute();


        $o_validate = Booking::where('status', '1')->where('room_id', $request->room_id)
            ->where(function ($query) use ($request, $where_start_time, $where_end_time) {
                $query->whereBetween('start_time', [$where_start_time, $where_end_time])
                    ->orWhereBetween('end_time', [$where_start_time, $where_end_time]);
            })
            ->count();

        if ($o_validate > 0) {

            return back()->withErrors(['reservation_date' => 'La sala se encuentra reservada para esa fecha y hora.'])->withInput();
        }

        $o_booking = new Booking();

        $o_booking->user_id = auth()->id();
        $o_booking->room_id = $request->room_id;
        $o_booking->start_time = $start_time;
        $o_booking->end_time = $end_time;
        $o_booking->save();

        return redirect()->route('bookings.index')->with('success', 'Reserva realizada exitosamente');
    }


    public function destroy(Request $request, $id)
    {


        $o_booking = Booking::findOrFail($id);

        $o_booking->status = '0';
        $o_booking->save();

        return redirect()->route('bookings.index')->with('success', 'Reserva eliminada con éxito!');
    }

    public function update_state(Request $request)
    {

        $validated = $request->validate([
            'state' => 'required|string|in:PENDIENTE,ACEPTADA,RECHAZADA',
            'id' => 'required'

        ]);

        $o_booking = Booking::findOrFail($validated['id']);

        $o_booking->state = $validated['state'];
        $o_booking->save();

        return redirect()->route('bookings.index')->with('success', 'Reserva eliminada con éxito!');
    }
}
