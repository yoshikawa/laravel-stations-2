<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie</title>
</head>
<body>
    <ul>
    @foreach ($movies as $movie)
        <li>タイトル: {{ $movie->title }}</li>
        <li>画像: {{ $movie->image_url }}</li>
        <li>公開年: {{ $movie->published_year }}</li>
        @if ($movie->is_showing)
        <li>上映中</li>
        @endif
        @if ($movie->is_showing == false)
        <li>上映予定</li>
        @endif
        <li>概要: {{ $movie->description }}</li>
    @endforeach
    </ul>
</body>
</html>