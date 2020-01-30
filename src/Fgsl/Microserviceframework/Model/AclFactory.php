<?php
/**
 * Fgsl Microservice Framework
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 */
namespace Fgsl\Microserviceframework\Model;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role;

class AclFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $aclConfig = $container->get('config')['acl'];
        $rolesConfig = $container->get('config')['roles'];
        $acl = new Rbac();
        foreach($aclConfig as $uid => $configuredRole){
            $role = new Role($uid);
            foreach($rolesConfig[$configuredRole] as $permission){
                $role->addPermission($permission);
            }
            $acl->addRole($role);
        }
        return $acl;
    }     
}
