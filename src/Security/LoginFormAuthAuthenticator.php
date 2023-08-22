<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class LoginFormAuthAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    private $entityManager;
    public function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface  $entityManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');

        $request->getSession()->set(Security::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
            
        );
        
        $username = $this->entityManager->getRepository(User::class)->findOneBy(['username' => ['username']]);

        if (!$username) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Cette Username est introuvable.');
        }   

        return $username;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        // if ($this->denyAccessUnlessGranted('ROLE_ADMIN')) {
        //     return new RedirectResponse($this->urlGenerator->generate('user_index'));
        //              }else{
        //                 return new RedirectResponse($this->urlGenerator->generate('dashboard'));
        //              }
                       /** @var User $user */
                      $user = $token->getUser();

                    if(in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true) ){
                     return new RedirectResponse($this->urlGenerator->generate('dashboard'));}
                     
                    if(in_array('ROLE_PROS', $user->getRoles(), true) ){
                        return new RedirectResponse($this->urlGenerator->generate('app_prospect_index'));}
                    if(in_array('ROLE_ADD_PROS', $user->getRoles(), true) ){
                            return new RedirectResponse($this->urlGenerator->generate('app_prospect_new'));}
                    if(in_array('ROLE_EDIT_PROS', $user->getRoles(), true) ){
                           return new RedirectResponse($this->urlGenerator->generate('app_prospect_index'));}
                        
                    
                    if(in_array('ROLE_PROD', $user->getRoles(), true) ){
                            return new RedirectResponse($this->urlGenerator->generate('app_product_index'));}
                    if(in_array('ROLE_ADD_PROD', $user->getRoles(), true) ){
                            return new RedirectResponse($this->urlGenerator->generate('app_prospect_new'));}
                    if(in_array('ROLE_EDIT_PROD', $user->getRoles(), true) ){
                             return new RedirectResponse($this->urlGenerator->generate('app_product_index'));}
                        
                        

                    if(in_array('ROLE_USER', $user->getRoles(), true) ){
                            return new RedirectResponse($this->urlGenerator->generate('dashboard'));}
 

                    if(in_array('ROLE_RH', $user->getRoles(), true) ){
                            return new RedirectResponse($this->urlGenerator->generate('app_team_index'));}

                    if(in_array('ROLE_ADD_RH', $user->getRoles(), true) ){
                            return new RedirectResponse($this->urlGenerator->generate('team_new'));}
                                                              
                    return new RedirectResponse($this->urlGenerator->generate('dashboard'));
                    
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
   
    
}
