/*
var SessionTimeout=function() {
    var urluno="<?php echo site_url(); ?>Encuesta/Insert_Encuesta_Salida";

    var e=function() {
        $.sessionTimeout( {
            title:"Session Timeout Notification", 
            message:"Your session is about to expire.", 
            keepAliveUrl:"", 
            redirUrl:"auth_lockscreen.html", 
            logoutUrl:"auth_login.html", 
            //warnAfter:6e3, 
            //redirAfter:21e3,
            warnAfter:2000, 
            redirAfter:5000, 
            ignoreUserActivity:!0, 
            countdownMessage:"Redirecting in {timer}.", 
            countdownBar: !0
        }
        )
    };
    return {
        init:function() {
            e()
        }
    }
}


();
*/

/*
jQuery(document).ready(function() {
    SessionTimeout.init()
}
);
*/