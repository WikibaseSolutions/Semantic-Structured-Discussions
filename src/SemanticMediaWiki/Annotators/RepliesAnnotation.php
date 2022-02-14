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

namespace SemanticStructuredDiscussions\SemanticMediaWiki\Annotators;

use SemanticStructuredDiscussions\StructuredDiscussions\Topic;
use SMW\DIProperty;
use SMW\SemanticData;
use SMWDITime;

/**
 * This annotation contains information about the replies to a topic.
 */
class RepliesAnnotation implements Annotation {
	/**
	 * @var Topic The topic to use for the annotation
	 */
	protected Topic $topic;

	/**
	 * @param Topic $topic The topic to use for the annotation
	 */
	public function __construct( Topic $topic ) {
		$this->topic = $topic;
	}

	/**
	 * @inheritDoc
	 */
	public function addAnnotation( SemanticData $semanticData ): void {

	}

	/**
	 * @inheritDoc
	 */
	public static function getId(): string {
		return '__sd_replies';
	}

	/**
	 * @inheritDoc
	 */
	public static function getLabel(): string {
		return 'Topic replies';
	}

	/**
	 * @inheritDoc
	 */
	public static function getDefinition(): array {
		return [
			'label' => self::getLabel(),
			'type' => '', // TODO: Figure out appropriate type
			'viewable' => true,
			'annotable' => false
		];
	}
}
