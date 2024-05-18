<?php
/**
 * @author    Razoyo <razoyo@razoyo.com>
 * @copyright Copyright 2024 © Razoyo. All Rights Reserved.
 */

declare(strict_types=1);

namespace Razoyo\CarProfile\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Webapi\Rest\Request;
use Razoyo\CarProfile\Model\Config\Globals;

/**
 * Connect to Cars API
 */
class ApiService
{
    /**
     * @var ResponseFactory
     */
    protected ResponseFactory $responseFactory;
    /**
     * @var ClientFactory
     */
    protected ClientFactory $clientFactory;
    /**
     * @var Session
     */
    protected Session $customerSession;

    /**
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Session $customerSession
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Session $customerSession
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * Main method for calling Cars API endpoint and returning a response
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     * @return array
     */
    public function execute(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): array {
        $token = $this->auth();

        $params['headers'] = [
            'Authorization' => 'Bearer ' . $token
        ];

        $response = $this->doRequest($uriEndpoint, $params, $requestMethod);
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        $responseContent = json_decode($responseContent, true);

        return $responseContent;
    }

    /**
     * @return string
     */
    private function auth(): string
    {
        $response = $this->doRequest(Globals::API_ENDPOINT_CARS);
        $authToken = $response->getHeader('your-token');
        $this->customerSession->setCarProfileApiToken($authToken[0]);

        return $authToken[0];
    }

    /**
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => Globals::API_REQUEST_URI
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}
