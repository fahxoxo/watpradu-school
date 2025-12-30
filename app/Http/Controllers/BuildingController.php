<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::orderBy('id', 'desc')->get();
        return view('buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('buildings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('buildings', 'public');
            $data['image'] = $path;
        }

        Building::create($data);

        return redirect()->route('buildings.index')->with('success', 'บันทึกข้อมูลอาคารเรียบร้อย');
    }

    public function edit(Building $building)
    {
        return view('buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // delete old image
            if ($building->image) {
                Storage::disk('public')->delete($building->image);
            }
            $path = $request->file('image')->store('buildings', 'public');
            $data['image'] = $path;
        }

        $building->update($data);

        return redirect()->route('buildings.index')->with('success', 'อัพเดตข้อมูลอาคารเรียบร้อย');
    }

    public function destroy(Building $building)
    {
        if ($building->image) {
            Storage::disk('public')->delete($building->image);
        }
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'ลบข้อมูลอาคารเรียบร้อย');
    }

    public function publicIndex()
    {
        $buildings = Building::orderBy('id', 'desc')->get();
        $schoolInfo = \App\Models\SchoolInfo::first();
        return view('public.buildings', compact('buildings', 'schoolInfo'));
    }

    public function publicShow(Building $building)
    {
        $schoolInfo = \App\Models\SchoolInfo::first();
        $relatedBuildings = Building::where('id', '!=', $building->id)->limit(4)->get();
        return view('public.buildings-detail', compact('building', 'schoolInfo', 'relatedBuildings'));
    }
}
