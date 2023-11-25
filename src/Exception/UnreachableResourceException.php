<?php

namespace App\Exception;

class UnreachableResourceException extends \Exception
{
	public function __construct(string $filePath)
	{
		parent::__construct(sprintf('Unable to read data from %s', $filePath));
	}
}
