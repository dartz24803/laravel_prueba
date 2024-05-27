function soloLetras(e){
   key = e.keyCode || e.which;
   tecla = String.fromCharCode(key).toLowerCase();
   letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
   especiales = "8";

   tecla_especial = false
   for(var i in especiales){
        if(key == especiales[i]){
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla)==-1 && !tecla_especial){
        return false;
    }
}
function solo2numerosyletras(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  numeros = " 0123456789áéíóúabcdefghijklmnñopqrstuvwxyz";

  if(numeros.indexOf(tecla)==-1){
      return false;
  }
}

function soloNumeros(e){
   key = e.keyCode || e.which;
   tecla = String.fromCharCode(key).toLowerCase();
   numeros = " 0123456789";

    if(numeros.indexOf(tecla)==-1){
        return false;
    }
 }

/*
 function ocultarDes() {
    if($("body").hasClass('sidenav-toggled')){ 
      document.getElementById("des-usuario").style.display = "block";
      
    }
   else{
    document.getElementById("des-usuario").style.display = "none";
   }
  }
*/
  function ocultarDes() {
    if($("body").hasClass('sidenav-toggled')){ 
      document.getElementById("des-usuario").style.display = "block";
      $("section").removeClass("is-expanded");
    }
   else{
    document.getElementById("des-usuario").style.display = "none";
    $("section").removeClass("is-expanded");
   }
  }