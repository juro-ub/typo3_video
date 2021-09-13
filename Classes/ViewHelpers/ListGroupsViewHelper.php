<?php

namespace Jro\Videoportal\ViewHelpers;

use TYPO3\CMS\Core\Context\Context;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ListGroupsViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * videoRepository
     *
     * @var \Jro\Videoportal\Domain\Repository\VideoRepository
     */
    protected $videoRepository;

    /**
     * @param Jro\Videoportal\Domain\Repository\VideoRepository $video
     */
    public function injectVideoRepository(\Jro\Videoportal\Domain\Repository\VideoRepository $video)
    {
        $this->videoRepository = $video;
    }

    /**
     * Arguments Initialization
     *
     */

    public function initializeArguments()
    {

    }

    public function render()
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $groupNames = $context->getPropertyFromAspect('frontend.user', 'groupNames');
        $names = "";
        $i = 0;
        foreach ($groupNames as $a) {
            $names .= $a;
            $i++;
            if ($i != count($groupNames)) {
                $names .= ', ';
            }
        }
        return $names;
    }
}

?>