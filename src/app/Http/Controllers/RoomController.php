<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $fillable = ['name', 'description', 'status'];

    public function index()
    {
        $rooms = Room::where('status', 1)->get();
        return view('rooms.index', compact('rooms'));
    }

    public function register()
    {
        return view('rooms.register');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'max:100',
        ]);


        $o_room = new Room();

        $o_room->name = strip_tags($validated['name']);
        $o_room->description = strip_tags($validated['description']);
        $o_room->save();

        return redirect()->route('rooms.index')->with('success', 'Sala registrada con éxito!');
    }

    public function destroy(Request $request, $id)
    {


        $o_room = Room::findOrFail($id);

        $o_room->status = '0';
        $o_room->save();

        return redirect()->route('rooms.index')->with('success', 'Sala eliminada con éxito!');
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'max:100',
        ]);


        $o_room = Room::findOrFail($id);

        $o_room->name = strip_tags($validated['name']);
        $o_room->description = strip_tags($validated['description']);
        $o_room->save();

        return redirect()->route('rooms.index')->with('success', 'Sala eliminada con éxito!');
    }
}
