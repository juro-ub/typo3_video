<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CategoryLinkViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\ActionViewHelper
{

    /**
     * @var \Jro\Videoportal\Domain\Session\FrontendSessionHandler
     */
    protected $session;

    /**
     * @param Jro\Videoportal\Domain\Session\FrontendSessionHandler $session
     */
    public function injectSession(\Jro\Videoportal\Domain\Session\FrontendSessionHandler $session)
    {
        $this->session = $session;
    }

    /**
     * @return string Rendered link
     */
    public function render()
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
        $uid = $arguments['uid'];
        $level_id = $arguments['level_id'];
        if ($this->session->get('activeUids')) {
            $active = unserialize($this->session->get('activeUids'));
            foreach ($active as &$c) {
                if ($c['level_id'] == $level_id && $uid == $c['uid']) {
                    return true;
                }
            }

        } else {
            return false;
        }

        return false;
    }
}

?>