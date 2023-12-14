<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
  <p>Hello {{$name}}</p>
  <p>Thank you for registering.</p>
  <p>To start, please access the website <a href="{{ $app_url }}">here</a>.</p>
  <p>Thank you!</p>
  
  {{-- $name and $app_url are coming from $details. This was defined in the create() of the RegisterController --}}
  
</body>
</html>