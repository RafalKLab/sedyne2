<?php

declare(strict_types=1);


namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Space;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function index()
    {
        $spaces = Space::all();

        return view('space.index', compact('spaces'));
    }

    public function storeSpace(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string',
        ]);

        Space::create($validated);

        return redirect()->route('spaces');
    }

    public function setupLayout(int $id)
    {
        return view('space-creator', compact('id'));
    }

    public function saveLayout(Request $request, int $id)
    {
        $layout = $request->input('layoutJson');

        $layoutArr = json_decode($layout,true);

        foreach ($layoutArr as $index => $item) {
            if ($item['type'] === 'chair') {
                Seat::create([
                    'space_id' => $id,
                    'index' => $index,
                ]);
            }
        }

        $space = Space::find($id);
        $space->layout = $layout;
        $space->save();

        return redirect()->route('spaces');
    }

    public function previewSpace(int $id)
    {
        $space = Space::with('seats')->find($id);

        return view('space-preview', compact('space'));
    }
}
