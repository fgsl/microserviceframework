# Microservice Framework

## Authentication

Class **JwtAdapter** provides authentication based on Javascript Web Token. 
It was designed to work as provider for **Zend\Authentication**.

## Middleware

Class **AbstractAuthHandler** provides a HTTP handling with authentication and authorization control.

Class **AbstractAclHandlerFactory** makes easy to create factories for handlers with access control. 
This class use the model **AclFactory** to create a permission control based on component **Zend\Permissions\Rbac**.

Class **AclHandler** provides a HTTP handler for a authorization error page. Use  **AclHandlerFactory** to create instances of **AclHandler**.

Class **LogoutHandler** provides a standard HTTP handler for exiting from an application. Use **LogoutHandlerFactory** to create instances of **LogoutHandler**. 