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

use SMW\DIProperty;
use SMW\SemanticData;
use SMWDITime;

/**
 * This annotation contains information about when a topic was created.
 */
class CreationDateAnnotation implements Annotation {
	private const PROP_SD_CREATION_DATE = '__sd_creation_date';
	private const PROP_LABEL_SD_CREATION_DATE = 'Topic created on';

	/**
	 * @inheritDoc
	 */
	public function addAnnotation( SemanticData $semanticData ): void {
		$semanticData->addPropertyObjectValue(
			new DIProperty( self::PROP_SD_CREATION_DATE ),
			new SMWDITime( SMWDITime::CM_JULIAN, 2022 )
		);
	}

	/**
	 * @inheritDoc
	 */
	public static function getId(): string {
		return self::PROP_SD_CREATION_DATE;
	}

	/**
	 * @inheritDoc
	 */
	public static function getDefinition(): array {
		return [
			'label' => self::PROP_LABEL_SD_CREATION_DATE,
			'type' => '_dat',
			'viewable' => true,
			'annotable' => false
		];
	}
}
