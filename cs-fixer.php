<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
	->in(__DIR__)
	->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
	->setRules([
		'@Symfony' => true,
		'@PSR12' => true,
		'@PHP80Migration:risky' => true,
		'global_namespace_import' => true,
		'declare_strict_types' => true,
	])
	->setFinder($finder)
	->setIndent("\t")
	->setLineEnding("\r\n")
;
