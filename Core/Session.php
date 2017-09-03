<?php
declare(strict_types = 1);
namespace Klapuch\Internal;

final class Session implements \ArrayAccess {
	private $options;

	public function __construct(array $options = []) {
		$this->options = $options;
	}

	public function offsetExists($offset) {
		$session = $this->start();
		return isset($session[$offset]);
	}

	public function offsetGet($offset) {
		$session = $this->start();
		return $session[$offset];
	}

	public function offsetSet($offset, $value) {
		$session = &$this->start();
		if ($offset === null)
			throw new \UnexpectedValueException('Key must be specified');
		$session[$offset] = $value;
	}

	public function offsetUnset($offset) {
		$session = &$this->start();
		unset($session[$offset]);
	}

	private function &start(): array {
		if (!$this->started())
			session_start($this->options);
		return $_SESSION;
	}

	private function started(): bool {
		return session_status() === PHP_SESSION_ACTIVE;
	}
}