<?php

namespace SemanticStructuredDiscussions\SemanticMediaWiki\Hooks;

/**
 * Hook that can be used to add topic annotators to SSD
 * These should extend SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\TopicAnnotator
 */
interface SemanticStructuredDiscussionsGetTopicAnnotatorList {

	/**
	 * Here you can add your own reply annotator.
	 *
	 * @param string[] $list An array of class names, should all be childs of TopicAnnotator.
	 */
	public function onSemanticStructuredDiscussionsGetTopicAnnotatorList( array &$list ): void;
}
