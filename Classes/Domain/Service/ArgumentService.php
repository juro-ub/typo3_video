<?php

namespace Jro\Videoportal\Domain\Service;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ArgumentService extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * return all POST & GET variables by pluginname
     * @param string $plugInName
     * @return array
     */
    public function getArguments($plugInName)
    {
        if (!empty($plugInName)) {
            if (array_key_exists($plugInName, $_POST)) {
                $argsPlugin = $_POST[$plugInName];
                return $argsPlugin;
            } else {
                if (array_key_exists($plugInName, $_GET)) {
                    $argsPlugin = $_GET[$plugInName];
                    return $argsPlugin;
                } else {
                    return NULL;
                }
            }
        }
    }

    /**
     * return Argument value by pluginName and key
     * @param string $plugInName
     * @param string $key
     * @return string
     */
    public function getArgument($plugInName, $key)
    {
        $argsKey = $this->getArguments($plugInName);
        if (!empty($key) && !empty($argsKey)) {
            if (array_key_exists($key, $argsKey)) {
                return $argsKey[$key];
            }
        }
    }

    /**
     * check for Argument by pluginName and key
     * @param string $plugInName
     * @param string $key
     * @return boolean
     */
    public function hasArgument($plugInName, $key)
    {
        $argsPlugin = $this->getArguments($plugInName);
        if (!empty($key) && !empty($argsPlugin)) {
            if (array_key_exists($key, $argsPlugin)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

?>