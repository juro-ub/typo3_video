<?php

namespace Jro\Videoportal\ViewHelpers;
use TYPO3\CMS\Core\Context\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CountVideosInCatViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
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
     * userRepository
     *
     * @var \Jro\Videoportal\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @param Jro\Videoportal\Domain\Repository\UserRepository $user
     */
    public function injectUserRepository(\Jro\Videoportal\Domain\Repository\UserRepository $user)
    {
        $this->userRepository = $user;
    }

    /**
     * Arguments Initialization
     *
     */

    public function initializeArguments()
    {
        $this->registerArgument('cat', 'string', 'the cat', TRUE);
    }

    public function render()
    {
        $count = 0;
        $cat = $this->arguments['cat'];
        if ($cat == null) return 0;
        //get User Id
        $context = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $vids = $this->videoRepository->findByCatUid($cat->getUid(),$userUid=-1);
        if ($vids != null)
            $count = $vids->count();
        return $count;
    }
}

?>