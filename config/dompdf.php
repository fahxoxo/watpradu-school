<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | These are the settings for the DomPDF package.
    |
    */

    'show_warnings' => false, // Useful to leave enabled for debugging
    'show_errors' => false,
    'show_logs' => false,
    'use_cdnjs' => false,

    /*
    |--------------------------------------------------------------------------
    | Font Directory
    |--------------------------------------------------------------------------
    |
    | The font directory where custom fonts are located. You can place Thai
    | font files here and register them below.
    |
    */

    'font_dir' => base_path('storage/fonts/'),
    'font_cache' => storage_path('fonts/'),

    /*
    |--------------------------------------------------------------------------
    | Default Font
    |--------------------------------------------------------------------------
    |
    | Set to a font that supports Thai characters. Examples:
    | - 'DejaVu Sans' (basic, limited Thai support via Unicode)
    | - 'Garuda' (if added)
    | - 'Norasi' (if added)
    | - 'THSarabunNew' (Thai font with excellent support)
    |
    */

    'default_font' => 'THSarabunNew',

    'dpi' => 96,
    'defaultMediaType' => 'screen',
    'defaultPaperSize' => 'a4',

    'options' => [
        'commands' => [
            'lsof' => '/usr/bin/lsof',       // `which lsof`
            'ps' => '/bin/ps',              // `which ps`
            'grep' => '/bin/grep',          // `which grep`
            'mswinapi' => false,            // Use the WINAPI WMI methods:
            'proc_open' => true,            // Use procedures instead of shell-exec
            'allow_url_fopen' => true,
            'allow_url_streamwrappers' => true,
        ],
        'pdf_backend' => 'PDFLib',          // 'PDFLib', 'busybox', 'xhtml2pdf'
        'tempDir' => sys_get_temp_dir(),
        'fontDir' => base_path('storage/fonts/'),
        'fontCache' => storage_path('fonts/'),
        'chroot' => realpath(base_path()),
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],
        'log_output_file' => storage_path('logs/dompdf.log'),
        'enablePhp' => false,
        'enableJavascript' => true,
        'debugPng' => false,
        'debugKeepTemp' => false,
        'html5ParserEnabled' => true,
        'enableRemoteFile' => false,
        'isRemoteEnabled' => false,
        'isFontSubsettingETHSarabunNew' => false,
        'defaultFont' => 'Garuda',
        'dpi' => 96,
        'fontHeightRatio' => 1.1,
        'pdfa' => false,
        'pdfVersion' => '1.7',
    ],

];
