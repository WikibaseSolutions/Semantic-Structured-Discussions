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
use SMW\SemanticData;

class DataAnnotator {
	private AnnotationFactory $annotatorFactory;

	public function __construct(AnnotationFactory $annotatorFactory ) {
		$this->annotatorFactory = $annotatorFactory;
	}

	public function addAnnotations( SemanticData $semanticData ): void {
		$annotations = $this->getAnnotations();

		foreach ( $annotations as $annotation ) {
			$annotation->addAnnotation( $semanticData );
		}
	}

	/**
	 * @return Annotation[]
	 */
	private function getAnnotations(): array {
		return [
			$this->annotatorFactory->newCreationDateAnnotation()
		];
	}
}
