<?php
namespace Jro\Videoportal\Validation\Validator;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FrontendFilesValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * The allowed types
     *
     * @var array
     */
    protected $allowedTypes;

    /**
     *max size
     *
     * @var integer
     */
    protected $maxSize;

    /**
     * The allowed types
     *
     * @var string
     */
    protected $strListOfAllowedTypes;
    
    public function setOptions(array $options): void
    {
        $this->strListOfAllowedTypes = $options['types'];
        $this->setAllowedTypes($options['types']);
        $this->setMaxSize((int)$options['maxsize']);
        $this->initializeDefaultOptions($options);
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

    public function setMaxSize($size)
    {
        $this->maxSize = $size;
    }

    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @param mixed $files
     * @return void
     */
    public function isValid($files) : void
    {
        ///validate array        
        $size = 0;
        $files_count = 0;
        //check file type
        foreach ($files as $file) {
            if ($file['name'] && $file['tmp_name'] && $file['deleted'] != 1) {
                $files_count++;
                $filenameExtensionPre = strtolower(strrchr($file['name'], '.'));
                $filenameExtension = substr($filenameExtensionPre, 1);
                $allowedFilenameExtension = in_array($filenameExtension, $this
                    ->allowedTypes);
                if (!$allowedFilenameExtension) {
                    $this->addError('Not allowed file type (Allowed: pdf, zip, rar, 7zip, jpg, png, gif, jpeg, 7z)', 1262341470);
                    
                }
                $size += (int)$file['size'];
            }
        }
        //check file count
        if ($files_count > 10) {
            $this->addError('Only 10 files are allowed', 1262341470);            
        }
        //check file size
        if ($size > (int)$this->maxSize) {
            $this->addError('The size of the files is to big', 1262341470);            
        }

        foreach ($files as $file) {
            if ($file['name'] && $file['tmp_name'] && $file['deleted'] != '1') {
                if ($this->uploadFile($file['name'], $file['type'], $file['tmp_name'],
                        $file['size']) === false) {
                    $this->addError('error while upload', 1262341470);                    
                }
            }
        }        
    }

    protected function uploadFile($name, $type, $temp, $size)
    {
        if ($size > 0) {
            $basicFileFunctions = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Utility\File\BasicFileUtility');
            $name = $basicFileFunctions->cleanFileName($name);
            $uploadPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('fileadmin/user_upload/');
            $uniqueFileName = $basicFileFunctions->getUniqueName($name, $uploadPath);
            $fileStored = move_uploaded_file($temp, $uniqueFileName);
            $returnValue = basename($uniqueFileName);
            return $fileStored;
        }
    }
}

?>
