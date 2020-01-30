<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
namespace Fgsl\Microserviceframework\Response;


use Laminas\Diactoros\Response\JsonResponse;
/**
 * Ensures that response complains with CORS
 */
class JsonResponseCors extends JsonResponse
{
    /**
     * @param mixed $data
     * @param int $status
     * @param array $headers
     * @param int $encodingOptions
     */
    public function __construct(
        $data,
        int $status = 200,
        array $headers = [],
        int $encodingOptions = self::DEFAULT_JSON_FLAGS
        )
    {
        $headers = array_merge($headers,[
            'Access-Control-Allow-Origin' => '*',
            'Content-Type' => 'application/json;charset=utf-8',
        ]);
        parent::__construct($data,$status,$headers,$encodingOptions);
    }    
}