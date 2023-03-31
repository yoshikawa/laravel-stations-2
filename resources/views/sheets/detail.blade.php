</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sheet</title>
    <link rel="stylesheet" href="\css\app.css">
</head>

<body>
    <div class='sheets'>
        <h2>シート一覧</h2>
        <table>
            <thead>
                <th>ID</th>
                <th>行列</th>
            </thead>
            @foreach ($sheets as $sheet)
            <tbody>
                <td>{{ $sheet->id }}</td>
                <td>{{ $sheet->row .'-'. $sheet->column}}</td>
            </tbody>
            @endforeach
        </table>
    </div>
</body>

</html>