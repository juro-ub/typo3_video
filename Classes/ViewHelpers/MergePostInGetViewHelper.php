<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MergePostInGetViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
    }

    public function render()
    {
        $_GET = array_merge($_GET, $_POST);
        return "";
    }
}

?>