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

namespace SemanticStructuredDiscussions\SemanticMediaWiki;

use SemanticStructuredDiscussions\SemanticMediaWiki\Annotators\Annotation;
use SemanticStructuredDiscussions\StructuredDiscussions\Topic;
use SemanticStructuredDiscussions\StructuredDiscussions\TopicRepository;
use SMW\SemanticData;
use Title;

/**
 * This class is responsible for annotating the SemanticData object with information about the given Topic.
 */
class DataAnnotator {
	/**
	 * @var AnnotationFactory The factory to use for constructing new annotations
	 */
	private AnnotationFactory $annotatorFactory;

	/**
	 * @param AnnotationFactory $annotatorFactory The factory to use for constructing new annotations
	 */
	public function __construct( AnnotationFactory $annotatorFactory ) {
		$this->annotatorFactory = $annotatorFactory;
	}

	/**
	 * Adds annotations to the given SemanticData object about the given Topic.
	 *
	 * @param Topic $topic The topic about which to add annotations
	 * @param SemanticData $semanticData The SemanticData object to add the annotations to
	 */
	public function addAnnotations( Topic $topic, SemanticData $semanticData ): void {
		$annotations = $this->getAnnotations( $topic );

		foreach ( $annotations as $annotation ) {
			$annotation->addAnnotation( $semanticData );
		}
	}

	private function getAnnotations( Topic $topic ): array {
		return [
			$this->annotatorFactory->newLastEditDateAnnotation( $topic )
		];
	}
}
