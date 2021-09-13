<?php

namespace Jro\Videoportal\Validation\Validator;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FileValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * The allowed types
     *
     * @var array
     */
    protected $allowedTypes;

    /**
     * The allowed types
     *
     * @var string
     */
    protected $strListOfAllowedTypes;

    /**
     * fieldname
     *
     * @var string
     */

    protected $fieldname;

    /**
     * optional
     *
     * @var boolean
     */

    protected $optional = FALSE;

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

    public function __construct($arguments)
    {
        $this->strListOfAllowedTypes = $arguments['types'];
        $this->fieldname = $arguments['field'];
        $this->setAllowedTypes($arguments['types']);
        if (isset($arguments['optional'])) {
            $this->optional = (boolean)$arguments['optional'];
        }
        parent::__construct();
    }

    /**
     * @param array $file
     * @return boolean
     */
    public function isValid($file)
    {
        $f = $this->session->get($this->fieldname);
        if ((!isset($file['name']) || strlen($file['name']) == 0)) {
            if (isset($f['name']) && strlen($f['name']) > 0) {
                return true;
            } else {
                if (!$this->optional) {
                    $this->addError('File is missing', 1262341470);
                    return false;
                } else {
                    return true;
                }
            }
        }
        if ($file['name'] && $file['tmp_name']) {
            if ($this->uploadFile($file['name'], $file['type'], $file['tmp_name'], $file['size']) === false) {
                $this->addError('error while upload', 1262341470);
                return false;
            }
        }
        $filenameExtensionPre = strtolower(strrchr($file['name'], '.'));
        $filenameExtension = substr($filenameExtensionPre, 1);
        $allowedFilenameExtension = in_array($filenameExtension, $this->allowedTypes);
        if (!$allowedFilenameExtension) {
            $this->addError('File extension ' . $filenameExtension . " not allowed (" . $this->strListOfAllowedTypes . ")", 1262341470);
            return false;
        }
        $this->session->store($this->fieldname, serialize($file));
        return true;
    }

    /**
     * Set the allowed types
     *
     * @param string $allowedTypes Allowed Types
     * @return object Rule object
     */
    public function setAllowedTypes($allowedTypes)
    {
        $allowedTypes = strtolower($allowedTypes);
        $this->allowedTypes = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $allowedTypes);
        return $this;
    }

    protected function uploadFile($name, $type, $temp, $size)
    {
        if ($size > 0) {
            $basicFileFunctions = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Utility\File\BasicFileUtility');
            $name = $basicFileFunctions->cleanFileName($name);
            $uploadPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('fileadmin/user_upload');
            $uniqueFileName = $basicFileFunctions->getUniqueName($name, $uploadPath);
            $fileStored = move_uploaded_file($temp, $uniqueFileName);
            $returnValue = basename($uniqueFileName);
            return $fileStored;
        }
    }
}

?>