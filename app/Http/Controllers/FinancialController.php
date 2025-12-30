<?php

namespace App\Http\Controllers;

use App\Models\Financial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinancialController extends Controller
{
    // Public view สำหรับผู้ใช้ทั่วไป
    public function publicShow(Financial $financial)
    {
        return view('financials.public-show', compact('financial'));
    }

    public function index()
    {
        $items = Financial::orderBy('id', 'desc')->get();
        return view('financials.index', compact('items'));
    }

    public function create()
    {
        return view('financials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('financials', 'public');
        }

        Financial::create($data);

        return redirect()->route('financials.index')->with('success', 'บันทึกข้อมูลการเงินเรียบร้อย');
    }

    public function edit(Financial $financial)
    {
        return view('financials.edit', compact('financial'));
    }

    public function update(Request $request, Financial $financial)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($financial->image) {
                Storage::disk('public')->delete($financial->image);
            }
            $data['image'] = $request->file('image')->store('financials', 'public');
        }

        $financial->update($data);

        return redirect()->route('financials.index')->with('success', 'อัพเดตข้อมูลการเงินเรียบร้อย');
    }

    public function destroy(Financial $financial)
    {
        if ($financial->image) {
            Storage::disk('public')->delete($financial->image);
        }
        $financial->delete();
        return redirect()->route('financials.index')->with('success', 'ลบข้อมูลการเงินเรียบร้อย');
    }
}
