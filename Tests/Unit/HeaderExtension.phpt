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

final class HeaderExtension extends Tester\TestCase {
	public function testSentHeaders() {
		(new Internal\HeaderExtension(['Name' => 'Value', 'Foo' => 'bar']))->improve();
		Assert::contains('Name:Value', headers_list());
		Assert::contains('Foo:bar', headers_list());
	}

	public function testRemovingEmptyHeaders() {
		(new Internal\HeaderExtension(
			[
				'removed' => '',
				'removed2' => null,
				'removed3' => ' ',
				'kept' => '0',
			]
		))->improve();
		Assert::count(2, headers_list());
		Assert::contains('kept:0', headers_list());
	}
}


(new HeaderExtension())->run();