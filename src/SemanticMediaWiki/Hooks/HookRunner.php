<?php

namespace SemanticStructuredDiscussions/SemanticMediaWiki/Hooks;

class HookRunner implements
	SemanticStructuredDiscussionsGetReplyAnnotatorList,
	SemanticStructuredDiscussionsGetTopicAnnotatorList
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
}
