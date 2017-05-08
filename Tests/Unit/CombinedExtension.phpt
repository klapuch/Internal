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

final class CombinedExtension extends Tester\TestCase {
	public function testConvertingIntegerToString() {
		ob_start();
		(new Internal\CombinedExtension(
			new class implements Internal\Extension {
				function improve(): void {
					echo 'a';
				}
			},
			new class implements Internal\Extension {
				function improve(): void {
					echo 'b';
				}
			},
			new class implements Internal\Extension {
				function improve(): void {
					echo 'c';
				}
			}
		))->improve();
		Assert::same('abc', ob_get_clean());
	}
}


(new CombinedExtension())->run();