<?php $this->load->view('header'); ?>
<?php $this->load->view('nav'); ?>

<style>

    #familia_tabla{
           overflow-x: hidden;
    }
    .guiones{
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 2px dashed #4d4b4d;
    }

    .guiones2{
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 1px dashed #4d4b4d;
        
    }

    .fa-plus-circle:before{
        color: #28a745;
    }

input.archivoInput[type="file"]{
    display: none;
}

label.archivoInput2{
    color:white;
    background-image: url('template/assets/img/descarga_img.png');
    background-repeat: no-repeat;
    background-size: 40px 30px;
    background-position: center;
    position:absolute;
    margin: 25px;
    padding-bottom: 25px;
    top:0;
    bottom:0;
    left: 0;
    right:0;
}


label.archivoInput3{
    color:white;
    background-image: url('template/assets/img/descarga_img.png');
    background-repeat: no-repeat;
    background-size: 30px 20px;
    background-position: center;
    position:absolute;
    margin: 25px;
    padding-bottom: 38px;
    top:0;
    bottom:0;
    left: 0;
    right:0;
}

label.texto {
  width: 214px;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}


    </style>

    <div id="content" class="main-content">
            <div class="layout-px-spacing">                
                    
                <div class="account-settings-container layout-top-spacing">

                    <div class="account-content">
                        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Datos Personales</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                                            <div class="upload mt-4 pr-md-4">
                                                                <input type="file" id="foto" class="dropify" data-default-file="<?php echo base_url(); ?>template/assets/img/200x200.jpg" data-max-file-size="2M" />
                                                                <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Actualizar Imagen</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="usuario_apater">Apellido Paterno</label>
                                                                            <input type="text" class="form-control mb-4" id="usuario_apater" placeholder="" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="usuario_amater">Apellido Materno</label>
                                                                            <input type="text" class="form-control mb-4" id="usuario_amater" placeholder="" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="usuario_nombres">Nombres</label>
                                                                            <input type="text" class="form-control mb-4" id="usuario_nombres" placeholder="" value="">
                                                                        </div>
                                                                    </div>
                                                                    <!---->
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="nacionalidad">Nacionalidad</label>
                                                                            <select class="form-control" id="nacionalidad">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!---->
                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="fullName">Tipo de documento</label>
                                                                            <select class="form-control" id="fullName">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="num_doc">Número de documento</label>
                                                                            <input type="text" class="form-control mb-4" id="num_doc" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="genero">Genero</label>
                                                                            <select class="form-control" id="genero">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <label class="dob-input">Fecha de Nacimiento</label>
                                                                        <div class="d-sm-flex d-block">
                                                                            <div class="form-group mr-1">
                                                                                <select class="form-control" id="dia_n_user">
                                                                                  <option selected>Día</option>
                                                                                  <option>1</option>
                                                                                  <option>2</option>
                                                                                  <option>3</option>
                                                                                  <option>4</option>
                                                                                  <option>5</option>
                                                                                  <option>6</option>
                                                                                  <option>7</option>
                                                                                  <option>8</option>
                                                                                  <option>9</option>
                                                                                  <option>10</option>
                                                                                  <option>11</option>
                                                                                  <option>12</option>
                                                                                  <option>13</option>
                                                                                  <option>14</option>
                                                                                  <option>15</option>
                                                                                  <option>16</option>
                                                                                  <option>17</option>
                                                                                  <option>18</option>
                                                                                  <option>19</option>
                                                                                  <option>20</option>
                                                                                  <option>21</option>
                                                                                  <option>22</option>
                                                                                  <option>23</option>
                                                                                  <option>24</option>
                                                                                  <option>25</option>
                                                                                  <option>26</option>
                                                                                  <option>27</option>
                                                                                  <option>28</option>
                                                                                  <option>29</option>
                                                                                  <option>30</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mr-1">
                                                                                <select class="form-control" id="mes_n_user">
                                                                                    <option selected>Mes</option>
                                                                                    <option>Jan</option>
                                                                                    <option>Feb</option>
                                                                                    <option>Mar</option>
                                                                                    <option>Apr</option>
                                                                                    <option>May</option>
                                                                                    <option>Jun</option>
                                                                                    <option>Jul</option>
                                                                                    <option>Aug</option>
                                                                                    <option>Sep</option>
                                                                                    <option>Oct</option>
                                                                                    <option>Nov</option>
                                                                                    <option>Dec</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mr-1">
                                                                                <select class="form-control" id="anio_n_user">
                                                                                  <option selected>Año</option>
                                                                                  <option>2018</option>
                                                                                  <option>2017</option>
                                                                                  <option>2016</option>
                                                                                  <option>2015</option>
                                                                                  <option>2014</option>
                                                                                  <option>2013</option>
                                                                                  <option>2012</option>
                                                                                  <option>2011</option>
                                                                                  <option>2010</option>
                                                                                  <option>2009</option>
                                                                                  <option>2008</option>
                                                                                  <option>2007</option>
                                                                                  <option>2006</option>
                                                                                  <option>2005</option>
                                                                                  <option>2004</option>
                                                                                  <option>2003</option>
                                                                                  <option>2002</option>
                                                                                  <option>2001</option>
                                                                                  <option>2000</option>
                                                                                  <option>1999</option>
                                                                                  <option>1998</option>
                                                                                  <option>1997</option>
                                                                                  <option>1996</option>
                                                                                  <option>1995</option>
                                                                                  <option>1994</option>
                                                                                  <option>1993</option>
                                                                                  <option>1992</option>
                                                                                  <option>1991</option>
                                                                                  <option>1990</option>
                                                                                  <option>1989</option>
                                                                                  <option>1988</option>
                                                                                  <option>1987</option>
                                                                                  <option>1986</option>
                                                                                  <option>1985</option>
                                                                                  <option>1984</option>
                                                                                  <option>1983</option>
                                                                                  <option>1982</option>
                                                                                  <option>1981</option>
                                                                                  <option>1980</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-sm-3">
                                                                        <div class="form-group">
                                                                            <label for="estado_civil">Estado Civil</label>
                                                                            <select class="form-control" id="estado_civil">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="usuario_email">Correo Electrónico</label>
                                                                            <input type="text" class="form-control mb-4" id="usuario_email" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="num_celp">Número celular</label>
                                                                            <input type="text" class="form-control mb-4" id="num_celp" placeholder="" value="">
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="num_fijop">Teléfono fijo</label>
                                                                            <input type="text" class="form-control mb-4" id="num_fijop" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Domicilio</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="id_departamento">Departamento</label>
                                                                            <select class="form-control" id="id_departamento">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!---->
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="id_provincia">Provincia</label>
                                                                            <select class="form-control" id="id_provincia">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="id_distrito">Distrito</label>
                                                                            <select class="form-control" id="id_distrito">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="nom_via">Nombre de vía</label>
                                                                            <input type="text" class="form-control mb-4" id="nom_via" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="tipo_via">Tipo de vía</label>
                                                                            <input type="text" class="form-control mb-4" id="tipo_via" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="nro_via">Número de vía</label>
                                                                            <input type="text" class="form-control mb-4" id="nro_via" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="dpto_piso_int">Dpto/Piso/Interior</label>
                                                                            <input type="text" class="form-control mb-4" id="dpto_piso_int" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-8">
                                                                        <div class="form-group">
                                                                            <label for="refer_domicili">Referencia Domicilio</label>
                                                                            <input type="text" class="form-control mb-4" id="refer_domicili" placeholder="" value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label for="tipovivienda">Tipo de vivienda</label>
                                                                            <select class="form-control" id="tipovivienda">
                                                                                <option selected>Seleccione</option>
                                                                                <option>United States</option>
                                                                                <option>India</option>
                                                                                <option>Japan</option>
                                                                                <option>China</option>
                                                                                <option>Brazil</option>
                                                                                <option>Norway</option>
                                                                                <option>Canada</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-8">
                                                                        <div class="form-group">
                                                                            <label for="ubicacion">Ubicación de tu vivienda</label>
                                                                            <br>
                                                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15620.294248385673!2d-77.0679477!3d-11.83012175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc584ac5748762af!2sPUPIXO%203D!5e0!3m2!1ses-419!2spe!4v1599523734499!5m2!1ses-419!2spe" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>                                                                        </div>
                                                                    </div>-->
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Referencias Familiares</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar Familiar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nom_familiar">Nombre de Familiar</label>
                                                                                                            <input type="text" class="form-control mb-4" id="nom_familiar" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nom_familiar">Parentesco</label>
                                                                                                            <input type="text" class="form-control mb-4" id="nom_familiar" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="naci_familiar">Fecha de Nacimiento</label>
                                                                                                        <div class="d-sm-flex d-block">
                                                                                                            <div class="form-group mr-2">
                                                                                                                <select class="form-control" id="naci_familiar">
                                                                                                                <option selected>Día</option>
                                                                                                                <option>1</option>
                                                                                                                <option>2</option>
                                                                                                                <option>3</option>
                                                                                                                <option>4</option>
                                                                                                                <option>5</option>
                                                                                                                <option>6</option>
                                                                                                                <option>7</option>
                                                                                                                <option>8</option>
                                                                                                                <option>9</option>
                                                                                                                <option>10</option>
                                                                                                                <option>11</option>
                                                                                                                <option>12</option>
                                                                                                                <option>13</option>
                                                                                                                <option>14</option>
                                                                                                                <option>15</option>
                                                                                                                <option>16</option>
                                                                                                                <option>17</option>
                                                                                                                <option>18</option>
                                                                                                                <option>19</option>
                                                                                                                <option>20</option>
                                                                                                                <option>21</option>
                                                                                                                <option>22</option>
                                                                                                                <option>23</option>
                                                                                                                <option>24</option>
                                                                                                                <option>25</option>
                                                                                                                <option>26</option>
                                                                                                                <option>27</option>
                                                                                                                <option>28</option>
                                                                                                                <option>29</option>
                                                                                                                <option>30</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-2">
                                                                                                                <select class="form-control" id="mes_n_familiar">
                                                                                                                    <option selected>Mes</option>
                                                                                                                    <option>Jan</option>
                                                                                                                    <option>Feb</option>
                                                                                                                    <option>Mar</option>
                                                                                                                    <option>Apr</option>
                                                                                                                    <option>May</option>
                                                                                                                    <option>Jun</option>
                                                                                                                    <option>Jul</option>
                                                                                                                    <option>Aug</option>
                                                                                                                    <option>Sep</option>
                                                                                                                    <option>Oct</option>
                                                                                                                    <option>Nov</option>
                                                                                                                    <option>Dec</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-2">
                                                                                                                <select class="form-control" id="anio_n_familiar">
                                                                                                                <option selected>Año</option>
                                                                                                                <option>2018</option>
                                                                                                                <option>2017</option>
                                                                                                                <option>2016</option>
                                                                                                                <option>2015</option>
                                                                                                                <option>2014</option>
                                                                                                                <option>2013</option>
                                                                                                                <option>2012</option>
                                                                                                                <option>2011</option>
                                                                                                                <option>2010</option>
                                                                                                                <option>2009</option>
                                                                                                                <option>2008</option>
                                                                                                                <option>2007</option>
                                                                                                                <option>2006</option>
                                                                                                                <option>2005</option>
                                                                                                                <option>2004</option>
                                                                                                                <option>2003</option>
                                                                                                                <option>2002</option>
                                                                                                                <option>2001</option>
                                                                                                                <option>2000</option>
                                                                                                                <option>1999</option>
                                                                                                                <option>1998</option>
                                                                                                                <option>1997</option>
                                                                                                                <option>1996</option>
                                                                                                                <option>1995</option>
                                                                                                                <option>1994</option>
                                                                                                                <option>1993</option>
                                                                                                                <option>1992</option>
                                                                                                                <option>1991</option>
                                                                                                                <option>1990</option>
                                                                                                                <option>1989</option>
                                                                                                                <option>1988</option>
                                                                                                                <option>1987</option>
                                                                                                                <option>1986</option>
                                                                                                                <option>1985</option>
                                                                                                                <option>1984</option>
                                                                                                                <option>1983</option>
                                                                                                                <option>1982</option>
                                                                                                                <option>1981</option>
                                                                                                                <option>1980</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="familiar_celular">Celular</label>
                                                                                                            <input type="text" class="form-control mb-4" id="familiar_celular" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="familiar_celular2">Celular 2</label>
                                                                                                        <input type="text" class="form-control mb-4" id="familiar_celular2" placeholder="" value="">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-sm-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="familiar_telefono2">Teléfono fijo</label>
                                                                                                        <input type="text" class="form-control mb-4" id="familiar_telefono2" placeholder="" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Datos de hijos/as</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar Hijos/as &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>    
                                                                                        <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nom_hijo">Nombre de Hijo</label>
                                                                                                            <input type="text" class="form-control mb-4" id="nom_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="hijo_genero">Genero</label>
                                                                                                            <input type="text" class="form-control mb-4" id="hijo_genero" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="dob-input">Fecha de Nacimiento</label>
                                                                                                        <div class="d-sm-flex d-block">
                                                                                                            <div class="form-group mr-2">
                                                                                                                <select class="form-control" id="dia_n_familiar">
                                                                                                                    <option selected>Día</option>
                                                                                                                    <option>1</option>
                                                                                                                    <option>2</option>
                                                                                                                    <option>3</option>
                                                                                                                    <option>4</option>
                                                                                                                    <option>5</option>
                                                                                                                    <option>6</option>
                                                                                                                    <option>7</option>
                                                                                                                    <option>8</option>
                                                                                                                    <option>9</option>
                                                                                                                    <option>10</option>
                                                                                                                    <option>11</option>
                                                                                                                    <option>12</option>
                                                                                                                    <option>13</option>
                                                                                                                    <option>14</option>
                                                                                                                    <option>15</option>
                                                                                                                    <option>16</option>
                                                                                                                    <option>17</option>
                                                                                                                    <option>18</option>
                                                                                                                    <option>19</option>
                                                                                                                    <option>20</option>
                                                                                                                    <option>21</option>
                                                                                                                    <option>22</option>
                                                                                                                    <option>23</option>
                                                                                                                    <option>24</option>
                                                                                                                    <option>25</option>
                                                                                                                    <option>26</option>
                                                                                                                    <option>27</option>
                                                                                                                    <option>28</option>
                                                                                                                    <option>29</option>
                                                                                                                    <option>30</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-2">
                                                                                                                <select class="form-control" id="mes_n_user">
                                                                                                                    <option selected>Mes</option>
                                                                                                                    <option>Jan</option>
                                                                                                                    <option>Feb</option>
                                                                                                                    <option>Mar</option>
                                                                                                                    <option>Apr</option>
                                                                                                                    <option>May</option>
                                                                                                                    <option>Jun</option>
                                                                                                                    <option>Jul</option>
                                                                                                                    <option>Aug</option>
                                                                                                                    <option>Sep</option>
                                                                                                                    <option>Oct</option>
                                                                                                                    <option>Nov</option>
                                                                                                                    <option>Dec</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-2">
                                                                                                                <select class="form-control" id="anio_n_user">
                                                                                                                    <option selected>Año</option>
                                                                                                                    <option>2018</option>
                                                                                                                    <option>2017</option>
                                                                                                                    <option>2016</option>
                                                                                                                    <option>2015</option>
                                                                                                                    <option>2014</option>
                                                                                                                    <option>2013</option>
                                                                                                                    <option>2012</option>
                                                                                                                    <option>2011</option>
                                                                                                                    <option>2010</option>
                                                                                                                    <option>2009</option>
                                                                                                                    <option>2008</option>
                                                                                                                    <option>2007</option>
                                                                                                                    <option>2006</option>
                                                                                                                    <option>2005</option>
                                                                                                                    <option>2004</option>
                                                                                                                    <option>2003</option>
                                                                                                                    <option>2002</option>
                                                                                                                    <option>2001</option>
                                                                                                                    <option>2000</option>
                                                                                                                    <option>1999</option>
                                                                                                                    <option>1998</option>
                                                                                                                    <option>1997</option>
                                                                                                                    <option>1996</option>
                                                                                                                    <option>1995</option>
                                                                                                                    <option>1994</option>
                                                                                                                    <option>1993</option>
                                                                                                                    <option>1992</option>
                                                                                                                    <option>1991</option>
                                                                                                                    <option>1990</option>
                                                                                                                    <option>1989</option>
                                                                                                                    <option>1988</option>
                                                                                                                    <option>1987</option>
                                                                                                                    <option>1986</option>
                                                                                                                    <option>1985</option>
                                                                                                                    <option>1984</option>
                                                                                                                    <option>1983</option>
                                                                                                                    <option>1982</option>
                                                                                                                    <option>1981</option>
                                                                                                                    <option>1980</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">DNI</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                  

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="hijo_bio_nobio">Biologicos/no bialogico</label>
                                                                                                            <select class="form-control" id="hijo_bio_nobio">
                                                                                                                <option selected>Selección</option>
                                                                                                                <option United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>                                                                                                    
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_img">Adjuntar dni</label>
                                                                                                                <input type="file" id="archivoInput" class="archivoInput nombre"  onchange="return validarExt()" />       
                                                                                                                <label  class=" archivoInput2 guiones2" for="archivoInput">
                                                                                                                </label>
                                                                                                            <div>
                                                                                                            <label  class="texto  filename" for="archivoInput">
                                                                                                            </label>

                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>

                                                                                                    
                                                                                                    
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Contacto de Emergencia</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar Contacto de Emergencia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nom_contacto_emer">Nombre de Contacto</label>
                                                                                                            <input type="text" class="form-control mb-4" id="nom_contacto_emer" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="parentesco_contacto_emer">Parentesco</label>
                                                                                                            <input type="text" class="form-control mb-4" id="parentesco_contacto_emer" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="celular_contacto_emer">Celular</label>
                                                                                                            <input type="text" class="form-control mb-4" id="celular_contacto_emer" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="celular_contacto2_emer">Celular 2</label>
                                                                                                        <input type="text" class="form-control mb-4" id="celular_contacto2_emer" placeholder="" value="">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-sm-4">
                                                                                                    <div class="form-group">
                                                                                                        <label for="telefono2_contacto_emer">Teléfono fijo</label>
                                                                                                        <input type="text" class="form-control mb-4" id="telefono2_contacto_emer" placeholder="" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Estudios Generales</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar Estudios Generales &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Grado de Instrucción</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="parentesco_contacto_emer">Carrera de estudios</label>
                                                                                                            <input type="text" class="form-control mb-4" id="parentesco_contacto_emer" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="celular_contacto_emer">Centro de estudios</label>
                                                                                                            <input type="text" class="form-control mb-4" id="celular_contacto_emer" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Conocimientos de Office</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Nivel de Excel</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Nivel de Word</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Nivel de Power Point</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Conocimientos de Idiomas</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar Idioma &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Idiomal</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Lectura</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Escritura</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-3">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Coversación</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>                              


                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Cursos Complementarios</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar Curso Complemetario &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">DNI</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Año</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_img">Adjuntar Certificado</label>
                                                                                                                <input type="file" id="archivoInput" class="archivoInput nombre"  onchange="return validarExt()" />       
                                                                                                                <label  class=" archivoInput2 guiones2" for="archivoInput">
                                                                                                                </label>
                                                                                                            <div>
                                                                                                            <label  class="texto  filename" for="archivoInput">
                                                                                                            </label>
                                                                                                            </div>
                                                                                                               
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>



                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Experiencia Laboral</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar Experiencia Laboral &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">Empresa</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">Cargo</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>



                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label>Fecha de Inicio</label>

                                                                                                            <div class="row">


                                                                                                                <div class="col-md-4">
                                                                                                                    <select class="form-control mb-4" id="s-from1">
                                                                                                                        <option selected>Día</option>
                                                                                                                        <option>1</option>
                                                                                                                        <option>2</option>
                                                                                                                        <option>3</option>
                                                                                                                        <option>4</option>
                                                                                                                        <option>5</option>
                                                                                                                        <option>6</option>
                                                                                                                        <option>7</option>
                                                                                                                        <option>8</option>
                                                                                                                        <option>9</option>
                                                                                                                        <option>10</option>
                                                                                                                        <option>11</option>
                                                                                                                        <option>12</option>
                                                                                                                        <option>13</option>
                                                                                                                        <option>14</option>
                                                                                                                        <option>15</option>
                                                                                                                        <option>16</option>
                                                                                                                        <option>17</option>
                                                                                                                        <option>18</option>
                                                                                                                        <option>19</option>
                                                                                                                        <option>20</option>
                                                                                                                        <option>21</option>
                                                                                                                        <option>22</option>
                                                                                                                        <option>23</option>
                                                                                                                        <option>24</option>
                                                                                                                        <option>25</option>
                                                                                                                        <option>26</option>
                                                                                                                        <option>27</option>
                                                                                                                        <option>28</option>
                                                                                                                        <option>29</option>
                                                                                                                        <option>30</option>
                                                                                                                    </select>

                                                                                                               
                                                                                                                </div>

                                                                                                                <div class="col-md-4">
                                                                                                                    <select class="form-control mb-4" id="s-from1">
                                                                                                                        <option selected>Mes</option>
                                                                                                                        <option>Jan</option>
                                                                                                                        <option>Feb</option>
                                                                                                                        <option>Mar</option>
                                                                                                                        <option>Apr</option>
                                                                                                                        <option>May</option>
                                                                                                                        <option>Jun</option>
                                                                                                                        <option>Jul</option>
                                                                                                                        <option>Aug</option>
                                                                                                                        <option>Sep</option>
                                                                                                                        <option>Oct</option>
                                                                                                                        <option>Nov</option>
                                                                                                                        <option>Dec</option>
                                                                                                                    </select>
                                                                                                                </div>

                                                                                                                <div class="col-md-4">
                                                                                                                    <select class="form-control mb-4" id="s-from2">
                                                                                                                        <option selected >Año</option>
                                                                                                                        <option>2020</option>
                                                                                                                        <option>2019</option>
                                                                                                                        <option>2018</option>
                                                                                                                        <option>2017</option>
                                                                                                                        <option>2016</option>
                                                                                                                        <option>2015</option>
                                                                                                                        <option>2014</option>
                                                                                                                        <option>2013</option>
                                                                                                                        <option>2012</option>
                                                                                                                        <option>2011</option>
                                                                                                                        <option>2010</option>
                                                                                                                        <option >2009</option>
                                                                                                                        <option>2008</option>
                                                                                                                        <option>2007</option>
                                                                                                                        <option>2006</option>
                                                                                                                        <option>2005</option>
                                                                                                                        <option>2004</option>
                                                                                                                        <option>2003</option>
                                                                                                                        <option>2002</option>
                                                                                                                        <option>2001</option>
                                                                                                                        <option>2000</option>
                                                                                                                        <option>1999</option>
                                                                                                                        <option>1998</option>
                                                                                                                        <option>1997</option>
                                                                                                                        <option>1996</option>
                                                                                                                        <option>1995</option>
                                                                                                                        <option>1994</option>
                                                                                                                        <option>1993</option>
                                                                                                                        <option>1992</option>
                                                                                                                        <option>1991</option>
                                                                                                                        <option>1990</option>
                                                                                                                    </select>
                                                                                                                </div>

                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-md-3">
                                                                                                        <div class="form-group">
                                                                                                            <label>Fecha de Fin</label>

                                                                                                            <div class="row">

                                                                                                            
                                                                                                            <div class="col-md-4">
                                                                                                                    <select class="form-control" id="end-in1">
                                                                                                                    <option selected>Día</option>
                                                                                                                        <option>1</option>
                                                                                                                        <option>2</option>
                                                                                                                        <option>3</option>
                                                                                                                        <option>4</option>
                                                                                                                        <option>5</option>
                                                                                                                        <option>6</option>
                                                                                                                        <option>7</option>
                                                                                                                        <option>8</option>
                                                                                                                        <option>9</option>
                                                                                                                        <option>10</option>
                                                                                                                        <option>11</option>
                                                                                                                        <option>12</option>
                                                                                                                        <option>13</option>
                                                                                                                        <option>14</option>
                                                                                                                        <option>15</option>
                                                                                                                        <option>16</option>
                                                                                                                        <option>17</option>
                                                                                                                        <option>18</option>
                                                                                                                        <option>19</option>
                                                                                                                        <option>20</option>
                                                                                                                        <option>21</option>
                                                                                                                        <option>22</option>
                                                                                                                        <option>23</option>
                                                                                                                        <option>24</option>
                                                                                                                        <option>25</option>
                                                                                                                        <option>26</option>
                                                                                                                        <option>27</option>
                                                                                                                        <option>28</option>
                                                                                                                        <option>29</option>
                                                                                                                        <option>30</option>
                                                                                                                    </select>
                                                                                                                </div>

                                                                                                                <div class="col-md-4">
                                                                                                                    <select class="form-control" id="end-in1">
                                                                                                                        <option selected>Mes</option>
                                                                                                                        <option>Jan</option>
                                                                                                                        <option>Feb</option>
                                                                                                                        <option>Mar</option>
                                                                                                                        <option>Apr</option>
                                                                                                                        <option>May</option>
                                                                                                                        <option>Jun</option>
                                                                                                                        <option>Jul</option>
                                                                                                                        <option>Aug</option>
                                                                                                                        <option>Sep</option>
                                                                                                                        <option>Oct</option>
                                                                                                                        <option>Nov</option>
                                                                                                                        <option>Dec</option>
                                                                                                                    </select>
                                                                                                                </div>

                                                                                                                <div class="col-md-4">
                                                                                                                    <select class="form-control input-sm" id="end-in2">
                                                                                                                        <option selected>Año</option>
                                                                                                                        <option>2020</option>
                                                                                                                        <option>2019</option>
                                                                                                                        <option>2018</option>
                                                                                                                        <option>2017</option>
                                                                                                                        <option>2016</option>
                                                                                                                        <option>2015</option>
                                                                                                                        <option>2014</option>
                                                                                                                        <option>2013</option>
                                                                                                                        <option>2012</option>
                                                                                                                        <option>2011</option>
                                                                                                                        <option>2010</option>
                                                                                                                        <option>2009</option>
                                                                                                                        <option>2008</option>
                                                                                                                        <option>2007</option>
                                                                                                                        <option>2006</option>
                                                                                                                        <option>2005</option>
                                                                                                                        <option>2004</option>
                                                                                                                        <option>2003</option>
                                                                                                                        <option>2002</option>
                                                                                                                        <option>2001</option>
                                                                                                                        <option>2000</option>
                                                                                                                        <option>1999</option>
                                                                                                                        <option>1998</option>
                                                                                                                        <option>1997</option>
                                                                                                                        <option>1996</option>
                                                                                                                        <option>1995</option>
                                                                                                                        <option>1994</option>
                                                                                                                        <option>1993</option>
                                                                                                                        <option>1992</option>
                                                                                                                        <option>1991</option>
                                                                                                                        <option>1990</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Motivo de Salida</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">Importe de remuneración</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">Nombre de referencia laboral</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">Número de Contacto de la empresa</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_img">Adjuntar Certificado</label>
                                                                                                                <input type="file" id="archivoInput" class="archivoInput nombre"  onchange="return validarExt()" />       
                                                                                                                <label  class=" archivoInput2 guiones2" for="archivoInput">
                                                                                                                </label>
                                                                                                            <div>
                                                                                                            <label  class="texto  filename" for="archivoInput">
                                                                                                            </label>
                                                                                                            </div>

                                                                                                                
                                                                                                        </div>
                                                                                                    </div>

                                                                                            

                                                                                                 
                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Salud</h6>
                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar otra enfermedad &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Indique si padece alguna enfermedad</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">Especifique la enfermedad</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="dob-input">Fecha de Diagonostico</label>
                                                                                                        <div class="d-sm-flex d-block">
                                                                                                            <div class="form-group mr-1">
                                                                                                                <select class="form-control" id="dia_n_user">
                                                                                                                <option selected>Día</option>
                                                                                                                <option>1</option>
                                                                                                                <option>2</option>
                                                                                                                <option>3</option>
                                                                                                                <option>4</option>
                                                                                                                <option>5</option>
                                                                                                                <option>6</option>
                                                                                                                <option>7</option>
                                                                                                                <option>8</option>
                                                                                                                <option>9</option>
                                                                                                                <option>10</option>
                                                                                                                <option>11</option>
                                                                                                                <option>12</option>
                                                                                                                <option>13</option>
                                                                                                                <option>14</option>
                                                                                                                <option>15</option>
                                                                                                                <option>16</option>
                                                                                                                <option>17</option>
                                                                                                                <option>18</option>
                                                                                                                <option>19</option>
                                                                                                                <option>20</option>
                                                                                                                <option>21</option>
                                                                                                                <option>22</option>
                                                                                                                <option>23</option>
                                                                                                                <option>24</option>
                                                                                                                <option>25</option>
                                                                                                                <option>26</option>
                                                                                                                <option>27</option>
                                                                                                                <option>28</option>
                                                                                                                <option>29</option>
                                                                                                                <option>30</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-1">
                                                                                                                <select class="form-control" id="mes_n_user">
                                                                                                                    <option selected>Mes</option>
                                                                                                                    <option>Jan</option>
                                                                                                                    <option>Feb</option>
                                                                                                                    <option>Mar</option>
                                                                                                                    <option>Apr</option>
                                                                                                                    <option>May</option>
                                                                                                                    <option>Jun</option>
                                                                                                                    <option>Jul</option>
                                                                                                                    <option>Aug</option>
                                                                                                                    <option>Sep</option>
                                                                                                                    <option>Oct</option>
                                                                                                                    <option>Nov</option>
                                                                                                                    <option>Dec</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-1">
                                                                                                                <select class="form-control" id="anio_n_user">
                                                                                                                <option selected>Año</option>
                                                                                                                <option>2018</option>
                                                                                                                <option>2017</option>
                                                                                                                <option>2016</option>
                                                                                                                <option>2015</option>
                                                                                                                <option>2014</option>
                                                                                                                <option>2013</option>
                                                                                                                <option>2012</option>
                                                                                                                <option>2011</option>
                                                                                                                <option>2010</option>
                                                                                                                <option>2009</option>
                                                                                                                <option>2008</option>
                                                                                                                <option>2007</option>
                                                                                                                <option>2006</option>
                                                                                                                <option>2005</option>
                                                                                                                <option>2004</option>
                                                                                                                <option>2003</option>
                                                                                                                <option>2002</option>
                                                                                                                <option>2001</option>
                                                                                                                <option>2000</option>
                                                                                                                <option>1999</option>
                                                                                                                <option>1998</option>
                                                                                                                <option>1997</option>
                                                                                                                <option>1996</option>
                                                                                                                <option>1995</option>
                                                                                                                <option>1994</option>
                                                                                                                <option>1993</option>
                                                                                                                <option>1992</option>
                                                                                                                <option>1991</option>
                                                                                                                <option>1990</option>
                                                                                                                <option>1989</option>
                                                                                                                <option>1988</option>
                                                                                                                <option>1987</option>
                                                                                                                <option>1986</option>
                                                                                                                <option>1985</option>
                                                                                                                <option>1984</option>
                                                                                                                <option>1983</option>
                                                                                                                <option>1982</option>
                                                                                                                <option>1981</option>
                                                                                                                <option>1980</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                
                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Indique si se encuentra en gestación</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    
                                                                                                    <div class="col-sm-6">
                                                                                                        <label class="dob-input">Fecha de incio de gestación</label>
                                                                                                        <div class="d-sm-flex d-block">
                                                                                                            <div class="form-group mr-1">
                                                                                                                <select class="form-control" id="dia_n_user">
                                                                                                                <option selected>Día</option>
                                                                                                                <option>1</option>
                                                                                                                <option>2</option>
                                                                                                                <option>3</option>
                                                                                                                <option>4</option>
                                                                                                                <option>5</option>
                                                                                                                <option>6</option>
                                                                                                                <option>7</option>
                                                                                                                <option>8</option>
                                                                                                                <option>9</option>
                                                                                                                <option>10</option>
                                                                                                                <option>11</option>
                                                                                                                <option>12</option>
                                                                                                                <option>13</option>
                                                                                                                <option>14</option>
                                                                                                                <option>15</option>
                                                                                                                <option>16</option>
                                                                                                                <option>17</option>
                                                                                                                <option>18</option>
                                                                                                                <option>19</option>
                                                                                                                <option>20</option>
                                                                                                                <option>21</option>
                                                                                                                <option>22</option>
                                                                                                                <option>23</option>
                                                                                                                <option>24</option>
                                                                                                                <option>25</option>
                                                                                                                <option>26</option>
                                                                                                                <option>27</option>
                                                                                                                <option>28</option>
                                                                                                                <option>29</option>
                                                                                                                <option>30</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-1">
                                                                                                                <select class="form-control" id="mes_n_user">
                                                                                                                    <option selected>Mes</option>
                                                                                                                    <option>Jan</option>
                                                                                                                    <option>Feb</option>
                                                                                                                    <option>Mar</option>
                                                                                                                    <option>Apr</option>
                                                                                                                    <option>May</option>
                                                                                                                    <option>Jun</option>
                                                                                                                    <option>Jul</option>
                                                                                                                    <option>Aug</option>
                                                                                                                    <option>Sep</option>
                                                                                                                    <option>Oct</option>
                                                                                                                    <option>Nov</option>
                                                                                                                    <option>Dec</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="form-group mr-1">
                                                                                                                <select class="form-control" id="anio_n_user">
                                                                                                                <option selected>Año</option>
                                                                                                                <option>2018</option>
                                                                                                                <option>2017</option>
                                                                                                                <option>2016</option>
                                                                                                                <option>2015</option>
                                                                                                                <option>2014</option>
                                                                                                                <option>2013</option>
                                                                                                                <option>2012</option>
                                                                                                                <option>2011</option>
                                                                                                                <option>2010</option>
                                                                                                                <option>2009</option>
                                                                                                                <option>2008</option>
                                                                                                                <option>2007</option>
                                                                                                                <option>2006</option>
                                                                                                                <option>2005</option>
                                                                                                                <option>2004</option>
                                                                                                                <option>2003</option>
                                                                                                                <option>2002</option>
                                                                                                                <option>2001</option>
                                                                                                                <option>2000</option>
                                                                                                                <option>1999</option>
                                                                                                                <option>1998</option>
                                                                                                                <option>1997</option>
                                                                                                                <option>1996</option>
                                                                                                                <option>1995</option>
                                                                                                                <option>1994</option>
                                                                                                                <option>1993</option>
                                                                                                                <option>1992</option>
                                                                                                                <option>1991</option>
                                                                                                                <option>1990</option>
                                                                                                                <option>1989</option>
                                                                                                                <option>1988</option>
                                                                                                                <option>1987</option>
                                                                                                                <option>1986</option>
                                                                                                                <option>1985</option>
                                                                                                                <option>1984</option>
                                                                                                                <option>1983</option>
                                                                                                                <option>1982</option>
                                                                                                                <option>1981</option>
                                                                                                                <option>1980</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-md-12 text-right mb-5">
                                                    <button id="add-work-platforms" class="btn guiones">Agregar medicamento &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Es alergico a algun medicamento</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_hijo">Indique el nombre de los medicamentos</label>
                                                                                                            <input type="text" class="form-control mb-4" id="dni_hijo" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                

                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>



                                            
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Tipo de sangre</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_img">Adjuntar Prueba COVID</label>
                                                                                                                <input type="file" id="archivoInput" class="archivoInput nombre"  onchange="return validarExt()" />       
                                                                                                                <label  class=" archivoInput2 guiones2" for="archivoInput">
                                                                                                                </label>
                                                                                                            <div>
                                                                                                            <label  class="texto  filename" for="archivoInput">
                                                                                                            </label>
                                                                                                            </div>
                                                                                                               
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    
                                                                                                   
                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>


                                          

                                            
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Referencia de Convocatoria</h6>
                                            <div class="row">
                                                
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Indica ¿Cómo te enteraste del puesto?</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="usuario_email">Especifique otros</label>
                                                                                                            <input type="text" class="form-control mb-4" id="usuario_email" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>


                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Adjuntar Documentación</h6>
                                            <div class="row">
                                                
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_img">Adjuntar curriculum vitae</label>
                                                                                                                <input type="file" id="archivoInput" class="archivoInput nombre"  onchange="return validarExt()" />       
                                                                                                                <label  class=" archivoInput3 guiones2" for="archivoInput">
                                                                                                                </label>
                                                                                                            <div>
                                                                                                            <label  class="texto  filename" for="archivoInput">
                                                                                                            </label>

                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_img">Foto DNI (ambas caras)</label>
                                                                                                                <input type="file" id="archivoInput" class="archivoInput nombre"  onchange="return validarExt()" />       
                                                                                                                <label  class=" archivoInput3 guiones2" for="archivoInput">
                                                                                                                </label>
                                                                                                            <div>
                                                                                                            <label  class="texto  filename" for="archivoInput">
                                                                                                            </label>

                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="dni_img">Copia de recibo de agua y luz</label>
                                                                                                                <input type="file" id="archivoInput" class="archivoInput nombre"  onchange="return validarExt()" />       
                                                                                                                <label  class=" archivoInput3 guiones2" for="archivoInput">
                                                                                                                </label>
                                                                                                            <div>
                                                                                                            <label  class="texto  filename" for="archivoInput">
                                                                                                            </label>

                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </div>


                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Indicar Talla de:</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Polo</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Camisa</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Pantalón</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Zápato</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Sistema Pensionario</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Pertenece a algún sistema pensionario</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Indique el sistema pensionario que desea</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Si indico AFP elija</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form id="general-info" class="section general-info">
                                        <div class="info">
                                            <h6 class="">Número de Cuenta</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="table-responsive" id="familia_tabla">
                                                                        <table class="table table-bordered table-striped mb-4" >
                                                                            <tbody >
                                                                                <tr>
                                                                                    <td>
                                                                                            <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">¿Cuéntas con cuenta bancaria?</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Indique la entidad bancaria</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-4">
                                                                                                        <div class="form-group">
                                                                                                            <label for="nacionalidad">Si indico AFP elija</label>
                                                                                                            <select class="form-control" id="nacionalidad">
                                                                                                                <option selected>Seleccione</option>
                                                                                                                <option>United States</option>
                                                                                                                <option>India</option>
                                                                                                                <option>Japan</option>
                                                                                                                <option>China</option>
                                                                                                                <option>Brazil</option>
                                                                                                                <option>Norway</option>
                                                                                                                <option>Canada</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="usuario_email">Indique el número de cuenta</label>
                                                                                                            <input type="text" class="form-control mb-4" id="usuario_email" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="col-sm-6">
                                                                                                        <div class="form-group">
                                                                                                            <label for="usuario_email">Indique el código interbancario</label>
                                                                                                            <input type="text" class="form-control mb-4" id="usuario_email" placeholder="" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        
                                                                        </table>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            
                            

                        <div class="account-settings-footer">
                            
                            <div class="as-footer-container">

                                <button id="multiple-reset" class="btn btn-warning">reinicar todo</button>
                                <div class="blockui-growl-message">
                                    <i class="flaticon-double-check"></i>&nbsp; Se guardo exitosamente
                                </div>
                                <button id="multiple-messages" class="btn btn-primary">Guardar Cambios</button>

                            </div>

                        </div>
                </div>

            </div>
    </div>



    <script>
        $(function()
        {
            $(".nombre").change(function(event) {
                var x = event.target.files[0].name
                $(".filename").text(x)
            });
        })
    </script>

<?php $this->load->view('footer'); ?>