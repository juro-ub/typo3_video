<?php

namespace Jro\Videoportal\ViewHelpers;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class IsObserveCommentViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * @var \Jro\Videoportal\Domain\Session\BackendSessionHandler
     */
    protected $session;

    /**
     * @param Jro\Videoportal\Domain\Session\BackendSessionHandler $session
     */
    public function injectSession(\Jro\Videoportal\Domain\Session\BackendSessionHandler $session) {
        $this->session = $session;
    }

    /**
     * feUserRepository
     *
     * @var \Jro\Videoportal\Domain\Repository\UserRepository
     */
    protected $feUserRepository;

    /**
     * @param Jro\Videoportal\Domain\Repository\UserRepository $user
     */
    public function injectFeUserRepository(\Jro\Videoportal\Domain\Repository\UserRepository $user) {
        $this->feUserRepository = $user;
    }

    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments() {
        $this->registerArgument('commentUid', 'integer', TRUE);
    }

    public function render() {
        $cuid = $this->arguments['commentUid'];
        $feuser = $GLOBALS['TSFE']->fe_user->user;
        if ($feuser) {
            $uid = $feuser['uid'];
            $feuser = $this->feUserRepository->findByUid($uid);
            if ($feuser != null) {
                $observeComments = $feuser->getObservedComments();
                foreach ($observeComments as $c) {
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