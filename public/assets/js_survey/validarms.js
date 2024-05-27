/*
function validate1(val) {
    v1 = document.getElementById("usuario_nombres");
    v2 = document.getElementById("num_doc");
    v3 = document.getElementById("id_area");

    flag1 = true;
    flag2 = true;
    flag3 = true;

    if(val>=1 || val==0) {
        if(v1.value == "") {
        v1.style.borderColor = "red";
        flag1 = false;
        }
        else {
        v1.style.borderColor = "green";
        flag1 = true;
        }
    }

    if(val>=2 || val==0) {
        if(v2.value == "") {
        v2.style.borderColor = "red";
        flag2 = false;
        }
        else {
        v2.style.borderColor = "green";
        flag2 = true;
        }
    }

    if(val>=3 || val==0) {
        if(v3.value == "") {
        v3.style.borderColor = "red";
        flag3 = false;
        }
        else {
        v3.style.borderColor = "green";
        flag3 = true;
        }
    }






    flag = flag1 && flag2 && flag3;
    return flag;
}
*/

//------------------------------------------------------------



function validate2(val) {
    //v1 = document.getElementById("apepater");
    v14 = document.getElementById("select_resp_uno");
    v15 = document.getElementById("select_resp_dos");
    v16 = document.getElementById("select_resp_tres_1");
    v17 = $('input[name="respuesta_opcion13"]:checked');
    v18 = $('input[name="respuesta_opcion14"]:checked');
    v19 = $('input[name="respuesta_opcion15"]:checked');
    v20 = $('input[name="respuesta_opcion16"]:checked');
    v21 = $('input[name="respuesta_opcion17"]:checked');
    v22 = $('input[name="respuesta_opcion18"]:checked');
    //input check
    v23 = $('input[name="respuesta_opcion19"]:checked');
    v24 = $('input[name="respuesta_opcion20"]:checked');
    v25 = $('input[name="respuesta_opcion21"]:checked');
    v26 = $('input[name="respuesta_opcion22"]:checked');
    v27 = $('input[name="respuesta_opcion23"]:checked');
    v28 = $('input[name="respuesta_opcion24"]:checked');
    v29 = document.getElementById("resp_uno");
    v30 = document.getElementById("resp_dos");
    v31 = document.getElementById("resp_tres");
    v32 = document.getElementById("resp_cuatro");
    v33 = document.getElementById("resp_cinco");


    flag14 = true;
    flag15 = true;
    flag16 = true;
    flag17 = true;
    flag18 = true;
    flag19 = true;
    flag20 = true;
    flag21 = true;
    flag22 = true;
    flag23 = true;
    flag24 = true;
    flag25 = true;
    flag26 = true;
    flag27 = true;
    flag28 = true;
    flag29 = true;
    flag30 = true;
    flag31 = true;
    flag32 = true;
    flag33 = true;

/**************************************************** */
    if(val>=14 || val==0) {
        
        if(v14.value  == "") {
            //v14.style.borderColor = "red";
            $('.select_resp_uno .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid red");
            flag14 = false;
        }
        else {
            //v14.style.borderColor = "green";
            $('.select_resp_uno .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid green");
            flag14 = true;
        }
    }

    if(val>=15 || val==0) {
        if(v15.value  == "") {
            //v15.style.borderColor = "red";
            $('.select_resp_dos .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid red");
            flag17 = false;
        }
        else {
            //v15.style.borderColor = "green";
            $('.select_resp_dos .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid green");
            flag17 = true;
        }
    }

    if(val>=16 || val==0) {
        if(v16.value  == "") {
            //v16.style.borderColor = "red";
            $('.select_resp_tres .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid red");
            flag16 = false;
        }
        else {
            //v16.style.borderColor = "green";
            $('.select_resp_tres .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid green");
            flag16 = true;
        }
    }

    if(val>=17 || val==0) {
        if(v17.length == 0) {
            $('.validafiladoce').css("border","1px solid red");
            flag17 = false;
        }
        else {
            $('.validafiladoce').css("border","1px solid green");
            flag17 = true;
        }
    }

    if(val>=18 || val==0) {
        if(v18.length == 0) {
            $('.validafilatrece').css("border","1px solid red");
            flag18 = false;
        }
        else {
            $('.validafilatrece').css("border","1px solid green");
            flag18 = true;
        }
    }

    if(val>=19 || val==0) {
        if(v19.length == 0) {
            $('.validafilacatorce').css("border","1px solid red");
            flag19 = false;
        }
        else {
            $('.validafilacatorce').css("border","1px solid green");
            flag19 = true;
        }
    }

    if(val>=20 || val==0) {
        if(v20.length == 0) {
            $('.validafilaquince').css("border","1px solid red");
            flag20 = false;
        }
        else {
            $('.validafilaquince').css("border","1px solid green");
            flag20 = true;
        }
    }

    if(val>=21 || val==0) {
        if(v21.length == 0) {
            $('.validafiladieciseis').css("border","1px solid red");
            flag21 = false;
        }
        else {
            $('.validafiladieciseis').css("border","1px solid green");
            flag21 = true;
        }
    }

    
    if(val>=22 || val==0) {
        if(v22.length == 0) {
            $('.validafiladiecisiete').css("border","1px solid red");
            flag22 = false;
        }
        else {
            $('.validafiladiecisiete').css("border","1px solid green");
            flag22 = true;
        }
    }

    
    /*if(val>=23 || val==0) {
        if(v23!=1){

            if(val>=24 || val==0) {
                if(v24.length == 0) {
                    $('.validafiladieciocho').css("border","1px solid red");
                    //flag24 = false;
                }
                else {
                    $('.validafiladieciocho').css("border","1px solid green");
                }
            }
            flag24 = true;
        }    
    }*/

    if(val>=23 || val==0) {
        if(v23.length == 0) {
            $('.validafiladieciocho').css("border","1px solid red");
            flag23 = false;
        }
        else {
            $('.validafiladieciocho').css("border","1px solid green");
            flag23 = true;
        }
    }
    
    if(val>=24 || val==0) {
        if(v24.length == 0) {
            $('.validafiladiecinueve').css("border","1px solid red");
            flag24 = false;
        }
        else {
            $('.validafiladiecinueve').css("border","1px solid green");
            flag24 = true;
        }
    }

    if(val>=25 || val==0) {
        if(v25.length == 0) {
            $('.validafilaveinte').css("border","1px solid red");
            flag25 = false;
        }
        else {
            $('.validafilaveinte').css("border","1px solid green");
            flag25 = true;
        }
    }

    if(val>=26 || val==0) {
        if(v26.length == 0) {
            $('.validafilaveintiuno').css("border","1px solid red");
            flag26 = false;
        }
        else {
            $('.validafilaveintiuno').css("border","1px solid green");
            flag26 = true;
        }
    }

    if(val>=27 || val==0) {
        if(v27.length == 0) {
            $('.validafilaveintidos').css("border","1px solid red");
            flag27 = false;
        }
        else {
            $('.validafilaveintidos').css("border","1px solid green");
            flag27 = true;
        }
    }

    if(val>=28 || val==0) {
        if(v28.length == 0) {
            $('.validafilaveintitres').css("border","1px solid red");
            flag28 = false;
        }
        else {
            $('.validafilaveintitres').css("border","1px solid green");
            flag28 = true;
        }
    }


    if(val>=29 || val==0) {
        if(v29.value == "") {
        v29.style.borderColor = "red";
        flag29 = false;
        }
        else {
        v29.style.borderColor = "green";
        flag29 = true;
        }
    }

    if(val>=30 || val==0) {
        if(v30.value == "") {
        //v30.style.borderColor = "red";
        //$('.resp_dos .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid red");
        //console.log($('.select2-selection.select2-selection--single').parents().parents().find('#resp_dos').text());
        $('.resp_dos .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid red");
        flag30 = false;
        }
        else{
        //v30.style.borderColor = "green";
        //$('.resp_dos .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid green");
        //$('.resp_dos').css("border","1px solid green");
        $('.resp_dos .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid green");
        flag30 = true;
        }
    }

    if(val>=31 || val==0) {
        if(v31.value == "") {
        v31.style.borderColor = "red";
        flag31 = false;
        }
        else {
        v31.style.borderColor = "green";
        flag31 = true;
        }
    }

    if(val>=32 || val==0) {
        if(v32.value == "") {
        //v32.style.borderColor = "red";
        $('.resp_cuatro .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid red");
        flag32 = false;
        }
        else {
        //v32.style.borderColor = "green";
        $('.resp_cuatro .select2.select2-container.mb-4.select2-container--default .selection .select2-selection.select2-selection--single').css("border","1px solid green");
        flag32 = true;
        }
    }

    if(val>=33 || val==0) {
        if(v33.value == "") {
        v33.style.borderColor = "red";
        flag33 = false;
        }
        else {
        v33.style.borderColor = "green";

        flag33 = true;
        }
    }

    flag =flag14 && flag15 &&flag16 && flag17 && flag18 && flag19 && flag20 && flag21
    && flag22 && flag23 && flag24 && flag25 && flag26 && flag27 && flag28
    && flag29 && flag30 && flag31 && flag32 && flag33;

    return flag;
}

//------------------------------------------------------------
