<?php
namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Security;

class LoginAuth extends AbstractFormLoginAuthenticator
{
    private $router;
    private $encoder;
    public function __construct(RouterInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->router = $router;
        $this->encoder = $encoder;
    }
    public function getCredentials(Request $request)
    {
        // check if login action is being executed
        if ($request->getPathInfo() != '/login_check') {
            return;
        }
        // get credentials
        $email = $request->request->get('_email');
        $request->getSession()->set(Security::LAST_USERNAME, $email);
        $password = $request->request->get('_password');
        return [
            'email' => $email,
            'password' => $password,
        ];
    }
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // get user by email
        $email = $credentials['email'];
        return $userProvider->loadUserByUsername($email);
    }
    public function checkCredentials($credentials, UserInterface $user)
    {
        // check password
        $plainPassword = $credentials['password'];
        if ($this->encoder->isPasswordValid($user, $plainPassword)) {
            return true;
        }
        throw new BadCredentialsException();
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }
}