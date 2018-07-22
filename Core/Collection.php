<?php
declare(strict_types = 1);
namespace Klapuch\Internal;

interface Collection {
	/**
	 * Collection as array
	 * @return array
	 */
	public function values(): array;
}