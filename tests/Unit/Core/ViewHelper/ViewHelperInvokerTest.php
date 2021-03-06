<?php
namespace TYPO3Fluid\Fluid\Tests\Unit\Core\ViewHelper;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;
use TYPO3Fluid\Fluid\Core\ViewHelper\ArgumentDefinition;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;
use TYPO3Fluid\Fluid\Tests\Unit\Core\Fixtures\TestViewHelper;
use TYPO3Fluid\Fluid\Tests\UnitTestCase;
use TYPO3Fluid\Fluid\View\TemplateView;
use TYPO3Fluid\Fluid\ViewHelpers\CountViewHelper;

/**
 * Class ViewHelperInvokerTest
 */
class ViewHelperInvokerTest extends UnitTestCase {

	/**
	 * @param string $viewHelperClassName
	 * @param array $arguments
	 * @param mixed $expectedOutput
	 * @param string|NULL $expectedException
	 * @test
	 * @dataProvider getInvocationTestValues
	 */
	public function testInvokeViewHelper($viewHelperClassName, array $arguments, $expectedOutput, $expectedException) {
		$view = new TemplateView();
		$resolver = new ViewHelperResolver();
		$invoker = new ViewHelperInvoker($resolver);
		$renderingContext = new RenderingContext($view);
		if ($expectedException) {
			$this->setExpectedException($expectedException);
		}
		$result = $invoker->invoke($viewHelperClassName, $arguments, $renderingContext);
		$this->assertEquals($expectedOutput, $result);
	}

	/**
	 * @return array
	 */
	public function getInvocationTestValues() {
		return array(
			array(CountViewHelper::class, array('subject' => array('foo')), 1, NULL),
			array(TestViewHelper::class, array('param1' => 'foo', 'param2' => array('bar')), 'foo', NULL),
			array(TestViewHelper::class, array('param1' => 'foo', 'param2' => array('bar'), 'add1' => 'baz', 'add2' => 'zap'), 'foo', NULL),
		);
	}

}
