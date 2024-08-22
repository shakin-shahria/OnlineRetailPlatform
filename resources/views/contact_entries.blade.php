<!DOCTYPE html>
<html>
<head>
    <title>Contact Entries</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Contact Entries</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Contact Number</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
            <tr>
                <td>{{ $entry->name }}</td>
                <td>{{ $entry->email }}</td>
                <td>{{ $entry->message }}</td>
                <td>{{ $entry->contact_number }}</td>
                <td>{{ $entry->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
