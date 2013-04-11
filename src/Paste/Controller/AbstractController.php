<?php

namespace Paste\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Paste\Gateway;

class AbstractController
{
    protected $gateway;
    protected $twig;

    public function __construct(Gateway $gateway, \Twig_Environment $twig)
    {
        $this->gateway = $gateway;
        $this->twig = $twig;
    }

    protected function redirect($url, $statusCode = 302)
    {
        return new RedirectResponse($url, $statusCode);
    }

    protected function render($template, $vars = array())
    {
        return new Response(
            $this->twig->render($template, $vars)
        );
    }
}