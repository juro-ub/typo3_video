<?php

namespace Jro\Videoportal\Validation\Validator;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ParentCategoryValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

    /**
     * @var Jro\Videoportal\Domain\Session\BackendSessionHandler
     */
    protected $session;

    /**
     * @param Jro\Videoportal\Domain\Session\BackendSessionHandler $session
     */
    public function injectSession(\Jro\Videoportal\Domain\Session\BackendSessionHandler $session) {
        $this->session = $session;
    }

    /**
     * @param mixed $pids
     * @return void
     */
    public function isValid($pids): void {
        $this->session->store('pids', serialize($pids));
    }

}

?>
