<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskApp</title>
</head>
<body>

    <div class="container" >
<div class="card card-body" style="margin-left: 40px;margin-left: 50px;">
<div align="center">
<a href="{{url('/')}}"><img width="100" src="{{url('/others/logo.png')}}"></a>
</div>
<h3>Verificación de correo electrónico.</h3>
<p>Hola, <br/>  <br/>
        Le hemos enviado este correo electrónico para verificar si este correo electrónico: <a href="#">{{$user->email}}</a> que proporcionó es válido; haga clic en el enlace para verificarlo.

  <a style="font-weight:bold;color:blue" target="_blank" href="http://task-app.lndo.site/check-email/{{$user->remember_token}}">Verificar mi correo electrónico</a>  </p><br/>
<p>Atentamente.</p>
</div>

</div>

</body>
</html>
