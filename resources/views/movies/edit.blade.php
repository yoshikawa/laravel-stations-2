<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>

<body>
    <form action="/admin/movies/{{$movie->id}}/update" method="post">
        <input type="hidden" name='id' value={{$movie->id}}>
        @method('patch')
        @csrf
        <p>タイトル</p>
        @if ($errors->has('title'))
        @foreach ($errors->get('title') as $error)
        <p>{{$error}}</p>
        @endforeach
        @endif
        <input name='title' type="text" value="{{old('title',$movie->title)}}" required>

        <p>画像のURL</p>
        @if ($errors->has('image_url'))
        @foreach ($errors->get('image_url') as $error)
        <p>{{$error}}</p>
        @endforeach
        @endif

        <input name='image_url' type="text" value="{{old('image_url',$movie->image_url)}}" required>

        <p>公開年</p>
        @if ($errors->has('published_year'))
        @foreach ($errors->get('published_year') as $error)
        <p>{{$error}}</p>
        @endforeach
        @endif

        <select name="published_year">

            @for ($i = 2000; $i <= 2030; $i++) <option value="{{$i}}" @if ($i===(int)old('published_year',$movie->published_year))
                selected
                @endif
                >{{$i}}</option>
                @endfor
        </select>

        <br>
        <p>on:上映中,off:上映予定</p>
        <input type="checkbox" id="checkbox" onchange="changeCheckbox()" @if ((int)old('is_showing',$movie->is_showing) == "1") checked @endif
        ><label id='checkboxLabel'>上映予定</label>
        <input type="hidden" id="is_showing" name="is_showing" value={{old('is_showing',$movie->is_showing)}}>

        <p>概要</p>
        @if ($errors->has('description'))
        @foreach ($errors->get('description') as $error)
        <p>{{$error}}</p>
        @endforeach
        @endif
        <textarea name="description" id="" cols="30" rows="10" required>{{old('description',$movie->description)}}</textarea>

        <input type="submit" value="送信">
    </form>
    <script>
        function changeCheckbox() {
            if (document.getElementById('checkbox').checked) {
                document.getElementById('is_showing').value = 1
                document.getElementById('checkboxLabel').innerHTML = "上映中";
            } else {
                document.getElementById('is_showing').value = 0
                document.getElementById('checkboxLabel').innerHTML = "上映予定";
            }
        }
    </script>
</body>

</html>