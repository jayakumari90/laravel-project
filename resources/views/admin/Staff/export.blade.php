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
    <h1>Staff Export</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Last Login</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $user)
            <tr>
                <td>{{  $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->getRole->role_type }}</td>
                <td>{{ $user->last_login }}</td>
                <td>{{ ($user->status == 1) ? 'Active':'Inactive' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
