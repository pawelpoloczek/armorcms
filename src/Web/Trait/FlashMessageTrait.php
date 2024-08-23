<?php
declare(strict_types=1);

namespace ArmorCMS\Web\Trait;

use ArmorCMS\Web\Enum\FlashMessageEnum;
use Symfony\Component\HttpFoundation\Request;

trait FlashMessageTrait
{
    /**
     * Add flash message to session
     * Flash message types: error, done, warning, info
     */
    protected function setFlashMessage(Request $request, string $type, $message): void
    {
        $flashBag = $request->getSession()->getFlashBag();
        $flashBag->add($type, $message);
    }
    
    /**
     * Set errors from form to flash messages
     */
    protected function setFormErrors(Request $request,  $form): void
    {
        foreach ($form->getErrors(true) as $error) {
            $this->setFlashMessage($request, FlashMessageEnum::ERROR, $error->getMessage());
        }
    }
}

