<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class DisableCheckboxViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('childs', 'object', 'the current cat', TRUE);
        $this->registerArgument('cat_id', 'string', 'The id to find', TRUE);
    }

    public function render()
    {
        $html = "";
        if ($this->arguments['childs'] == null) return;

        if ($this->isChild($this->arguments['childs']->getParent()))
            $html = "true";

        if ($this->arguments['cat_id'] == $this->arguments['childs']->getUid())
            $html = "true";

        return $html;
    }

    private function isChild($cats, $ret = false)
    {
        foreach ($cats as $child) {
            if ($child->getUid() == $this->arguments['cat_id']) {
                return true;
            }
            if ($child->getParent()->count() > 0)
                $ret = $this->isChild($child->getParent(), $ret);
        }
        return $ret;
    }
}

?>