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
class ShowPersonalWatchcountViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * videoRepository
     *
     * @var \Jro\Videoportal\Domain\Repository\VideoRepository
     */
    protected $videoRepository;

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
        $this->registerArgument('video_uid', 'string', 'the uid', TRUE);
    }

    public function render()
    {
        $context = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('backend.user', 'id');
        if ($userUid <= 0)
            $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        if ($userUid > 0) {
            $html = "0";
            $user = $this->userRepository->findByUid($userUid);
            if($user != null){
              $counts = $user->getWatchcount();
              $found = false;
              foreach ($counts as $count) {
                  if ($count->getVideoId() == $this->arguments['video_uid']) {
                      $html = $count->getCount();
                  }
              }
            }else{
              $html = "User not found!";
            }

        } else {
            $html = "You must be logged in to see your watch count!";
        }
        return $html;
    }
}

?>
