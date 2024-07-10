<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>.:: La numero 1 ::.</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('login_files/css_archivos/login.css') }}">
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

        <img class="pequena" src="{{ asset('inicio/Grupo-LN1.png') }}">

        <div class="padre2">
            <label class="hijo2 bienvenido">
                <h2 class="lines-effect">
                </h2>
            </label>
        </div>
    
        <form class="form1" method="post">
            <div class="col-md-12" style="display: flex; justify-content: center;margin-top: 0.7rem;">
                <strong><label for="Usuario" style="color: #696769; font-size:smaller">USUARIO</label></strong>
            </div>
            <input type="text" class="un" id="Usuario" name="Usuario">
            <div class="col-md-12" style="display: flex; justify-content: center;">
                <strong><label for="Password" style="color: #696769; font-size:smaller">CONTRASEÑA</label></strong>
            </div>
            <input type="password" class="pass" id="Password"  name="Password">
            <center style="background-color: white;"><br><div class="forgot-password"><a style="color:#ffa404; font-weight:600; font-size:0.7rem;" >¿Olvidaste&nbsp;tu&nbsp;contraseña?</a></div></center><br>
            <center style="background-color: white; margin-bottom:10px;"><span class="txt1" role="alert" id="resultado" style="color:red; display:none;"></span></center>
            <button type="button" class="submit" onclick="Login();">INGRESAR</button>
        </form>
        @csrf
    </div>

    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/plugins/blockui/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('template/plugins/blockui/custom-blockui.js') }}"></script>

    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                Login();
            }
        });

        function Login(){
            $(document)
            .ajaxStart(function() {
                $.blockUI({
                    message: '<svg> ... </svg>',
                    fadeIn: 800,
                    overlayCSS: {
                        backgroundColor: '#302f30',
                        opacity: 0.8,
                        zIndex: 1200,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        color: '#fff',
                        zIndex: 1201,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            })
            .ajaxStop(function() {
                $.blockUI({
                    message: '<svg> ... </svg>',
                    fadeIn: 800,
                    timeout: 100,
                    overlayCSS: {
                        backgroundColor: '#302f30',
                        opacity: 0.8,
                        zIndex: 1200,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        color: '#fff',
                        zIndex: 1201,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            });

            var Usuario = document.getElementById("Usuario").value;
            var Password = document.getElementById("Password").value;
            var url = "{{ url('IngresarLogin') }}";
            var csrfToken = $('input[name="_token"]').val();
            
            $.ajax({
                type: 'POST',
                url: url,
                data: {'Usuario':Usuario,'Password':Password},
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp){
                    if(resp=="error"){
                        $('#resultado').html("Verifique datos de usuario y/o contraseña");
                        document.getElementById("resultado").style.display = 'block';
                    }else{
                        @if(session('redirect_url'))
                            location.href = "{{ session('redirect_url') }}";
                        @else
                            location.href = "{{ url('Home')}}"
                        @endif
                    }
                }
            });
        }
    </script>
</body>
</html>