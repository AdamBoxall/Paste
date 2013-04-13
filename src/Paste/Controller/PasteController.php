<?php

namespace Paste\Controller;

use Symfony\Component\HttpFoundation\Request;
use Paste\Entity\Paste;
use Paste\Entity\Syntax;
use Paste\Controller\AbstractController;

class PasteController extends AbstractController
{
    public function createAction(Request $request)
    {
        if ($request->isMethod('POST')) {

            // Validation, maybe?

            $this->gateway->createPaste(
                Paste::fromArray($request->request->get('paste'))
            );

            // Make sure it was successful too, maybe?

            return $this->redirect('/');
        }

        $syntaxes = $this->gateway->getSyntaxList();

        return $this->render(
            'create.twig', [
                'syntaxes' => $syntaxes,
                'selected' => 'create'
            ]
        );
    }

    public function latestAction()
    {
        $pastes = $this->gateway->getLatestPastes();

        return $this->render(
            'latest.twig', [
                'pastes' => $pastes,
                'selected' => 'latest'
            ]
        );
    }

    public function viewAction($pasteHex)
    {
        $paste = $this->gateway->getPaste(hexdec($pasteHex));

        return $this->render(
            'view.twig', [
                'paste' => $paste,
                'selected' => 'view'
            ]
        );
    }

    public function aboutAction()
    {
        return $this->render(
            'about.twig', [
                'selected' => 'about'
            ]
        );
    }

    public function contactAction(Request $request)
    {
        return $this->render(
            'contact.twig', [
                'selected' => 'contact'
            ]
        );
    }
}