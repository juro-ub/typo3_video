<?php

namespace Jro\Videoportal\Domain\Session;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BackendSessionHandler extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var string
     */
    protected $storageKey = 'tx_videoportal';

    /**
     * @param string $storageKey
     */
    public function setStorageKey($storageKey) {
        $this->storageKey = $storageKey;
    }

    /**
     * Wert in der Session speichern
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function store($key, $value) {
        $data = $GLOBALS['BE_USER']->getSessionData($this->storageKey);
        $data[ $key ] = $value;
        return $GLOBALS['BE_USER']->setAndSaveSessionData($this->storageKey, $data);
    }

    /**
     * Wert löschen
     * @param string $key
     * @return boolean
     */
    public function delete($key) {
        $data = $GLOBALS['BE_USER']->getSessionData($this->storageKey);
        unset($data[ $key ]);
        return $GLOBALS['BE_USER']->setAndSaveSessionData($this->storageKey, $data);
    }


    /**
     * Wert auslesen
     * @param string $key
     * @return mixed
     */
    public function get($key) {
        $data = $GLOBALS['BE_USER']->getSessionData($this->storageKey);
        return isset($data[ $key ]) ? $data[ $key ] : NULL;
    }

}

?>