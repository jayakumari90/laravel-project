<!DOCTYPE html>
<html>
<head>
    <title>Customer Export</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Customer Export</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Groups</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $user)
            <tr>
                <td>{{  $index + 1 }}</td>
                <td>{{ $user->company }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->status }}</td>
                <td>{{ $user->groups }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
