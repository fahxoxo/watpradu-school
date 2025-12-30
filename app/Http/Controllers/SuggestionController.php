<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use App\Models\Suggestion;
use Mpdf\Mpdf;

use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function create()
    {
        return view('suggestions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'submitter_name' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);

        $data['status'] = 'pending';

        Suggestion::create($data);

        return redirect()->route('suggestions.create')->with('success', 'ส่งข้อเสนอแนะเรียบร้อย ขอบคุณสำหรับการให้ข้อมูล');
    }

    public function index()
    {
        $suggestions = Suggestion::latest()->paginate(20);
        return view('suggestions.index', compact('suggestions'));
    }

    public function exportPdf()
    {
        $startDate = Carbon::now()->subDays(30);
        $suggestions = Suggestion::where('created_at', '>=', $startDate)->get();

        $html = view('exports.suggestions', compact('suggestions'))->render();
        
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'tempDir' => sys_get_temp_dir(),
            'fontDir' => base_path('storage/fonts'),
            'fontdata' => [
                'thsarabunnew' => [
                    'R' => 'THSarabunNew.ttf',
                    'B' => 'THSarabunNew Bold.ttf',
                    'I' => 'THSarabunNew Italic.ttf',
                    'BI' => 'THSarabunNew BoldItalic.ttf',
                ]
            ],
        ]);
        
        $mpdf->SetDefaultFont('thsarabunnew', '');
        $mpdf->WriteHTML($html);
        
        return $mpdf->Output('suggestions_report.pdf', 'D');
    }

    public function edit(Suggestion $suggestion)
    {
        return view('suggestions.edit', compact('suggestion'));
    }

    public function update(Request $request, Suggestion $suggestion)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed',
        ]);

        $suggestion->update($data);

        return redirect()->route('suggestions.index')->with('success', 'อัพเดตสถานะข้อเสนอแนะเรียบร้อย');
    }
}

