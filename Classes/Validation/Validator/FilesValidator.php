<?php
namespace Jro\Videoportal\Validation\Validator;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FilesValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
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
     * @param mixed $files
     * @return void
     */
    public function isValid($files) : void
    {
        //validate array        
        foreach ($files as $file) {
            if ($file['name'] && $file['tmp_name'] && $file['deleted'] != '1') {
                if ($this->uploadFile($file['name'], $file['type'], $file['tmp_name'],
                        $file['size']) === false) {
                    $this->addError('error while upload', 1262341470);                    
                }
            }
        }
        $this->session->store('files', serialize($files));        
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
