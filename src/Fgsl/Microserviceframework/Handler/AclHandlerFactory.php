<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
declare(strict_types=1);

namespace Fgsl\Microserviceframework\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Template\TemplateRendererInterface;

class AclHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $template = $container->get(TemplateRendererInterface::class);
        $dataKeys = $container->get('config')['acl.datakeys'];
        return new AclHandler($template, $dataKeys);
    }
}