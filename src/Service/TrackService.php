<?php

declare(strict_types=1);

namespace DeFixIT\Anonlytics\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\ServerBag;

use function curl_init;
use function curl_setopt;
use function curl_exec;
use function file_get_contents;
use function json_decode;
use function json_encode;

class TrackService
{
    private const TRACK_HOST = 'https://api.anonlytics.eu/track';
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function sendRequestData(ServerBag $server)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, self::TRACK_HOST);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getPostData($server));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_exec($curl);
    }

    private function getHeaders(): array
    {
        return [
            'Content-type: application/json',
            'anonlytics-client-token: ' . $this->parameterBag->get('anonlytics.client_token'),
            'anonlytics-site-token: ' . $this->parameterBag->get('anonlytics.site_token'),
        ];
    }

    private function getPostData(ServerBag $server): string
    {
        return json_encode(
            [
                'server_software' => $server->get('SERVER_SOFTWARE') ?? null,
                'server_protocol' => $server->get('SERVER_PROTOCOL') ?? null,
                'server_name' => $server->get('SERVER_NAME') ?? null,
                'uri' => $server->get('REQUEST_URI') ?? null,
                'method' => $server->get('REQUEST_METHOD') ?? null,
                'http_user_agent' => $server->get('HTTP_USER_AGENT') ?? null,
                'http_accept_language' => $server->get('HTTP_ACCEPT_LANGUAGE') ?? null,
                'http_referer' => $server->get('HTTP_REFERER') ?? null,
                'country' => $this->getCountry($server->get('REMOTE_ADDR')) ?? null,
            ]
        );
    }

    private function getCountry(string $ip): ?string
    {
        return json_decode(
            file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ip)
        )->geoplugin_countryCode ?? null;
    }
}