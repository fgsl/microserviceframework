<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
declare(strict_types=1);

namespace Fgsl\Microserviceframework\Handler;

use Fgsl\Http\Http;
use Fgsl\Jwt\Jwt;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Laminas\Permissions\Rbac\Rbac;

abstract class AbstractAuthHandler implements RequestHandlerInterface
{
    /** @var Rbac */
    protected $acl;    
    
    /** @var RouterInterface */
    protected $router;

    /** @var null|TemplateRendererInterface */
    protected $template;
    
    /** @var string */
    protected $uid;

    public function __construct(Rbac $acl, RouterInterface $router, TemplateRendererInterface $template = null
    ) {
        $this->acl           = $acl;
        $this->router        = $router;
        $this->template      = $template;
    }

    /**
     * General authentication control
     * {@inheritDoc}
     * @see \Psr\Http\Server\RequestHandlerInterface::handle()
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $params = $request->getParsedBody();
        if (isset($params['token']) && isset($params['uid'])){
            $token = $params['token'];
            if (Jwt::expired($token)){
                return new RedirectResponse($this->router->generateUri('home'));
            }
            $this->uid   = $params['uid'];
        } else {
            $this->uid = $request->getAttribute('uid');
        }
        $authenticated = false;
        try {
            $authenticated = (bool) Http::curl(API_URL . '/auth/uid/' . $this->uid);
        } catch (\Exception $e) {
            $authenticated = false;
        }
        if (!$authenticated){
            return new RedirectResponse($this->router->generateUri('home'));
        }
        $tokens = explode('/',$request->getUri()->getPath());
        $route = $tokens[1];
        if (!$this->acl->isGranted($this->uid, $route)){
            return new RedirectResponse($this->router->generateUri('acl',['uid' => $this->uid]));
        }
        
        return $this->processRequest($request);
    }
    
    /**
     * Specific handling of HTTP request
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    abstract protected function processRequest(ServerRequestInterface $request) : ResponseInterface;
}