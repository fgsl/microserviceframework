<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
declare(strict_types=1);

namespace Fgsl\Microserviceframework\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Session\ManagerInterface;

class LogoutHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $sessionManager = $container->get(ManagerInterface::class);

        return new LogoutHandler($router, $template, $sessionManager);
    }
}
