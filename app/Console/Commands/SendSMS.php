<?php

namespace App\Console\Commands;

use App\Libraries\CommonFunctions;
use App\Models\SMS;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendSMS extends Command
{
    protected $signature = 'send-sms {index}';
    protected $description = 'sms blust';
    protected int $limit = 2;

    protected int $offset = 0;

    public function handle()
    {
        $smsList = SMS::where('status', 0)->where('no_of_try', '<=', 3)->skip($this->offset)->take($this->limit)->get();
        $index = $this->argument('index');

        if ($index > 10) exit;
        $this->offset = ($index * $this->limit) + $this->limit;

        if (count($smsList) > 0) {
            foreach ($smsList as $sms) {
                try {
                    $no_of_try = $sms->no_of_try + 1;
                    $status = SMS::where('id', $sms->id)->where('status', 0)->update(['no_of_try' => $no_of_try, 'status' => -1]);

                    if (!$status) continue;

                    if ($this->sendSMS($sms->mobile, $sms->msg_body)) {
                        SMS::where('id', $sms->id)->update(['status' => 1]);
                    }
                } catch (Exception $e) {
                    SMS::where('id', $sms->id)->update(['status' => -2]);
                    Log::error('Something went wrong while sending sms: ' . ' Err: ' . $e->getMessage() . ' File: ' . $e->getFile() . ' Line: ' . $e->getLine());
                }
            }
        }
    }


    private function sendSMS($mobile_no, $sms_txt)
    {
        $api_url = config('constants.SMS_API_URL');
        $init_id = config('constants.INSTITUTE_ID');
        $sms_txt = urlencode($sms_txt);

        $url = "$api_url?link_id=$init_id&user_type=C&mobile_no=$mobile_no&message=$sms_txt";
        $headers = [];

        $apiResponse = CommonFunctions::curlGetRequest($url, $headers);
        if ($apiResponse['http_code'] == 200) {
            $responseArr = json_decode($apiResponse['data'], true);
            return $responseArr['status'] == 'success';
        }
        return false;
    }
}
