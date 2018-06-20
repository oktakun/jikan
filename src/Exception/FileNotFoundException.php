<?php

namespace Jikan\Exception;

class FileNotFoundException extends Exception
{
	private const DEFAULT_STRING = "File not found";

	public function __construct(string $message, int $code = 0, Exception $previous = null) {
		if (is_null($message)) {
			$message = self::DEFAULT_STRING;
		}

		parent::__construct($message, $code, $previous);
	}
}