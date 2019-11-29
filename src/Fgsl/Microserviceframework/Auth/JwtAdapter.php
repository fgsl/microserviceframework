<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
namespace Fgsl\Microserviceframework\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Fgsl\Jwt\Jwt;

class JwtAdapter implements AdapterInterface
{
    /** @var string **/
    private $token;
    /** @var string **/
    private $subject;    
    
    /**
     * @param string $token
     * @param string $subject
     */
    public function __construct(string $token, string $subject)
    {
        $this->token    = $token;
        $this->subject  = $subject;
    }
 
    /**
     * {@inheritDoc}
     * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
     */
    public function authenticate()
    {
        $payload = Jwt::getPayload($this->token);
        $result = Result::FAILURE_IDENTITY_NOT_FOUND;
        $identity = 'unknown';
        $messages = ['Failure identity not found'];
        if ($payload == false){
            $result = Result::FAILURE_CREDENTIAL_INVALID;
            $messages[] = 'Failure credential invalid';
        } elseif ($payload->sub == $this->subject){            
            $result = Result::SUCCESS;
            $identity = $this->subject;
        }
        return new Result(
            $result,
            $identity,
            $messages
        );        
    }    
}