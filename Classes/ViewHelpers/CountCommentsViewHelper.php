<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CountCommentsViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('comments', 'array', TRUE);
    }

    public function render()
    {
        $c = $this->countAllComments($this->arguments['comments']);
        return $c;
    }

    private function countAllComments($comments, $count = 0)
    {
        foreach ($comments as $c) {
            $count++;
            if ($c->getChilds()->count() > 0) {
                $count = $this->countAllComments($c->getChilds(), $count);
            }
        }
        return $count;
    }
}

?>