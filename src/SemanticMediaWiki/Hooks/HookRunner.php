<?php

namespace SemanticStructuredDiscussions\SemanticMediaWiki\Hooks;

use MediaWiki\HookContainer\HookContainer;
use SemanticStructuredDiscussions\StructuredDiscussions\SDReply;
use SemanticStructuredDiscussions\StructuredDiscussions\SDTopic;
use SMW\SemanticData;

class HookRunner implements
	SemanticStructuredDiscussionsGetReplyAnnotatorList,
	SemanticStructuredDiscussionsGetTopicAnnotatorList,
	SemanticStructuredDiscussionsShouldSaveReply
{
	private HookContainer $container;

	public function __construct( HookContainer $container ) {
		$this->container = $container;
	}

	public function onSemanticStructuredDiscussionsGetReplyAnnotatorList( &$list ): void
	{
		$this->container->run(
			'SemanticStructuredDiscussionsGetReplyAnnotatorList',
			[ &$list ]
		);
	}

	public function onSemanticStructuredDiscussionsGetTopicAnnotatorList( &$list ): void
	{
		$this->container->run(
			'SemanticStructuredDiscussionsGetTopicAnnotatorList',
			[ &$list ]
		);
	}

	public function onSemanticStructuredDiscussionsShouldSaveReply(  bool &$shouldSaveReply,string $id, int $index, SDReply $reply, SemanticData $semanticData, SDTopic $topic ): void
	{
		$this->container->run('SemanticStructuredDiscussionsShouldSaveReply',
		[ &$shouldSaveReply, $id, $index, $reply, $semanticData, $topic]
	);
	}
}
