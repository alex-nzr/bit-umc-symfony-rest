<?php
namespace App\Service;

use App\Config\Variables;
use App\Utils\Utils;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BaseOneCService{
    protected HttpClientInterface $client;
    protected string $endpoint;
    protected string $authToken;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;

        $this->endpoint = "";
        foreach (Variables::ONE_C_CONNECT_DATA as $param => $value)
        {
            $separator = $param === "PROTOCOL" ? Variables::COLON . Variables::D_SEP : Variables::SEP;
            $this->endpoint .= $value . $separator;
        }

        $this->authToken = base64_encode(Variables::AUTH_LOGIN_1C.Variables::COLON.Variables::AUTH_PASSWORD_1C);
    }

    /** send request to 1C database
     * @param array $params
     * @return string
     */
    public function post(array $params = []): string
    {
        try {
            $response = $this->client->request('POST', $this->endpoint, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->authToken,
                    'Content-Type' => 'application/json;charset=utf-8',
                ],
                'body' => json_encode($params),
            ]);

            return $response->getContent();
        }
        catch (\Exception | TransportExceptionInterface | ClientExceptionInterface
        | RedirectionExceptionInterface | ServerExceptionInterface $e )
        {
            return Utils::addError($e->getMessage());
        }
    }
}