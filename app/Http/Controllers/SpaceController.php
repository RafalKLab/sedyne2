<?php

declare(strict_types=1);


namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Space;
use App\Services\SpaceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpaceController extends Controller
{
    public function __construct(protected SpaceService $spaceService) {}

    public function index()
    {
        $spaces = $this->spaceService->findAll();

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
        $space = $this->spaceService->find($id);

        if ($space->layout) {
            dd('Unfortunately the space has already been set up and has reservations :(');
        }

        return view('space-creator', compact('id'));
    }

    public function saveLayout(Request $request, int $id)
    {
        $layout = $request->input('layoutJson');

        $layoutArr = json_decode($layout,true);

        foreach ($layoutArr['layout'] as $index => $item) {
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

    public function previewSpace(int $id): View
    {
        $space = $this->spaceService->find($id);

        if (!$space->layout) {
            dd('Unfortunately the space has not been set up, there is nothing to preview :(');
        }

        return view('space-preview', compact('space'));
    }

    public function setPrimary(int $id) {
        $space = $this->spaceService->find($id);

        if (!$space) {
            dd('You are trying to set primary space that doesn\'t exist :(');
        }

        // todo: Refactor with service and repository
        $user = auth()->user();
        $user->settings->primary_space_id = $space->id;
        $user->settings->save();

        return redirect()->route('spaces');
    }
}
