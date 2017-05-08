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

final class InternationalExtension extends Tester\TestCase {
	public function testSettingAllowedTimezone() {
		Assert::same('Europe/Prague', date_default_timezone_get());
		(new Internal\InternationalExtension('Europe/Berlin'))->improve();
		Assert::same('Europe/Berlin', date_default_timezone_get());
	}

	/**
	 * @throws \InvalidArgumentException Timezone "Foo" is invalid
	 */
	public function testThrowingOnUnknownTimezone() {
		(new Internal\InternationalExtension('Foo'))->improve();
	}
}


(new InternationalExtension())->run();