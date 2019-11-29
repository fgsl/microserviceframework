<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
declare(strict_types=1);

namespace Fgsl\Microserviceframework\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Session\ManagerInterface;

class LogoutHandler implements RequestHandlerInterface
{
    /** @var RouterInterface **/
    private $router;
    /** @var null|TemplateRendererInterface */
    private $template;
    /** @var ManagerInterface */
    private $sessionManager;

    public function __construct(RouterInterface $router, TemplateRendererInterface $template, ManagerInterface $sessionManager) {
        $this->router   = $router;
        $this->template = $template;
        $this->sessionManager = $sessionManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $authenticationService = new AuthenticationService();
        $authenticationService->clearIdentity();
        $this->sessionManager->destroy();
        return new RedirectResponse($this->router->generateUri('home'));
    }
}
