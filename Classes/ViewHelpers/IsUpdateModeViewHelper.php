<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class IsUpdateModeViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
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
        $mode = unserialize($this->session->get('updateMode'));
        if ($mode == '1')
            return "1";
        else
            return "0";
    }
}

?>