<?php
namespace TYPO3Fluid\Fluid\Core\Cache;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

use TYPO3Fluid\Fluid\Core\Compiler\FailedCompilingState;
use TYPO3Fluid\Fluid\Core\Parser\ParsedTemplateInterface;
use TYPO3Fluid\Fluid\Core\Parser\ParsingState;

/**
 * Class FluidCacheWarmupResult
 */
class FluidCacheWarmupResult {

	const RESULT_COMPILABLE = 'compilable';
	const RESULT_COMPILED_= 'compiled';
	const RESULT_HASLAYOUT = 'hasLayout';
	const RESULT_COMPILEDCLASS = 'compiledClassName';
	const RESULT_FAILURE = 'failure';
	const RESULT_MITIGATIONS = 'mitigations';

	/**
	 * @var array
	 */
	protected $results = array();

	/**
	 * @param FluidCacheWarmupResult $result1...$resultN
	 * @return self
	 */
	public function merge() {
		foreach (func_get_args() as $result) {
			$this->results += $result->getResults();
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getResults() {
		return $this->results;
	}

	/**
	 * @param ParsedTemplateInterface $state
	 * @param string $templatePathAndFilename
	 * @return self
	 */
	public function add(ParsedTemplateInterface $state, $templatePathAndFilename) {
		$currentlyCompiled = $state->isCompiled();
		$class = get_class($state);
		$this->results[$templatePathAndFilename] = array(
			static::RESULT_COMPILABLE => $currentlyCompiled || $state->isCompilable(),
			static::RESULT_COMPILED_ => $state->isCompiled(),
			static::RESULT_HASLAYOUT => $state->hasLayout(),
			static::RESULT_COMPILEDCLASS => $state->getIdentifier()
		);
		if ($state instanceof FailedCompilingState) {
			$this->results[$templatePathAndFilename][static::RESULT_FAILURE] = $state->getFailureReason();
			$this->results[$templatePathAndFilename][static::RESULT_MITIGATIONS] = $state->getMitigations();
		}
		return $this;
	}

}