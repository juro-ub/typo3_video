<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class IsWatchedCommentViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
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
     * beUserRepository
     *
     * @var \Jro\Videoportal\Domain\Repository\BeUserRepository
     */
    protected $beUserRepository;

    /**
     * @param Jro\Videoportal\Domain\Repository\BeUserRepository $user
     */
    public function injectBeUserRepository(\Jro\Videoportal\Domain\Repository\BeUserRepository $user)
    {
        $this->beUserRepository = $user;
    }

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('commentUid', 'integer', TRUE);
    }

    public function render()
    {
        $cuid = $this->arguments['commentUid'];
        $beuser = $GLOBALS['BE_USER']->user;

        if ($beuser != null && is_array($beuser)) {
            $uid = $beuser['uid'];
            $user = $this->beUserRepository->findByUid($uid);
            if ($user != null) {
                $watchedComments = $user->getWatchedComments();
                foreach ($watchedComments as $c) {
                    if ($c->getUid() == $cuid) {
                        return '1';
                    }
                }

            }
        }
        return '0';
    }
}

?>