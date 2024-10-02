
<style>
    label.archivoInput10 {
    /* color: white; */
    background-image: url(template/assets/img/descarga_img.png);
    background-repeat: no-repeat;
    background-size: 40px 30px;
    background-position: center;
    position: absolute;
    /* margin: 25px; */
    padding-bottom: 45px;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
</style>
<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Agregar Experiencia Laboral</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Empresa</label>
            </div>            
            <div class="form-group col-sm-4">
                <input type="text" class="form-control" id="id_empresa" name="id_empresa" placeholder="Ingresar Empresa" autofocus>
            </div>


            <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold">Cargo </label>
            </div>            
            <div class="form-group col-sm-4">
                <input type="text" class="form-control" id="id_cargo" name="id_cargo" placeholder="Ingresar Cargo" autofocus>
            </div>


            <div class="form-group col-sm-6">

                <div class="col-md-12">
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

             
                 
            </div>

            <div class="form-group col-sm-6">
                <div class="col-md-12">
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
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Motivo de Salida</label>
            </div>
            <div class="form-group col-sm-4">
                <select class="form-control" id="hijo_bio_nobio">
                    <option selected>Selección</option>
                    <option> United States</option>
                    <option>India</option>
                    <option>Japan</option>
                    <option>China</option>
                    <option>Brazil</option>
                    <option>Norway</option>
                    <option>Canada</option>
                </select>  
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Importe </label>
            </div>            
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" id="import_remune" name="import_remune" placeholder="IngresarImporte de remuneración" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Referencia laboral </label>
            </div>            
            <div class="form-group col-sm-4">
                <input type="text" class="form-control" id="refer_labor" name="refer_labor" placeholder="Ingresar referencia laboral" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Contacto empresa </label>
            </div>            
            <div class="form-group col-sm-4">
                <input type="text" class="form-control" id="refer_labor" name="refer_labor" placeholder="Ingresar N° Contacto de la empresa" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Adjuntar Certificado </label>
            </div>
            <div class="form-group col-sm-4">
                <input type="file" id="archivoInput10" class="archivoInput nombre10"  />       
                <label  class=" archivoInput10 guiones2" for="archivoInput10">
                    <label  class="filename10 texto" >
                    </label> 
                </label>           
             </div>    


            
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Tipo_Documento();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>



<script>
        $(function()
        {

            $(".nombre10").change(function(event) {
                var x = event.target.files[0].name
                $(".filename10").text(x)
            });

            
        })
    </script>