<?php

namespace Jro\Videoportal\Controller;


class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * add Warning Flash Message
     *
     * @return void
     */
    public function addWarning($header = "", $text = "")
    {
        $this->addFlashMessage($text, $header, \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING);
    }

    /**
     * add Info Flash Message
     *
     * @return void
     */
    public function addInfo($header = "", $text = "")
    {
        $this->addFlashMessage($text, $header, \TYPO3\CMS\Core\Messaging\FlashMessage::INFO);
    }

    /**
     * add Ok Flash Message
     *
     * @return void
     */
    public function addOk($header = "", $text = "")
    {
        $this->addFlashMessage($text, $header, \TYPO3\CMS\Core\Messaging\FlashMessage::OK);
    }
}

?>
