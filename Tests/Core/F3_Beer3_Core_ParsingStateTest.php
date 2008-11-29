<?php
declare(ENCODING = 'utf-8');
namespace F3::Beer3::Core;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package Beer3
 * @subpackage Tests
 * @version $Id:$
 */
/**
 * Testcase for ParsingState
 *
 * @package Beer3
 * @subpackage Tests
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class ParsingStateTest extends F3::Testing::BaseTestCase {

	/**
	 * Parsing state
	 * @var F3::Beer3::Core::ParsingState
	 */
	protected $parsingState;
	
	public function setUp() {
		$this->parsingState = new F3::Beer3::Core::ParsingState();
	}
	public function tearDown() {
		unset($this->parsingState);
	}
	
	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function setRootNodeCanBeReadOutAgain() {
		$rootNode = new F3::Beer3::Core::SyntaxTree::RootNode();
		$this->parsingState->setRootNode($rootNode);
		$this->assertSame($this->parsingState->getRootNode(), $rootNode, 'Root node could not be read out again.');
	}
	
	/**
	 * @test
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 */
	public function pushAndGetFromStackWorks() {
		$rootNode = new F3::Beer3::Core::SyntaxTree::RootNode();
		$this->parsingState->pushNodeToStack($rootNode);
		$this->assertSame($rootNode, $this->parsingState->getNodeFromStack($rootNode), 'Node returned from stack was not the right one.');
		$this->assertSame($rootNode, $this->parsingState->popNodeFromStack($rootNode), 'Node popped from stack was not the right one.');
	}
}



?>