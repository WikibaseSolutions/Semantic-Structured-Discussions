<?php

namespace SemanticStructuredDiscussions\SemanticMediaWiki\Hooks;

/**
 * Hook that can be used to add reply annotators to SSD
 * These should extend SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\ReplyAnnotators\ReplyAnnotator
 */
interface SemanticStructuredDiscussionsGetReplyAnnotatorList {

	/**
	 * Here you can add your own reply annotator.
	 *
	 * @param string[] $list An array of class names, should all be childs of ReplyAnnotator.
	 */
	public function onSemanticStructuredDiscussionsGetReplyAnnotatorList( array &$list ): void;
}
