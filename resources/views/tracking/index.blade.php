@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Tracking</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar d-flex mt-3">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('tracking.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Registrar
                                </button>
                            </div>
                        </div>

                        @csrf
                        <div class="table-responsive mt-4" id="lista_tracking">
                        </div>

                        <!--<table id="example" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td><input type="text" id="row-1-age" class="form-control" name="row-1-age" value="61"></td>
                                    <td><input type="text" id="row-1-position" class="form-control" name="row-1-position" value="System Architect"></td>
                                    <td><select size="1" id="row-1-office" class="form-control" name="row-1-office">
                                        <option value="Edinburgh" selected="selected">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Garrett Winters</td>
                                    <td><input type="text" id="row-2-age" class="form-control" name="row-2-age" value="63"></td>
                                    <td><input type="text" id="row-2-position" class="form-control" name="row-2-position" value="Accountant"></td>
                                    <td><select size="1" id="row-2-office" class="form-control" name="row-2-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo" selected="selected">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Ashton Cox</td>
                                    <td><input type="text" id="row-3-age" class="form-control" name="row-3-age" value="66"></td>
                                    <td><input type="text" id="row-3-position" class="form-control" name="row-3-position" value="Junior Technical Author"></td>
                                    <td><select size="1" id="row-3-office" class="form-control" name="row-3-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco" selected="selected">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Cedric Kelly</td>
                                    <td><input type="text" id="row-4-age" class="form-control" name="row-4-age" value="22"></td>
                                    <td><input type="text" id="row-4-position" class="form-control" name="row-4-position" value="Senior Javascript Developer"></td>
                                    <td><select size="1" id="row-4-office" class="form-control" name="row-4-office">
                                        <option value="Edinburgh" selected="selected">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Airi Satou</td>
                                    <td><input type="text" id="row-5-age" class="form-control" name="row-5-age" value="33"></td>
                                    <td><input type="text" id="row-5-position" class="form-control" name="row-5-position" value="Accountant"></td>
                                    <td><select size="1" id="row-5-office" class="form-control" name="row-5-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo" selected="selected">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Brielle Williamson</td>
                                    <td><input type="text" id="row-6-age" class="form-control" name="row-6-age" value="61"></td>
                                    <td><input type="text" id="row-6-position" class="form-control" name="row-6-position" value="Integration Specialist"></td>
                                    <td><select size="1" id="row-6-office" class="form-control" name="row-6-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York" selected="selected">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Herrod Chandler</td>
                                    <td><input type="text" id="row-7-age" class="form-control" name="row-7-age" value="59"></td>
                                    <td><input type="text" id="row-7-position" class="form-control" name="row-7-position" value="Sales Assistant"></td>
                                    <td><select size="1" id="row-7-office" class="form-control" name="row-7-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco" selected="selected">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Rhona Davidson</td>
                                    <td><input type="text" id="row-8-age" class="form-control" name="row-8-age" value="55"></td>
                                    <td><input type="text" id="row-8-position" class="form-control" name="row-8-position" value="Integration Specialist"></td>
                                    <td><select size="1" id="row-8-office" class="form-control" name="row-8-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo" selected="selected">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Colleen Hurst</td>
                                    <td><input type="text" id="row-9-age" class="form-control" name="row-9-age" value="39"></td>
                                    <td><input type="text" id="row-9-position" class="form-control" name="row-9-position" value="Javascript Developer"></td>
                                    <td><select size="1" id="row-9-office" class="form-control" name="row-9-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco" selected="selected">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Sonya Frost</td>
                                    <td><input type="text" id="row-10-age" class="form-control" name="row-10-age" value="23"></td>
                                    <td><input type="text" id="row-10-position" class="form-control" name="row-10-position" value="Software Engineer"></td>
                                    <td><select size="1" id="row-10-office" class="form-control" name="row-10-office">
                                        <option value="Edinburgh" selected="selected">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Jena Gaines</td>
                                    <td><input type="text" id="row-11-age" class="form-control" name="row-11-age" value="30"></td>
                                    <td><input type="text" id="row-11-position" class="form-control" name="row-11-position" value="Office Manager"></td>
                                    <td><select size="1" id="row-11-office" class="form-control" name="row-11-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London" selected="selected">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Quinn Flynn</td>
                                    <td><input type="text" id="row-12-age" class="form-control" name="row-12-age" value="22"></td>
                                    <td><input type="text" id="row-12-position" class="form-control" name="row-12-position" value="Support Lead"></td>
                                    <td><select size="1" id="row-12-office" class="form-control" name="row-12-office">
                                        <option value="Edinburgh" selected="selected">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Charde Marshall</td>
                                    <td><input type="text" id="row-13-age" class="form-control" name="row-13-age" value="36"></td>
                                    <td><input type="text" id="row-13-position" class="form-control" name="row-13-position" value="Regional Director"></td>
                                    <td><select size="1" id="row-13-office" class="form-control" name="row-13-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco" selected="selected">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Haley Kennedy</td>
                                    <td><input type="text" id="row-14-age" class="form-control" name="row-14-age" value="43"></td>
                                    <td><input type="text" id="row-14-position" class="form-control" name="row-14-position" value="Senior Marketing Designer"></td>
                                    <td><select size="1" id="row-14-office" class="form-control" name="row-14-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London" selected="selected">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Tatyana Fitzpatrick</td>
                                    <td><input type="text" id="row-15-age" class="form-control" name="row-15-age" value="19"></td>
                                    <td><input type="text" id="row-15-position" class="form-control" name="row-15-position" value="Regional Director"></td>
                                    <td><select size="1" id="row-15-office" class="form-control" name="row-15-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London" selected="selected">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Michael Silva</td>
                                    <td><input type="text" id="row-16-age" class="form-control" name="row-16-age" value="66"></td>
                                    <td><input type="text" id="row-16-position" class="form-control" name="row-16-position" value="Marketing Designer"></td>
                                    <td><select size="1" id="row-16-office" class="form-control" name="row-16-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London" selected="selected">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Paul Byrd</td>
                                    <td><input type="text" id="row-17-age" class="form-control" name="row-17-age" value="64"></td>
                                    <td><input type="text" id="row-17-position" class="form-control" name="row-17-position" value="Chief Financial Officer (CFO)"></td>
                                    <td><select size="1" id="row-17-office" class="form-control" name="row-17-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York" selected="selected">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Gloria Little</td>
                                    <td><input type="text" id="row-18-age" class="form-control" name="row-18-age" value="59"></td>
                                    <td><input type="text" id="row-18-position" class="form-control" name="row-18-position" value="Systems Administrator"></td>
                                    <td><select size="1" id="row-18-office" class="form-control" name="row-18-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York" selected="selected">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Bradley Greer</td>
                                    <td><input type="text" id="row-19-age" class="form-control" name="row-19-age" value="41"></td>
                                    <td><input type="text" id="row-19-position" class="form-control" name="row-19-position" value="Software Engineer"></td>
                                    <td><select size="1" id="row-19-office" class="form-control" name="row-19-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London" selected="selected">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Dai Rios</td>
                                    <td><input type="text" id="row-20-age" class="form-control" name="row-20-age" value="35"></td>
                                    <td><input type="text" id="row-20-position" class="form-control" name="row-20-position" value="Personnel Lead"></td>
                                    <td><select size="1" id="row-20-office" class="form-control" name="row-20-office">
                                        <option value="Edinburgh" selected="selected">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Jenette Caldwell</td>
                                    <td><input type="text" id="row-21-age" class="form-control" name="row-21-age" value="30"></td>
                                    <td><input type="text" id="row-21-position" class="form-control" name="row-21-position" value="Development Lead"></td>
                                    <td><select size="1" id="row-21-office" class="form-control" name="row-21-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York" selected="selected">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Yuri Berry</td>
                                    <td><input type="text" id="row-22-age" class="form-control" name="row-22-age" value="40"></td>
                                    <td><input type="text" id="row-22-position" class="form-control" name="row-22-position" value="Chief Marketing Officer (CMO)"></td>
                                    <td><select size="1" id="row-22-office" class="form-control" name="row-22-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York" selected="selected">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Caesar Vance</td>
                                    <td><input type="text" id="row-23-age" class="form-control" name="row-23-age" value="21"></td>
                                    <td><input type="text" id="row-23-position" class="form-control" name="row-23-position" value="Pre-Sales Support"></td>
                                    <td><select size="1" id="row-23-office" class="form-control" name="row-23-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York" selected="selected">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Doris Wilder</td>
                                    <td><input type="text" id="row-24-age" class="form-control" name="row-24-age" value="23"></td>
                                    <td><input type="text" id="row-24-position" class="form-control" name="row-24-position" value="Sales Assistant"></td>
                                    <td><select size="1" id="row-24-office" class="form-control" name="row-24-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Angelica Ramos</td>
                                    <td><input type="text" id="row-25-age" class="form-control" name="row-25-age" value="47"></td>
                                    <td><input type="text" id="row-25-position" class="form-control" name="row-25-position" value="Chief Executive Officer (CEO)"></td>
                                    <td><select size="1" id="row-25-office" class="form-control" name="row-25-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London" selected="selected">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Gavin Joyce</td>
                                    <td><input type="text" id="row-26-age" class="form-control" name="row-26-age" value="42"></td>
                                    <td><input type="text" id="row-26-position" class="form-control" name="row-26-position" value="Developer"></td>
                                    <td><select size="1" id="row-26-office" class="form-control" name="row-26-office">
                                        <option value="Edinburgh" selected="selected">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Jennifer Chang</td>
                                    <td><input type="text" id="row-27-age" class="form-control" name="row-27-age" value="28"></td>
                                    <td><input type="text" id="row-27-position" class="form-control" name="row-27-position" value="Regional Director"></td>
                                    <td><select size="1" id="row-27-office" class="form-control" name="row-27-office">
                                        <option value="Edinburgh">
                                            Edinburgh
                                        </option>
                                        <option value="London">
                                            London
                                        </option>
                                        <option value="New York">
                                            New York
                                        </option>
                                        <option value="San Francisco">
                                            San Francisco
                                        </option>
                                        <option value="Tokyo">
                                            Tokyo
                                        </option>
                                    </select></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                </tr>
                            </tfoot>
                        </table>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#li_trackings").addClass('active');
            $("#a_trackings").attr('aria-expanded','true');

            Lista_Tracking();  
        });

        function Lista_Tracking(){
            Cargando();

            var url = "{{ route('tracking.list') }}";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success:function (resp) {
                    $('#lista_tracking').html(resp);  
                }
            });
        }

        function soloNumeros(e) {
            var key = e.keyCode || e.which,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = "0123456789",
            especiales = [8, 37, 39, 46],
            tecla_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }
        }
    </script>
@endsection