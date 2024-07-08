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
    <div style="padding-top: 1rem; margin-left:1rem">
        <div style="display: flex; justify-content: space-between;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#ffa700" id="record">
                <path d="M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"></path>
                <path fill="#ffa700" fill-rule="evenodd" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-2 0a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" clip-rule="evenodd"></path>
            </svg>
            <svg id="SvgjsSvg1001" width="32" height="32" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs">
                <defs id="SvgjsDefs1002"></defs>
                <g id="SvgjsG1008">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="333" height="333">
                        <path fill="#ffa700" d="M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" class="color000 svgShape"></path>
                        <path fill="#ffa700" fill-rule="evenodd" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-2 0a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" clip-rule="evenodd" class="color000 svgShape"></path>
                    </svg>
                </g>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#ffa700" id="record">
                <path d="M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"></path>
                <path fill="#ffa700" fill-rule="evenodd" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-2 0a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" clip-rule="evenodd"></path>
            </svg>
        </div>
    </div>
    <img class="pequena" src="{{ asset('login_files/img/grupo.png')}}" alt="IMG">
        <div class="padre2">
          <label class="hijo2 bienvenido">
            <h2 class="lines-effect">
            </h2>
          </label>
        </div>

        <form class="form1" id="frm_login" name="frm_login" action="{{ route('IngresarLogin')}}" method="post">
            <div class="col-md-12" style="display: flex; justify-content: center;margin-top: 0.7rem;">
                <strong><label for="Usuario" style="color: #696769; font-size:smaller">USUARIO</label></strong>
            </div>
            <input type="text" class="un" id="Usuario" name="Usuario" align="center">
            <div class="col-md-12" style="display: flex; justify-content: center;">
                <strong><label for="Password" style="color: #696769; font-size:smaller">CONTRASEÑA</label></strong>
            </div>
            <input type="password" class="pass" id="Password"  name="Password"  align="center">


            <center style="background-color: white;"><br><div class="forgot-password"><a style="color:#ffa404; font-weight:600; font-size:0.7rem;" >¿Olvidaste&nbsp;tu&nbsp;contraseña?</a></div></center><br>
            <center style="background-color: white;"><span class="txt1" role="alert" id="resultado" style="color:red;"></span></center>
            <button type="submit" class="submit" value="Login" name="login" id="submit" align="center">INGRESAR</button>
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
