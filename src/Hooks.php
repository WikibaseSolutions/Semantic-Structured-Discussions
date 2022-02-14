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

namespace SemanticStructuredDiscussions;

use Flow\Api\ApiFlowBase;
use SemanticStructuredDiscussions\SemanticMediaWiki\PropertyInitializer;
use SMW\Maintenance\DataRebuilder;
use SMW\Options;
use SMW\PropertyRegistry;
use SMW\SemanticData;
use SMW\Services\ServicesFactory;
use SMW\Store;
use SMW\StoreFactory;

/**
 * @note This class should only contain static methods.
 */
final class Hooks {
	/**
	 * Disable the construction of this class by making the constructor private.
	 */
	private function __construct() {
	}

	/**
	 * Called after the extension is registered.
	 */
	public static function onRegisterExtension(): void {
		// Enable semantic annotations for pages in the "Topic" namespace
		global $smwgNamespacesWithSemanticLinks;
		$smwgNamespacesWithSemanticLinks[NS_TOPIC] = true;
	}

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
		if ( $semanticData->getSubject()->getNamespace() !== NS_TOPIC ) {
			return true;
		}

		$title = $semanticData->getSubject()->getTitle();

		if ( $title === null ) {
			return true;
		}

		$topicRepository = Services::getTopicRepository();
		$topic = $topicRepository->getByTitle( $title );

		if ( $topic === null ) {
			return true;
		}

		$dataAnnotator = Services::getDataAnnotator();
		$dataAnnotator->addAnnotations( $topic, $semanticData );

		return true;
	}

	/**
	 * Called after a Flow API module has been executed.
	 *
	 * @param ApiFlowBase $module
	 * @link https://www.mediawiki.org/wiki/Extension:StructuredDiscussions/Hooks/APIFlowAfterExecute
	 */
	public static function onAPIFlowAfterExecute( ApiFlowBase $module ): void {
		if ( !$module->isWriteMode() ) {
			return;
		}

		$page = $module->getRequest()->getVal( 'page' );

		if ( $page === null ) {
			return;
		}

		$store = StoreFactory::getStore();
		$store->setOption( Store::OPT_CREATE_UPDATE_JOB, false );

		$dataRebuilder = new DataRebuilder(
			$store,
			ServicesFactory::getInstance()->newTitleFactory()
		);

		$dataRebuilder->setOptions(
			new Options( [ "page" => $page ] )
		);

		$dataRebuilder->rebuild();
	}
}
