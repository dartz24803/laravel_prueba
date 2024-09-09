<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('ColaboradorConfController/Modal_Empresa') }}" >
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>
        @csrf
        <div class="table-responsive mb-4 mt-4">
            <table id="zero-configempresa" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>RUC</th>
                        <th>Representante</th>
                        <th>Direccion</th>
                        <th>Activo</th>
                        <th class="no-content"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($list_empresa as $list) {  ?>
                    <tr>
                        <td><?php echo $list['cod_empresa']; ?></td>
                        <td><?php echo $list['nom_empresa']; ?></td>
                        <td><?php echo $list['ruc_empresa']; ?></td>
                        <td><?php echo $list['representante_empresa']; ?></td>
                        <td><?php echo $list['direccion']; ?></td>
                        <td><?php if($list['activo']==1){echo "Si"; }else{echo "No"; } ?></td>
                        <td class="text-center" nowrap>
                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorConfController/Modal_Update_Empresa/' . $list['id_empresa']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>
                            <?php /*if($list['firma']!=""){ ?>
                                <a style="cursor:pointer;display: -webkit-inline-box;" title="Firma" data-toggle="modal" data-target="#MostrarImagen" data-imagen="<?php echo $list['firma']; ?>" >
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533
                                            s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2
                                            s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667
                                            s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733
                                            c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                                    </svg>
                                </a>
                            <?php }*/if($list['firma']!=""){?>
                                <a href="javascript:void(0);" title="Documento" data-toggle="modal" data-target="#Modal_IMG_Link_Normal" data-imagen="<?php echo $url[0]['url_config'].$list["firma"]?>" data-title="Firma">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg>
                                </a>
                            <?php }if($list['logo']!=""){?>
                                <a href="javascript:void(0);" title="Documento" data-toggle="modal" data-target="#Modal_IMG_Link_Normal" data-imagen="<?php echo $url[0]['url_config'].$list["logo"]?>" data-title="Logo">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg>
                                </a>
                            <?php }
                            if($list['pie']!=""){?>
                                <a href="javascript:void(0);" title="Documento" data-toggle="modal" data-target="#Modal_IMG_Link_Normal" data-imagen="<?php echo $url[0]['url_config'].$list["pie"]?>" data-title="Pie de Página">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg>
                                </a>
                            <?php } ?>

                            <a href="#" class="" title="Eliminar" onclick="Delete_Empresa('<?php echo $list['id_empresa']; ?>')" id="delete" role="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>

<script>
    $(document).ready(function() {
        document.title = 'Empresa';
                $('#zero-configempresa').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                responsive: true,
                "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
                "stripeClasses": [],
                "lengthMenu": [10, 20, 50],
                "pageLength": 10
            });
    });
</script>

<div id="MostrarImagen" class="modal animated zoomInUp custo-zoomInUp bd-example-modal-xl" role="dialog" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Firma</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 row">
                    <div class="form-group col-sm-12">
                        <div id="datos_ajax"></div>
                        <input type="hidden" name="rutacarta" id="rutacarta" value="{{ url('/') }}">
                        <div align="center" id="carta"></div>
                        </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#MostrarImagen').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var imagen = button.data('imagen'); // Extraer la información de atributos de datos
        var imagen2 = imagen.substr(-3);
        var rutapdf= $("#rutacarta").val();
        var nombre_archivo= rutapdf+imagen;

        if (imagen!=""){
            if (imagen2=="PDF" || imagen2=="pdf"){
                document.getElementById("carta").innerHTML = "<iframe height='600px' width='100%' src='"+nombre_archivo+"'></iframe>";
            }else{
                document.getElementById("carta").innerHTML = "<img src='"+nombre_archivo+"' height='600px' width='100%'>";
            }
        }else{
            document.getElementById("carta").innerHTML = "No se ha registrado ningún archivo";
        }

        var modal = $(this)
        modal.find('.modal-title').text('Firma')
        $('.alert').hide();//Oculto alert
    })
</script>
