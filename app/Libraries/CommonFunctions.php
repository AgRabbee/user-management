<?php

namespace App\Libraries;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CommonFunctions
{
    public static function convert2Bangla($eng_number): array|string
    {
        $ban = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $eng = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        return str_replace($eng, $ban, $eng_number);
    }

    public static function convert2English($ban_number): array|string
    {
        $ban = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '।'];
        $eng = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, '.'];
        return str_replace($ban, $eng, $ban_number);
    }

    public static function curlGetRequest($url, $headers): array
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $result = curl_exec($ch);

            if (!curl_errno($ch)) {
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            } else {
                $http_code = 0;
            }
            curl_close($ch);
            return ['http_code' => intval($http_code), 'data' => $result];

        } catch (\Exception $e) {
            Log::error($e);
            return ['http_code' => 0, 'data' => ''];
        }
    }

    public static function validateBangladeshMobileNumber($number)
    {
        // Remove any non-digit characters from the input
        $number = preg_replace('/[^0-9]/', '', $number);

        // Define the regex pattern for Bangladesh mobile numbers
        $pattern = '/^(?:\+?88|0)?(?:\d{11}|\d{13})$/';

        // Perform the regex match
        return preg_match($pattern, $number) === 1;
    }

    public static function replacePlaceholders($string, $data)
    {
        $pattern = '/{{(.*?)}}/';
        preg_match_all($pattern, $string, $matches);

        foreach ($matches[1] as $placeholder) {
            if (isset($data[$placeholder]) && !is_null($data[$placeholder])) {
                $string = str_replace("{{{$placeholder}}}", $data[$placeholder], $string);
            } else {
                $string = str_replace("{{{$placeholder}}}", '', $string);
            }
        }
        return $string;
    }

    public static function total_sms()
    {
        $init_id = config('constants.INSTITUTE_ID');

        $url = "https://sms.smartqb.info/GetBalance.php?link_id=$init_id&user_type=C";
        $headers = [];

        $apiResponse = CommonFunctions::curlGetRequest($url, $headers);
        if ($apiResponse['http_code'] == 200) {
            $responseArr = json_decode($apiResponse['data'], true);
            return $responseArr['status'] == 'success' ? $responseArr['balance'] : 0;
        }
        return 0;
    }

    public static function pdfGeneration($title, $subject, $stylesheet = '', $html, $pdfFilePath, $saveOrView = 'I', $generated_at)
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults(); // extendable default Configs
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults(); // extendable default Fonts
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'tempDir'           => storage_path(),
            'fontDir'           => array_merge($fontDirs, [
                public_path('fonts'),
            ]),
            'fontdata'          => $fontData + [
                    'PTSansNarrow' => [
                        'R' => 'PTSansNarrow-Regular.ttf', 'I' => 'PTSansNarrow-Regular.ttf', 'useOTL' => 0xFF, 'useKashida' => 75,
                    ],
                ],
            'default_font'      => 'PTSansNarrow',
            //            'setAutoTopMargin' => 'pad',
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'default_font_size' => 11,
            //            'margin_top' => 15,            // 15 margin_left
            //            'margin_left' => 15,        // 15 margin_left
            //            'margin_right' => 15,       // 15 margin right
            //            'margin_header' => 9,       // 9 margin header
            //            'margin_footer' => 9,       // 9 margin footer
        ]);


        $mpdf->SetProtection(array('print'));
        $mpdf->SetDefaultBodyCSS('color', '#000');
        $mpdf->SetTitle($title);
        $mpdf->SetSubject($subject);
        $mpdf->SetAuthor("Rabbee");
        //$mpdf->autoScriptToLang = true;
        $mpdf->baseScript = 1;
        $mpdf->autoVietnamese = true;
        $mpdf->SetDisplayMode('fullwidth');
        $mpdf->SetHTMLHeader();
        $footer = '';
        $mpdf->SetHTMLFooter($footer);
        $mpdf->defaultfooterline = 0;
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->showWatermarkImage = true;
        if ($stylesheet) {
            $mpdf->WriteHTML($stylesheet, 1);
        }
        $mpdf->WriteHTML($html, 2);
        $mpdf->Output($pdfFilePath, $saveOrView); // Saving pdf *** F for Save only, I for view only.
        exit();
    }

    public static function calculateAge($dob): int
    {
        $dob = Carbon::parse($dob);
        $today = Carbon::now();

        return $today->diffInYears($dob);
    }

    public static function defineMajlis($dob, $gender): string
    {
        $age = self::calculateAge($dob);
        $majlis = '';

        if ($gender == 'male') {
            if ($age < 7) {
                $majlis = 'Tifal';
            } else if ($age >= 7 && $age < 15) {
                $majlis = 'Atfal';
            } else if ($age >= 15 && $age < 40) {
                $majlis = 'Khuddam';
            } else if ($age >= 40 && $age < 50) {
                $majlis = 'Ansar (Sofe Dom)';
            } else if ($age >= 50 && $age < 60) {
                $majlis = 'Ansar (Sofe Awal)';
            } else {
                $majlis = 'Ansar (Majlis Intekhab)';
            }
        } else {
            if ($age < 7) {
                $majlis = 'Naserat (Child)';
            } else if ($age <= 7 && $age < 15) {
                $majlis = 'Naserat';
            } else {
                $majlis = 'Lazna';
            }
        }
        return $majlis;
    }
}
