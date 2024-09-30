<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="plato_postre">Plato y postre favorito</label>
                <input type="text" class="form-control mb-4" id="plato_postre" name="plato_postre" value="<?php if(isset($get_id_gp['0']['plato_postre'])) {echo $get_id_gp['0']['plato_postre'];}?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="galletas_golosinas">Galletas y golosinas favoritas</label>
                <input type="text" class="form-control mb-4" id="galletas_golosinas" name="galletas_golosinas" value="<?php if(isset($get_id_gp['0']['galletas_golosinas'])) {echo $get_id_gp['0']['galletas_golosinas'];}?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ocio_pasatiempos">Actividades de ocio o pasatiempos</label>
                <input type="text" class="form-control mb-4" id="ocio_pasatiempos" name="ocio_pasatiempos" value="<?php if(isset($get_id_gp['0']['ocio_pasatiempos'])) {echo $get_id_gp['0']['ocio_pasatiempos'];}?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="artistas_banda">Artistas o banda favorito</label>
                <input type="text" class="form-control mb-4" id="artistas_banda" name="artistas_banda" value="<?php if(isset($get_id_gp['0']['artistas_banda'])) {echo $get_id_gp['0']['artistas_banda'];}?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="genero_musical">Género musical favorito</label>
                <input type="text" class="form-control mb-4" id="genero_musical" name="genero_musical" value="<?php if(isset($get_id_gp['0']['genero_musical'])) {echo $get_id_gp['0']['genero_musical'];}?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="pelicula_serie">Película o serie favorita</label>
                <input type="text" class="form-control mb-4" id="pelicula_serie" name="pelicula_serie" value="<?php if(isset($get_id_gp['0']['pelicula_serie'])) {echo $get_id_gp['0']['pelicula_serie'];}?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="colores_favorito">Colores favoritos</label>
                <input type="text" class="form-control mb-4" id="colores_favorito" name="colores_favorito" value="<?php if(isset($get_id_gp['0']['colores_favorito'])) {echo $get_id_gp['0']['colores_favorito'];}?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="redes_sociales">Redes sociales favoritas</label>
                <input type="text" class="form-control mb-4" id="redes_sociales" name="redes_sociales" value="<?php if(isset($get_id_gp['0']['redes_sociales'])) {echo $get_id_gp['0']['redes_sociales'];}?>">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="deporte_favorito">Deporte favorito</label>
                <input type="text" class="form-control mb-4" id="deporte_favorito" name="deporte_favorito" value="<?php if(isset($get_id_gp['0']['deporte_favorito'])) {echo $get_id_gp['0']['deporte_favorito'];}?>">
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="form-group">
                <label for="tiene_mascota">¿Tiene mascota?</label>
                <select class="form-control" name="id_zona" id="id_zona">
                <option value="0" <?php if($get_id_gp[0]['tiene_mascota'] == 0){ echo "selected";} ?>>Seleccione</option>
                <option value="1" <?php if($get_id_gp[0]['tiene_mascota'] == 1){ echo "selected";} ?>>SÍ</option>
                <option value="2" <?php if($get_id_gp[0]['tiene_mascota'] == 2){ echo "selected";} ?>>NO</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="mascota">Qué mascota tienes?</label>
                <input type="text" class="form-control mb-4" id="mascota" name="mascota" value="<?php if(isset($get_id_gp['0']['mascota'])) {echo $get_id_gp['0']['mascota'];}?>">
            </div>
        </div>
    </div>
</div>