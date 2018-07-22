<?php
declare(strict_types = 1);
namespace Klapuch\Internal;

interface Text {
	/**
	 * Text as string
	 * @return string
	 */
	public function value(): string;
}