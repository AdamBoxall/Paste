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

            $postedPaste = $request->request->get('paste');

            // Define expiration
            if (!empty($postedPaste['expires_unit'])
             && in_array($postedPaste['expires_unit'], ['hour', 'day', 'week', 'month'])) {
                $postedPaste['expires'] = strtotime('+1 ' . $postedPaste['expires_unit']);
            } else {
                $postedPaste['expires'] = null;
            }

            // Insert paste into database and get ID
            $paste = $this->gateway->createPaste(
                Paste::fromArray($postedPaste)
            );

            // Redirect to paste page
            return $this->redirect('/' . $paste->getHexId());
        }

        $syntaxes = $this->gateway->getSyntaxList();

        return $this->render(
            'create.twig', [
                'syntaxes' => $syntaxes,
                'selected' => 'create'
            ]
        );
    }

    public function viewAction(Request $request, $pasteHex)
    {
        $paste = $this->gateway->getPaste(hexdec($pasteHex));

        if ($request->query->get('raw') !== null) {
            // Only show the paste content
            $template = 'raw';
        } else {
            // Show the expired page if paste has expired
            $template = ($paste->hasExpired() ? 'expired' : 'view');
        }

        return $this->render(
            $template . '.twig', [
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

    protected function render($template, $vars = array())
    {
        $vars['latest'] = $this->gateway->getLatestPastes();
        $vars['count'] = $this->gateway->getPasteCount();

        return parent::render($template, $vars);
    }
}