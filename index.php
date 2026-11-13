<?php

    require_once __DIR__ . '/vendor/autoload.php';

    use Mpdf\Mpdf;

    $imagePath = __DIR__ . '/bg.jpg';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new Mpdf([
        'mode'        => 'utf-8',
        'format'      => [168, 297],
        'orientation' => 'L',
        'margin_left'   => 0,
        'margin_right'  => 0,
        'margin_top'    => 0,
        'margin_bottom' => 0,
        'tempDir'       => __DIR__ . '/tmp',
        'fontDir'       => array_merge($fontDirs, [
            __DIR__ . '/fonts',
        ]),
        'fontdata'      => $fontData + [
            'centurygothic' => [
                'R' => 'centurygothic_bold.ttf',
            ],
        ],
        'default_font'  => 'centurygothic',
    ]);

    $stylesheet = file_get_contents('style.css');
    $html = file_get_contents('index.html');

    $mpdf->SetTitle('Сетификат');

    $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);

    $mpdf->Output('certificate.pdf', 'I');

?>