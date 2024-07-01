<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" sizes="16x16">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('login_files/css_archivos/login.css') }}">
    <!--===============================================================================================-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f1a67fab04.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="{{ asset('template/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <title>.:: La numero 1 ::.</title>
</head>

  <body>
    <div class="main">
    <img class="pequena" src="{{ asset('login_files/img/grupo.png')}}" alt="IMG">
        <div class="padre2">
          <label class="hijo2 bienvenido">
            <h2 class="lines-effect">
            </h2>
          </label>
        </div>

        <div class="padre">
            <div class="hijo" ><img class="medio1" src="{{ asset('login_files/img/LN14.png')}}" alt="IMG"></div>
            <div class="hijo" ><img class="medio3" src="{{ asset('login_files/img/GANGA3_2.png')}}" alt="IMG"></div>
        </div>

        <form class="form1" id="frm_login" name="frm_login" action="{{ route('IngresarLogin')}}" method="post">
            <input type="text" class="un" id="Usuario" name="Usuario" align="center" placeholder="USUARIO">
            <input type="password" class="pass" id="Password"  name="Password"  align="center" placeholder="CONTRASEÑA">


            <button type="submit" class="submit" value="Login" name="login" id="submit" align="center">INGRESAR</button>
            <center><br><div class="forgot-password"><u><a style="color:#F07D00" >¿Olvidaste&nbsp;tu&nbsp;contraseña?</a></u></div></center>
            <center><span class="txt1" role="alert" id="resultado" style="color:red;"></span></center>
        </form>
      </div>
  </body>
</html>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  $(document).ready(function() {
      document.getElementById("resultado").style.display = 'none';
      $('#frm_login').submit(function(event) {
          event.preventDefault();
          var Usuario = document.getElementById("Usuario").value;
          var Password = document.getElementById("Password").value;

          //var tipoacc = document.getElementById("tipoacc").value;
          var urlsistemas = "{{ url('Home')}}";
          //console.log(urlsistemas);
          var url = "{{ url('IngresarLogin') }}";
          $.ajax({
            url: url,
            data: {
              Usuario:Usuario,
              Password:Password
            },
            type: 'POST',
            success: function(resp){
              $('#resultado').html(resp);

              if(resp==="error"){
                $('#resultado').html("Verifique datos de usuario y/o contraseña");
                document.getElementById("resultado").style.display = 'block';
              }
              else{
                let timerInterval;
                Swal.fire({
                  title: "Bienvenido!",
                  html: "Que tenga un buen día!",
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                      timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                  },
                  willClose: () => {
                    clearInterval(timerInterval);
                  }
                }).then((result) => {
                  document.getElementById("resultado").style.display = 'none';
                  @if(session('redirect_url'))
                    location.href = "{{ session('redirect_url') }}";
                  @else
                    location.href = urlsistemas;
                  @endif
                });
              }
            }
          });
        });
    });
</script>
