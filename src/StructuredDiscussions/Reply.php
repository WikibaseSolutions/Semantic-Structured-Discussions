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

use MWTimestamp;

/**
 * Class that serves as a wrapper over a reply revision from the "view-topic" API submodule.
 *
 * @link https://www.mediawiki.org/w/api.php?action=help&modules=flow%2Bview-topic
 */
final class Reply {
	/**
	 * @var array
	 */
	private array $replyRevision;

	/**
	 * Reply constructor.
	 *
	 * @param array $replyRevision The revision belonging to this reply (in the format of the "view-topic" API module)
	 */
	public function __construct( array $replyRevision ) {
		$this->replyRevision = $replyRevision;
	}

	/**
	 * Returns the content of this revision as wikitext.
	 *
	 * @return string
	 */
	public function getContent(): string {
		return $this->replyRevision['content']['content'];
	}

	/**
	 * Returns the creator of this comment.
	 *
	 * @return string
	 */
	public function getCreator(): string {
		return $this->replyRevision['creator']['name'];
	}

	/**
	 * Returns the timestamp on which this comment was last edited.
	 *
	 * @return array
	 */
	public function getLastEditedTimestamp(): array {
		return date_parse_from_format( 'YmdHis', $this->replyRevision['timestamp'] );
	}
}
