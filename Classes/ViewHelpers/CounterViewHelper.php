<?php

namespace Jro\Videoportal\ViewHelpers;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CounterViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * Arguments Initialization
     *
     */
    private static $counter = -1;

    public function initializeArguments() {
        $this->registerArgument('reset', 'string', TRUE);
    }

    public function render() {
        $html = "";
        if ($this->arguments['reset'] != null) {
            $this->reset();
            $html = "";
        } else {
            $html = self::$counter;
        }
        $this->increment();
        return $html;
    }

    private function reset() {
        self::$counter = -1;
    }

    private function increment() {
        self::$counter++;
        return self::$counter;
    }

}

?>