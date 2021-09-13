<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CheckedCheckboxViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('pids', 'array', 'The parent ids', TRUE);
        $this->registerArgument('pid', 'string', 'The parent id to find', TRUE);
    }

    public function render()
    {
        $html = "false";
        foreach ($this->arguments['pids'] as $pid) {
            if ($pid == $this->arguments['pid']) {
                $html = "true";
            }
        }
        return $html;
    }
}

?>