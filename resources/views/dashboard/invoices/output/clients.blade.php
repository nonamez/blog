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
		<h1>Clients</h1>
		<table class="table">
			<thead>
				<tr>
					<th style="width: 175px;">Name</th>
					<th style="width: 140px;">Company Code</th>
					<th>VAT Code</th>
					<th>Location</th>
					{{-- <th>Email</th> --}}
					{{-- <th>Phone</th> --}}
					<th>Site</th>
				</tr>
			</thead>
			<tbody>
				@foreach($clients as $client)
				<tr>
					<td>{{ $client->name }}</td>
					<td>{{ $client->company_code }}</td>
					<td>{{ $client->vat_code }}</td>
					<td>{{ $client->location }}</td>
					{{-- <td>{!! $client->email ? sprintf('<a href="mailto:%s">%s</a>', $client->email, $client->email) : '' !!}</td> --}}
					{{-- <td>{!! $client->phone ? sprintf('<a href="tel:%s">%s</a>', $client->phone, $client->phone) : '' !!}</td> --}}
					<td>{!! $client->url ? sprintf('<a href="%s">%s</a>', $client->url, $client->url) : '' !!}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>