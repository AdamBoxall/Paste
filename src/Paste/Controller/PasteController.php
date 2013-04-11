<?php

namespace Paste\Controller;

use Symfony\Component\HttpFoundation\Request;
use Paste\Controller\AbstractController;

class PasteController extends AbstractController
{
    public function createAction(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->getPasteRepository()->save(
                Paste::fromArray($request->request->get('paste'))
            );

            return $this->redirect('/create');
        }

        $syntaxes = $this->gateway->getSyntaxList();

        return $this->render(
            'create.twig',
            ['syntaxes' => $syntaxes]
        );
    }

    public function latestAction()
    {
        $pastes = $this->gateway->getLatestPastes();

        return $this->render(
            'latest.twig',
            ['pastes' => $pastes]
        );
    }

    public function viewAction($pasteId)
    {
        $paste = $this->gateway->getPaste($pasteId);

        return $this->render(
            'view.twig',
            ['paste' => $paste]
        );
    }

    public function aboutAction()
    {
        return $this->render('about.twig');
    }

    public function contactAction(Request $request)
    {
        return $this->render('contact.twig');
    }
}