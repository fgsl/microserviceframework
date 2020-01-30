<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
declare(strict_types=1);

namespace Fgsl\Microserviceframework\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Template\TemplateRendererInterface;

class AclHandler implements RequestHandlerInterface
{
    /** @var TemplateRendererInterface */
    private $template;
    /** @var array **/
    private $dataKeys;
    
    public function __construct(TemplateRendererInterface $template, array $dataKeys)
    {
        $this->template = $template;
        $this->dataKeys = $dataKeys;
    }
    
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];
        foreach($this->dataKeys as $key){
            $data[$key] = $request->getAttribute($key);
        }
        return new HtmlResponse($this->template->render('acl::index', $data));
    }
}