<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class UnreachableResourceException extends Exception
{
	public function __construct(string $filePath)
	{
		parent::__construct(sprintf('Unable to read data from %s', $filePath));
	}
}
