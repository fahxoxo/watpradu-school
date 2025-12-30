<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body { font-family: 'thsarabunnew'; font-size: 12px; }
        .title { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
        th { background: #f0f0f0; font-weight: bold; }
        .no-data { text-align: center; padding: 20px; }
    </style>
</head>
<body>
    <div class="title">
        <h2>รายงานข้อเสนอแนะ</h2>
        <div>วันที่พิมพ์: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</div>
        <div>จำนวนรายการ: {{ $suggestions->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%">ลำดับ</th>
                <th style="width:20%">ชื่อผู้แจ้ง</th>
                <th style="width:50%">ข้อความ</th>
                <th style="width:15%">วันที่</th>
                <th style="width:10%">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suggestions as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->submitter_name ?? ($s->user->name ?? '-') }}</td>
                <td style="white-space:pre-wrap;">{{ $s->message }}</td>
                <td>{{ $s->created_at ? $s->created_at->format('d/m/Y H:i') : '' }}</td>
                <td>
                    @if($s->status === 'pending')
                        รอดำเนินการ
                    @elseif($s->status === 'processing')
                        กำลังดำเนินการ
                    @elseif($s->status === 'resolved' || $s->status === 'completed')
                        แก้ไขแล้ว
                    @else
                        {{ $s->status }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-data">ไม่มีข้อมูล</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>