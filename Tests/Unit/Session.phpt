<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Internal\Unit;

use Klapuch\Internal;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Session extends Tester\TestCase {
	public function testSettingAffectingGlobal() {
		$session = new Internal\Session([]);
		$session['test'] = 'abc';
		Assert::truthy($session['test']);
		Assert::same($_SESSION['test'], $session['test']);
	}

	public function testUnSettingAffectingGlobal() {
		$session = new Internal\Session([]);
		$session['test'] = 'abc';
		unset($session['test']);
		Assert::false(isset($session['test']));
		Assert::false(isset($_SESSION['test']));
	}

	/**
	 * @throws \UnexpectedValueException Key must be specified
	 */
	public function testThrowingOnEmptyKey() {
		$session = new Internal\Session([]);
		$session[] = 'abc';
		$session[0];
	}

	public function testSettingOptions() {
		$session = new Internal\Session(['sid_length' => 22]);
		$session['test'] = 'abc';
		Assert::same(22, strlen(session_id()));
	}

	public function testLazyStarting() {
		new Internal\Session(['sid_length' => 22]);
		Assert::same(0, strlen(session_id()));
	}
}


(new Session())->run();