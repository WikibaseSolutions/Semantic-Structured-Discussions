<?php

namespace SemanticStructuredDiscussions\SemanticMediaWiki\Hooks;

use SemanticStructuredDiscussions\StructuredDiscussions\SDReply;
use SemanticStructuredDiscussions\StructuredDiscussions\SDTopic;
use SMW\SemanticData;

/**
 * Hook that can be used to prevent some replies from being saved into SMW
 */
interface SemanticStructuredDiscussionsShouldSaveReply {

	/**
	 * Here you can decide for some replies to not save them.
	 *
	 * @param &bool $shouldSaveReply If set to false, the reply will not be saved
	 * @param string $id The id of the reply, under which the subsemantic data would be saved
	 * @param int $index The index of this reply
	 * @param SDReply $reply The reply that will be saved, if $shouldSaveReply is true
	 * @param SemanticData $semanticData The semantic data that the reply will be saved to. May already contain some subsemantic data on $id key
	 * @param SDTopic $topic The topic that the reply belongs to
	 *
	 * @return void
	 */
	public function onSemanticStructuredDiscussionsShouldSaveReply(
		bool &$shouldSaveReply,
		string $id,
		int $index,
		SDReply $reply,
		SemanticData $semanticData,
		SDTopic $topic
	): void;
}

