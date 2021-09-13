<?php

namespace Jro\Videoportal\Controller;


class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * initializeAction
     *
     * @return void
     */
    public function initializeAction()
    {
        if (null === $this->controllerContext) {
            $this->controllerContext = $this->buildControllerContext();
        }
    }

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

    /**
     * if the size of the array is less than 4 set size to 4
     * @param array $c
     * @return void
     */
    protected function fillArray(&$c)
    {
        for ($i = 0; $i < 4; $i++) {
            if ($i > (count($c) - 1)) {
                array_push($c, "");
            }
        }
    }
}

?>
