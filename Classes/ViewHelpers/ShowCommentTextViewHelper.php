<?php

namespace Jro\Videoportal\ViewHelpers;
/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ShowCommentTextViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * commentRepository
     *
     * @var \Jro\Videoportal\Domain\Repository\CommentRepository
     */
    protected $commentRepository;

    /**
     * @param Jro\Videoportal\Domain\Repository\CommentRepository $comment
     */
    public function injectCommentRepository(\Jro\Videoportal\Domain\Repository\CommentRepository $comment)
    {
        $this->commentRepository = $comment;
    }


    /**
     * Arguments Initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('comment_uid', 'string', 'the uid', TRUE);
    }

    public function render()
    {
        $html = "";

        $comment = $this->commentRepository->findByUid($this->arguments['comment_uid']);

        if ($comment == null)
            $html = "can't find comment text!";
        else
            $html = $comment->getText();
        return $html;
    }
}

?>