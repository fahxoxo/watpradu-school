<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use Mpdf\Mpdf;

// ทดสอบ Thai font ด้วย fontdata อย่างชัดเจน
$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <style>
        body { font-family: thsarabunnew; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; border: 1px solid #000; }
        th, td { border: 1px solid #000; padding: 8px; }
        .title { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="title">
        <h1>ทดสอบ Thai Font - mPDF</h1>
        <p>สร้างเมื่อ: ' . date('d/m/Y H:i') . '</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width:10%">ลำดับ</th>
                <th style="width:30%">ชื่อ</th>
                <th style="width:60%">ข้อความ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>สมชาย สมหวัง</td>
                <td>ระบบนี้ต้องปรับปรุงความเร็ว</td>
            </tr>
            <tr>
                <td>2</td>
                <td>สาลี่ สดใจ</td>
                <td>ต้องการเพิ่มฟีเจอร์ใหม่</td>
            </tr>
            <tr>
                <td>3</td>
                <td>วิษณุ วงศ์วิสาล</td>
                <td>ขอเพิ่มผู้ใช้งาน 50 คน</td>
            </tr>
        </tbody>
    </table>
</body>
</html>';

try {
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'fontDir' => base_path('storage/fonts'),
        'fontdata' => [
            'thsarabunnew' => [
                'R' => 'THSarabunNew.ttf',
                'B' => 'THSarabunNew Bold.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'BI' => 'THSarabunNew BoldItalic.ttf',
            ]
        ],
        'tempDir' => sys_get_temp_dir(),
    ]);
    
    $mpdf->SetDefaultFont('thsarabunnew', '');
    $mpdf->WriteHTML($html);
    
    $outputPath = storage_path('test_thai.pdf');
    $mpdf->Output($outputPath, 'F');
    
    echo "Test PDF created: $outputPath\n";
    echo "File size: " . filesize($outputPath) . " bytes\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
