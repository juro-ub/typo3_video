<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EditMenuLinkViewHelper extends \Jro\Videoportal\ViewHelpers\MyActionViewHelper
{
    /**
     * @return string Rendered link
     */
    public function render() : string
    {
        if ($this->matchesCurrentRequest($this->arguments['action'], $this->arguments['arguments'], $this->arguments['controller'])) {
            $cssClass = '	font-family: Arial;
			font-size: 13px;
			font-weight: bold;
			font-style: normal;
			text-decoration: none;
			color: rgb(0, 157, 224);
			';
            $this->tag->addAttribute('style', $cssClass);
        }
        return call_user_func_array('parent::render', func_get_args());
    }

    protected function matchesCurrentRequest($action, $arguments, $controller)
    {
        $renderingContext = $this->renderingContext;
        $request = $renderingContext->getRequest();
        
        $action_ = $request->getControllerActionName();
        if ($action_ == $action) {
            return true;
        }
        return false;
    }
}

?>