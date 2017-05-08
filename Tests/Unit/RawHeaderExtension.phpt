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

final class RawHeaderExtension extends Tester\TestCase {
	public function testSentHeaders() {
		(new Internal\RawHeaderExtension(
			['Name:Value', 'Foo:bar']
		))->improve();
		Assert::contains('Name:Value', headers_list());
		Assert::contains('Foo:bar', headers_list());
	}

	public function testStringConversion() {
		(new Internal\RawHeaderExtension(
			[new class {
				function __toString() {
					return 'Name:Value';
				}
			}]
		))->improve();
		Assert::contains('Name:Value', headers_list());
	}

	public function testRemovingCaseInsensitiveDuplicates() {
		(new Internal\RawHeaderExtension(
			['Name:Value', 'Foo:bar', 'name:Value']
		))->improve();
		Assert::notContains('Name:Value', headers_list());
		Assert::contains('name:Value', headers_list());
		Assert::contains('Foo:bar', headers_list());
	}
}


(new RawHeaderExtension())->run();