<?php declare( strict_types=1 );
/**
 * Semantic Structured Discussions MediaWiki extension
 * Copyright (C) 2022  Wikibase Solutions
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

namespace SemanticStructuredDiscussions\SemanticMediaWiki;

// @codingStandardsIgnoreStart
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\ReplyAnnotators\ContentAnnotator as ReplyContentAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\ReplyAnnotators\CreatorAnnotator as ReplyCreatorAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\ReplyAnnotators\ModificationDateAnnotator as ReplyModificationDateAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\ReplyAnnotators\OwnerAnnotation as ReplyOwnerAnnotation;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\ReplyAnnotators\OwnerNamespaceAnnotation as ReplyOwnerNamespaceAnnotation;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\ReplyAnnotators\ReplyAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\CreatorAnnotator as TopicCreatorAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\LockStatusAnnotator as TopicLockStatusAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\ModificationDateAnnotator as TopicModificationDateAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\OwnerAnnotation as TopicOwnerAnnotation;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\OwnerNamespaceAnnotation as TopicOwnerNamespaceAnnotation;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\SummaryAnnotator as TopicSummaryAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\TitleAnnotator as TopicTitleAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\TopicAnnotators\TopicAnnotator;
use SemanticStructuredDiscussions\SemanticMediaWiki\Hooks\HookRunner;
use SemanticStructuredDiscussions\StructuredDiscussions\SDReply;
use SemanticStructuredDiscussions\StructuredDiscussions\SDTopic;
// @codingStandardsIgnoreEnd

class AnnotatorStore {
	private const TOPIC_ANNOTATORS = [
		TopicCreatorAnnotator::class,
		TopicLockStatusAnnotator::class,
		TopicModificationDateAnnotator::class,
		TopicOwnerAnnotation::class,
		TopicOwnerNamespaceAnnotation::class,
		TopicSummaryAnnotator::class,
		TopicTitleAnnotator::class
	];

	private const REPLY_ANNOTATORS = [
		ReplyContentAnnotator::class,
		ReplyCreatorAnnotator::class,
		ReplyOwnerAnnotation::class,
		ReplyOwnerNamespaceAnnotation::class,
		ReplyModificationDateAnnotator::class
	];

	private $topicAnnotatorList = [];
	private $replyAnnotatorList = [];

	/**
	 * Runner for hooks
	 */
	private HookRunner $hookRunner;

	public function __construct( HookRunner $hookRunner ) {
		$this->hookRunner = $hookRunner;
	}

	/**
	 * Returns a list of class names of the available annotators.
	 *
	 * @return string[] class-string<Annotator> Class names of Annotator classes
	 */
	public function getAnnotators(): array {
		return array_merge( $this->getTopicAnnotatorList(), $this->getReplyAnnotatorList() );
	}

	/**
	 * Returns instances of the available annotators for a topic.
	 *
	 * @param SDTopic $topic The Topic to annotate
	 * @return TopicAnnotator[]
	 */
	public function getTopicAnnotators( SDTopic $topic ): array {
		return array_map( fn ( string $class ): TopicAnnotator => new $class( $topic ), $this->getTopicAnnotatorList() );
	}

	/**
	 * Returns instances of the available annotators for a reply.
	 *
	 * @param SDReply $reply The reply to annotate
	 * @return ReplyAnnotator[]
	 */
	public function getReplyAnnotators( SDReply $reply, SDTopic $topic ) {
		return array_map( fn ( string $class ): ReplyAnnotator => new $class( $reply, $topic ), $this->getReplyAnnotatorList() );
	}

	/**
	 * Get all the topic annotators, including ones defined in hooks
	 *
	 * @return string[] Class names of all topic annotators
	 */
	private function getTopicAnnotatorList(): array {
		if ( empty( $this->topicAnnotatorList ) ) {
			$list = self::TOPIC_ANNOTATORS;

			$this->hookRunner->onSemanticStructuredDiscussionsGetTopicAnnotatorList( $list );

			$this->topicAnnotatorList = $list;
		}

		return $this->topicAnnotatorList;
	}

	/**
	 * Get all the reply annotators, including ones defined in hooks
	 *
	 * @return string[] Class names of all reply annotators
	 */
	public function getReplyAnnotatorList(): array {
		if ( empty( $this->replyAnnotatorList ) ) {
			$list = self::REPLY_ANNOTATORS;

			$this->hookRunner->onSemanticStructuredDiscussionsGetReplyAnnotatorList( $list );

			$this->replyAnnotatorList = $list;
		}

		return $this->replyAnnotatorList;
	}
}
