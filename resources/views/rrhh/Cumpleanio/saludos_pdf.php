<!DOCTYPE html>
<html>
<head>
  <title>Álbum de saludos de cumpleaños</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style type="text/css" media="print">

@import url(https://fonts.googleapis.com/css?family=Varela+Round);


*, *:before, *:after {
  box-sizing: border-box;
}

body {
  background-image: url('<?php echo base_url()."assets/especiales/fondo.jpg"; ?>');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  margin: 0;
  padding: 0;
  font-family: "Varela Round", sans-serif;
}

.card {
  background: #fff;
  box-shadow: 0 0 20px rgba(0,0,0,0.4);
  border-radius: 5px;
  margin: 5px 40px 20px 20px;
  width: calc(40%); /* 1/3 minus the margins (20+20) */
  padding: 20px;
  text-align: center;
  color: #515365;
  float: left;
  &:nth-child(2) {
    margin: 20px 0px;
    width: 40%;
    padding: 10px 20px;
    @media (max-width: 768px) {
      margin: 10px 20px;
      width: calc(100% - 40px);
    }
  }
  
  
  .title {
    font-size: 25px;
  }
  
  .features {
    
    ul {
      padding: 0;
      margin: 20px 0 50px 0;
      list-style-type: none;
      text-align:left;
      li {
        margin: 10px 0;
        font-size: 14px;
        
        span {
          border-bottom: 2px dotted #F6B352;
        }
      }
    }
  }
  .btn {
    display: block;
    background: #F6B352;
    color: white;
    padding: 15px 20px;
    margin: 20px 0;
    border-radius: 5px;
    box-shadow: rgba(0,0,0,0.9);
    transition: all 200ms ease-in-out;
    text-decoration: none;
    
  }
}


  </style>
</head>
<body>
  <?php foreach($list_cumpleanio as $list){?> 
    <div class="card">

  <div class="features">
    <p style="color: #515365;text-align:left;
    font-style: italic;
    font-size: 14px;
    letter-spacing: 1px;
    font-weight: 600"><?php echo $list['mensaje'] ?></p>
  </div>
  <h5 style="font-size: 16px;text-align:left;
    color: #3b3f5c;
    letter-spacing: 1px;
    font-weight: 700;
    margin-bottom: 3px;"><b><?php $nombre=explode(" ",$list['nombre_saludado_por']); echo ucfirst(strtolower($nombre[0]))." ".ucfirst(strtolower($list['apellido_saludado_por'])); ?></b></h5>
</div>
  <?php } ?>
  






</body>
</html>
