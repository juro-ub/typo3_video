<?php

namespace Jro\Videoportal\ViewHelpers;

use TYPO3\CMS\Core\Context\Context;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class IsLoggedInViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var \Jro\Videoportal\Domain\Session\BackendSessionHandler
     */
    protected $session;

    /**
     * @param Jro\Videoportal\Domain\Session\BackendSessionHandler $session
     */
    public function injectSession(\Jro\Videoportal\Domain\Session\BackendSessionHandler $session)
    {
        $this->session = $session;
    }

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
    }

    public function render()
    {
        $context = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Context::class);
        if (!$context->getPropertyFromAspect('frontend.user', 'isLoggedIn') && !$context->getPropertyFromAspect('backend.user', 'isLoggedIn')) {
            return "0";

        } else {
            return "1";
        }
    }
}

?>