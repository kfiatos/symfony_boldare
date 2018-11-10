<?php

namespace App\Service;

use App\Service\Interfaces\SmsSenderInterface;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\SmsapiHttpClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SmsApiSender implements SmsSenderInterface
{
    /**
     * SMSAPI.COM client
     * @var SmsapiHttpClient
     */
    protected $smsApi;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $apiToken = $parameterBag->get('sms_api_token');
        $this->smsApi = (new SmsapiHttpClient())
            ->smsapiComService($apiToken);
    }

    /**
     * @param string $mobileNumber
     * @param string $message
     */
    public function sendSms(string $mobileNumber, string $message): void
    {
        $sms = SendSmsBag::withMessage($mobileNumber, $message);
        // Disabled due to authorization failure - account not registered
        // $this->smsApi->smsFeature()->sendSms($sms);
    }
}