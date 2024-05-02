<?php

namespace SemanticStructuredDiscussions\SemanticMediaWiki\Hooks;

use SemanticStructuredDiscussions\StructuredDiscussions\SDReply;
use SemanticStructuredDiscussions\StructuredDiscussions\SDTopic;
use SMW\SemanticData;

/**
 * Hook that can be used to add topic annotators to SSD
 * These should extend SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\TopicAnnotator
 */
interface SemanticStructuredDiscussionsShouldSaveReply {

	/**
	 * Here you can add your own reply annotator.
	 *
	 * @param string[] $list An array of class names, should all be childs of TopicAnnotator.
	 */
	public function onSemanticStructuredDiscussionsShouldSaveReply( bool &$shouldSaveReply,string $id, int $index, SDReply $reply, SemanticData $semanticData, SDTopic $topic ): void;
}

