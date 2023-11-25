<?php

$finder = (new PhpCsFixer\Finder())
	->in(__DIR__)
	->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
	->setRules([
		'@Symfony' => true,
		'@PSR12' => true,
	])
	->setFinder($finder)
	->setIndent("\t")
	->setLineEnding("\r\n")
;