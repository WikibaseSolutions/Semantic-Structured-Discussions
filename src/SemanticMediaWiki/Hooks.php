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

use SemanticStructuredDiscussions\Services;
use SMW\PropertyRegistry;
use SMW\SemanticData;
use SMW\Store;

/**
 * Hook handler for hooks defined by Semantic MediaWiki.
 */
final class Hooks {
	/**
	 * Hook to add additional predefined properties.
	 *
	 * @link https://github.com/SemanticMediaWiki/SemanticMediaWiki/blob/master/docs/examples/hook.property.initproperties.md
	 * @param PropertyRegistry $propertyRegistry
	 * @return bool Always returns true
	 */
	public static function onInitProperties( PropertyRegistry $propertyRegistry ): bool {
		$propertyInitializer = new PropertyInitializer( $propertyRegistry );
		$propertyInitializer->initializeProperties();

		return true;
	}

	/**
	 * Hook to extend the SemanticData object before the update is completed.
	 *
	 * @link https://github.com/SemanticMediaWiki/SemanticMediaWiki/blob/master/docs/technical/hooks/hook.store.beforedataupdatecomplete.md
	 * @param Store $store
	 * @param SemanticData $semanticData
	 * @return bool
	 */
	public static function onBeforeDataUpdateComplete( Store $store, SemanticData $semanticData ): bool {
		$dataAnnotator = Services::getDataAnnotator();
		$dataAnnotator->addAnnotations( $semanticData );

		return true;
	}
}
