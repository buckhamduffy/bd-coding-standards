<?php

namespace Tests\Rector\TestRector\Fixture;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController
{
	public function __construct(private Request $request)
	{
	}

	public function __invoke(Request $request): void
	{
		$baz = $request->property['foo']['bar'];
		$baz = $this->request->property['foo']['bar'];

		echo $this->request->foo;

		$request->validate(['foo' => ['required']]);

		echo $request->input('foo');

		if ($request->baz) {
			$foo = $request->bar;
		}

		$bar = $request->foo;
		$bar = $request->foo ? $request->baz : $request->qux;
		$baz = $request->foo ?: 'bar';
		$baz = $request->foo['bar'];
		$baz = $request->get('foo', $request->baz)['bar'];

		echo $request['foo'];
		echo $baz['foo']['bar']['baz'];

		$baz = request()->foo['bar']['bar']['bar'];

		echo $request->get('foo', 'default');

		echo (int) $request->get('foo');
		echo (float) $request->get('foo');
		echo (bool) $request->get('foo');

		echo $request->date('foo');

		echo Carbon::parse($request->get('foo'), timezone: 'Australia/Brisbane');
		echo Carbon::parse($request->get('foo', 'now'), 'Australia/Brisbane');
		echo Carbon::parse($request->get('foo', 'today'), 'Australia/Brisbane');
		echo Carbon::parse($request->get('foo', '2024-01-01'), 'Australia/Brisbane');
		echo Carbon::createFromFormat('Y-m-d', $request->get('foo', 'now'), 'Australia/Brisbane');
		echo Carbon::createFromFormat('Y-m-d', $request->input('foo'));
		echo Carbon::createFromFormat('Y-m-d', $request->input('bar'), 'Australia/Brisbane');
	}
}

?>

-----
<?php

namespace Tests\Rector\TestRector\Fixture;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController
{
	public function __construct(private Request $request)
	{
	}

	public function __invoke(Request $request): void
	{
		$baz = $request->input('property.foo.bar');
		$baz = $this->request->input('property.foo.bar');

		echo $this->request->input('foo');

		$request->validate(['foo' => ['required']]);

		echo $request->input('foo');

		if ($request->input('baz')) {
			$foo = $request->input('bar');
		}

		$bar = $request->input('foo');
		$bar = $request->input('foo') ? $request->input('baz') : $request->input('qux');
		$baz = $request->input('foo') ?: 'bar';
		$baz = $request->input('foo.bar');
		$baz = $request->input('foo.bar', $request->input('baz.bar'));

		echo $request->input('foo');
		echo $baz['foo']['bar']['baz'];

		$baz = request()->input('foo.bar.bar.bar');

		echo $request->input('foo', 'default');

		echo $request->integer('foo');
		echo $request->float('foo');
		echo $request->boolean('foo');

		echo $request->date('foo');

		echo $request->date('foo', null, 'Australia/Brisbane');
		echo ($request->date('foo', null, 'Australia/Brisbane') ?: Carbon::now('Australia/Brisbane'));
		echo ($request->date('foo', null, 'Australia/Brisbane') ?: Carbon::today('Australia/Brisbane'));
		echo ($request->date('foo', null, 'Australia/Brisbane') ?: Carbon::parse('2024-01-01', 'Australia/Brisbane'));
		echo ($request->date('foo', 'Y-m-d', 'Australia/Brisbane') ?: Carbon::now('Australia/Brisbane'));
		echo $request->date('foo', 'Y-m-d');
		echo $request->date('bar', 'Y-m-d', 'Australia/Brisbane');
	}
}

?>
