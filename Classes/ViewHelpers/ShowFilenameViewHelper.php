<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ShowFilenameViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
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
        $this->registerArgument('field', 'string', 'the fieldname', TRUE);
    }

    public function render()
    {
        $html = "";
        if (!isset($this->arguments['field']))
            return "";
        $file = unserialize($this->session->get($this->arguments['field']));
        if ($file['name'])
            $html = $file['name'];
        return $html;
    }
}

?>