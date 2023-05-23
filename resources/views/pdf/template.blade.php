<!DOCTYPE html>
<html>
<head>
    <title>Data Export</title>
    <style>
        /* Gaya CSS untuk PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Daftar Hadir {{ $rekrutmen_name }}</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Phone</th>
                <th>Email</th>
                <th>TTD</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            @foreach ($data as $item)
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td>{{ $item->name_user }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->email }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
