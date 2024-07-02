<!DOCTYPE html>
<html>
<head>
    <title>Leads Export</title>
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
    <h1>Leads Export</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Lead Value</th>
                <th>Tags</th>
                <th>Assigned</th>
                <th>Lead Status</th>
                <th>Source</th>                
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $lead)
            <tr>
                <td>{{ $lead->id }}</td>
                <td>{{ $lead->name }}</td>
                <td>{{ $lead->company }}</td>
                <td>{{ $lead->email }}</td>
                <td>{{ $lead->phone }}</td>
                <td>{{ $lead->lead_value }}</td>
                <td>{{ $lead->tag }}</td>
                <td>{{ $lead->getStaff->name }}</td>
                <td>{{ $lead->getLeadStatus->lead }}</td>
                <td>{{ $lead->getSource->source }}</td>
                <td>{{ $lead->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
