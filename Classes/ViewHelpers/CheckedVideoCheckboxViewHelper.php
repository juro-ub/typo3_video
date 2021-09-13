<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CheckedVideoCheckboxViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
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
        $this->registerArgument('field', 'string', 'next,extension, requirement', TRUE);
        $this->registerArgument('uid', 'string', 'uid of video', TRUE);
    }

    public function render()
    {
        $relatedVideos = unserialize($this->session->get('relatedVideos'));

        if ($relatedVideos == false) return "false";

        $html = "false";
        foreach ($relatedVideos as $r) {
            $uid = $r['uid'];
            if ($uid == $this->arguments['uid']) {
                if ($r['relation'][$this->arguments['field']] == 1) {
                    $html = "true";
                }
            }
        }
        return $html;
    }
}

?>