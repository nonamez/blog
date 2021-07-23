<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
</head>
<body>
	<div class="container mt-5">
		<h1>Payments journal</h1>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Client</th>
					<th>Created at</th>
					<th>Paid at</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($invoices as $invoice)
				<tr>
					<td>
						INV-{{ $invoice->id }}
					</td>
					<td>
						{{ $invoice->client->name }}
					</td>
					<td>
						{{ $invoice->created_at->format('Y-m-d') }}
					</td>
					<td>
						{{ $invoice->paid_at ? $invoice->paid_at->format('Y-m-d') : 'Not yet paid' }}
					</td>
					<td></td>
				</tr>

				<tr>
					<th></th>
					<th>Item List</th>
					<th>Item Price</th>
					<th>Item Count</th>
					<th>Total</th>
				</tr>
				@foreach($invoice->items as $item)
				<tr>
					<td></td>
					<td>
						{{ $item->comment }}
					</td>
					<td>€ {{ $item->sum }}</td>
					<td>{{ $item->count }}</td>
					<td>€ {{ $item->sum * $item->count}}</td>
				</tr>
				@endforeach

				<tr>
					<td colspan="5" class="text-end">
						<span class="pe-3">
							<strong>Total:</strong> € {{ $invoice->total }}
						</span>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>