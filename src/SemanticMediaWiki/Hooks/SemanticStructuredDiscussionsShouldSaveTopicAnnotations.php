<?php

namespace SemanticStructuredDiscussions\SemanticMediaWiki\Hooks;

use SemanticStructuredDiscussions\StructuredDiscussions\SDReply;
use SemanticStructuredDiscussions\StructuredDiscussions\SDTopic;
use SMW\SemanticData;

/**
 * Hook that can be used to prevent annotations from being saved on some topics.
 * The replies to the topic will be saved regardless of this hooks results
 */
interface SemanticStructuredDiscussionsShouldSaveTopicAnnotations {

	/**
	 * Here you can decide for some topics to not save extra annotations on them.
	 *
	 * @param &bool $shouldSaveTopicAnnotations If set to false, no annotations will be saved for this topic
	 * @param SDTopic $topic The topic for which to decide if we want to save annotations
	 * @param SemanticData $semanticData The semantic data that the topic will be saved to.
	 *
	 * @return void
	 */
	public function onSemanticStructuredDiscussionsShouldSaveTopicAnnotations(
		bool &$shouldSaveTopicAnnotations,
		SDTopic $topic,
		SemanticData $semanticData
	): void;
}
