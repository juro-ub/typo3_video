<?php

namespace Jro\Videoportal\Validation\Validator;


/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class LinkValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * @var Jro\Videoportal\Domain\Session\BackendSessionHandler
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
     * @param array $links
     * @return boolean
     */
    public function isValid($links)
    {
        ///validate array
        $valid = true;
        $this->session->store('links', serialize($links));
        reset($links);
        for ($i = 0; $i < count($links); $i++) {
            $c = current($links);
            if (strlen($c) != 0 && !filter_var($c, FILTER_VALIDATE_URL)) {
                $this->addError('The link ' . $c . ' is not valid', 1262341470);
                $valid = false;
            }
            next($links);
        }
        return $valid;
    }
}

?>