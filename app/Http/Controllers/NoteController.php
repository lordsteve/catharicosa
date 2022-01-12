<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Location;
use App\Models\Note;
use App\Models\Notelette;
use App\Models\NPC;
use App\Models\Quest;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function show()
    {
        if (auth()->check() === true ){
            $user = auth()->user()->id;
            $data = [
                'notes' => Note::all()->where('user_id', $user)->sortBy('created_at', SORT_REGULAR, 1),
                'quests' => Quest::all()->where('user_id', $user),
                'npcs' => NPC::all()->where('user_id', $user),
                'locations' => Location::all()->where('user_id', $user),
                'inventoryItems' => InventoryItem::all()->where('user_id', $user),
            ];
        }else{
            $data = ['coconut' => 'lime'];
        }

        return view('index', $data);
    }

    public function updateNote(Request $request, Note $note)
    {
        $note->update([
            'note_id' => $request->input('note_id'),
            'body' => nl2br($request->input('body'))
        ]);
    }

    public function addNotelette(Request $request, Note $note, Quest $quest, NPC $npc, Location $location, InventoryItem $item)
    {
        $notelette = $note->notelettes()->create([
            'user_id' => auth()->user()->id,
            'body' => $request->input('body')
        ]);
        if ($request->input('quest_id') !== null){
            $quest->find($request->input('quest_id'))->notelettes()->attach($notelette->id);
        }
        if ($request->input('npc_id') !== null){
            $npc->find($request->input('npc_id'))->notelettes()->attach($notelette->id);
        }
        if ($request->input('location_id') !== null){
            $location->find($request->input('location_id'))->notelettes()->attach($notelette->id);
        }
        if ($request->input('inventory_item_id') !== null){
            $item->find($request->input('inventory_item_id'))->notelettes()->attach($notelette->id);
        }

        return redirect('/')->with('success', 'Your new notelette has been saved!');
    }

    public function destroyNotelette(Notelette $notelette)
    {
        $notelette->delete();

        return back()->with('success', 'Notelette deleted!');
    }

    public function destroyNote(Note $note)
    {
        $note->delete();

        return back()->with('success', 'Note deleted!');
    }
}
