<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class GetArrayValueViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('array', 'array', 'the array', TRUE);
        $this->registerArgument('index', 'string', 'index', TRUE);
    }

    public function render()
    {
        $html = "";
        if (!isset($this->arguments['array'])) return "";
        if (!isset($this->arguments['index'])) return "";

        $a = $this->arguments['array'];
        $i = $this->arguments['index'];

        if (!isset($a[$i])) return "";

        $html = $a[$i];
        return $html;
    }
}

?>