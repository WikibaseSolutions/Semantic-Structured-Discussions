<?php declare(strict_types=1);
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

namespace SemanticStructuredDiscussions\StructuredDiscussions;

use Flow\Exception\CrossWikiException;
use Flow\Exception\DataModelException;
use Flow\Model\Workflow;
use MWTimestamp;
use Title;

/**
 * Class that serves as a wrapper over the "view-topic" API result.
 *
 * @link https://www.mediawiki.org/w/api.php?action=help&modules=flow%2Bview-topic
 */
final class Topic {
	private const REPLY_CHANGE_TYPES = ['edit-post', 'reply'];

	/**
	 * @var array The topic info (in the format of the "view-topic" API module)
	 */
	private array $topicInfo;

	private Title $ownerTitle;
	private Title $topicTitle;
	private Workflow $workflow;

	/**
	 * Topic constructor.
	 *
	 * @param array $topicInfo The topic info retrieved from the "view-topic" API submodule
	 */
	public function __construct( array $topicInfo ) {
		$this->topicInfo = $topicInfo;
	}

	/**
	 * Returns the title of the topic.
	 *
	 * @return string
	 */
	public function getTitle(): string {
		return $this->getRootRevision()['properties']['topic-of-post'];
	}

	/**
	 * Returns the summary of the topic, or NULL if the topic is not summarized.
	 *
	 * @return string|null
	 */
	public function getSummary(): ?string {
		return $this->getRootRevision()['summary']['revision']['content']['content'] ?? null;
	}

	/**
	 * Returns the username of the user that created the topic.
	 *
	 * @return string
	 */
	public function getCreator(): string {
		return $this->getRootRevision()['creator']['name'];
	}

	/**
	 * Returns the timestamp on which this topic was last edited.
	 *
	 * @return array
	 */
	public function getLastEditedTimestamp(): array {
		return date_parse_from_format( 'YmdHis', $this->getRootRevision()['timestamp'] );
	}

	/**
	 * Returns the replies to this topic.
	 *
	 * @return Reply[]
	 */
	public function getReplies(): array {
		$replyRevisions = array_filter( $this->getRevisions(), function ( array $revision ) {
			return in_array( $revision['changeType'], self::REPLY_CHANGE_TYPES, true );
		} );

		return array_map( function ( array $revision ): Reply {
			return new Reply( $revision );
		}, $replyRevisions );
	}

	/**
	 * Returns the Title of the owner of this topic. The owner is the article this topic belongs to.
	 *
	 * @return Title
	 * @throws DataModelException
	 * @throws CrossWikiException
	 */
	public function getOwnerTitle(): Title {
		if ( !isset( $this->ownerTitle ) ) {
			$this->ownerTitle = $this->getWorkflow()->getOwnerTitle();
		}

		return $this->ownerTitle;
	}

	/**
	 * Returns the workflow.
	 *
	 * @return Workflow
	 * @throws DataModelException
	 */
	private function getWorkflow(): Workflow {
		if ( !isset( $this->workflow ) ) {
			$this->workflow = Workflow::create( 'topic', $this->getTopicTitle() );;
		}

		return $this->workflow;
	}

	/**
	 * Returns the Title of the Topic page.
	 *
	 * @return Title
	 */
	private function getTopicTitle(): Title {
		if ( !isset( $this->topicTitle ) ) {
			$this->topicTitle = Title::makeTitleSafe( NS_TOPIC, $this->getWorkflowId() );
		}

		return $this->topicTitle;
	}

	/**
	 * Returns the ID of the workflow.
	 *
	 * @return string
	 */
	private function getWorkflowId(): string {
		return $this->topicInfo['workflowId'];
	}

	/**
	 * Returns the latest revision for the root of this topic.
	 *
	 * @return array
	 */
	private function getRootRevision(): array {
		return $this->getRevisionByPostId( $this->getRootPostId() );
	}

	/**
	 * Returns the post ID of the root of this topic.
	 *
	 * @return string
	 */
	private function getRootPostId(): string {
		return $this->topicInfo['roots'][0];
	}

	/**
	 * Returns the (latest) revision based on the given post ID.
	 *
	 * @param string $postId
	 * @return array
	 */
	private function getRevisionByPostId( string $postId ): array {
		return $this->getRevisionById( $this->topicInfo['posts'][$postId][0] );
	}

	/**
	 * Returns the revision with the given revision ID.
	 *
	 * @param string $revisionId
	 * @return array
	 */
	private function getRevisionById( string $revisionId ): array {
		return $this->getRevisions()[$revisionId];
	}

	/**
	 * Returns the revisions of this topic.
	 *
	 * @return array
	 */
	private function getRevisions(): array {
		return $this->topicInfo['revisions'];
	}
}
