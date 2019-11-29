<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
namespace Fgsl\Microserviceframework\Model;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

class AclFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $aclConfig = $container->get('config')['acl'];
        $rolesConfig = $container->get('config')['roles'];
        $acl = new Rbac();
        foreach($aclConfig as $cpf => $configuredRole){
            $role = new Role($cpf);
            foreach($rolesConfig[$configuredRole] as $permission){
                $role->addPermission($permission);
            }
            $acl->addRole($role);
        }
        return $acl;
    }     
}