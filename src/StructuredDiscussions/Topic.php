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

/**
 * Data-class that serves as a wrapper over the "view-topic" API result.
 *
 * @link https://www.mediawiki.org/w/api.php?action=help&modules=flow%2Bview-topic
 */
class Topic {
	/**
	 * @var array The topic info (in the format of the "view-topic" API module)
	 */
	private array $topicInfo;

	/**
	 * Topic constructor.
	 *
	 * @param array $topicInfo The topic info retrieved from the "view-topic" API submodule
	 */
	public function __construct( array $topicInfo ) {
		$this->topicInfo = $topicInfo;
	}

	/**
	 * Returns the name of the author of this topic.
	 *
	 * @return string
	 */
	public function getTopicCreator(): string {
		return $this->getLatestTopicRevision()['creator']['name'];
	}

	/**
	 * Returns the title of this topic.
	 *
	 * @return string
	 */
	public function getTopicTitle(): string {
		return $this->getLatestTopicRevision()['content']['content'];
	}

	/**
	 * Returns the revision with the given revision ID.
	 *
	 * @param string $revisionId
	 * @return array
	 */
	public function getRevisionById( string $revisionId ): array {
		return $this->topicInfo['revisions'][$revisionId];
	}

	/**
	 * Returns the latest revision by the given post ID.
	 *
	 * @param string $postId
	 * @return array
	 */
	public function getLatestRevisionByPostId( string $postId ): array {

	}

	/**
	 * Returns the topic revision. This revision contains information about the topic itself, such as the creator and the title of the
	 * topic.
	 *
	 * @return array
	 */
	private function getLatestTopicRevision(): array {
		$topicId = $this->topicInfo['roots'][0];
		$topicRevisionId = $this->topicInfo['posts'][$topicId][0];

		return $this->topicInfo['revisions'][$topicRevisionId];
	}

	private function getRootPostId(): string {

	}
}
