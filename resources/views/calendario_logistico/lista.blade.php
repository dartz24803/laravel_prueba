<div id="calendar"></div>

<script>
    $(document).ready(function() {
        // Get the modal
        var modal = document.getElementById("addEventsModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the Add Event button
        var addEvent = document.getElementById("add-e");
        // Get the Edit Event button
        var editEvent = document.getElementById("edit-event");
        // Get the Discard Modal button
        var discardModal = document.getElementById("discard_modal");

        // Get the Add Event button
        var addEventTitle = document.getElementsByClassName("add-event-title")[0];
        // Get the Edit Event button
        var editEventTitle = document.getElementsByClassName("edit-event-title")[0];

        // Get the <span> element that closes the modal
        var span = document.getElementById("close_modal");

        // Get the all <input> elements insdie the modal
        var input = document.querySelectorAll('input[type="text"]');
        var radioInput = document.querySelectorAll('input[type="radio"]');

        // Get the all <textarea> elements insdie the modal
        var textarea = document.getElementsByTagName('textarea');

        // Create BackDrop ( Overlay ) Element
        function createBackdropElement () {
            var btn = document.createElement("div");
            btn.setAttribute('class', 'modal-backdrop fade show')
            document.body.appendChild(btn);
        }

        // Reset radio buttons

        function clearRadioGroup(GroupName) {
        var ele = document.getElementsByName(GroupName);
            for(var i=0;i<ele.length;i++)
            ele[i].checked = false;
        }

        // Reset Modal Data on when modal gets closed
        function modalResetData() {
            $("#div_eliminar").html('');
            modal.style.display = "none";
            for (i = 0; i < input.length; i++) {
                input[i].value = '';
            }
            for (j = 0; j < textarea.length; j++) {
                textarea[j].value = '';
            }
            clearRadioGroup("marker");
            // Get Modal Backdrop
            var getModalBackdrop = document.getElementsByClassName('modal-backdrop')[0];
            document.body.removeChild(getModalBackdrop);
            //REINICIAR CAMPOS
            //$('#cod_base').val('0');
            $('#id_proveedor').val('0');
            $(".basicp").select2({
                dropdownParent: $('#addEventsModal')
            });
        }

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
            addEvent.style.display = 'block';
            editEvent.style.display = 'none';
            addEventTitle.style.display = 'block';
            editEventTitle.style.display = 'none';
            document.getElementsByTagName('body')[0].style.overflow = 'hidden';
            createBackdropElement();
            enableDatePicker();
        }

        // Clear Data and close the modal when the user clicks on Discard button
        discardModal.onclick = function() {
            modalResetData();
            document.getElementsByTagName('body')[0].removeAttribute('style');
        }

        // Clear Data and close the modal when the user clicks on <span> (x).
        span.onclick = function() {
            modalResetData();
            document.getElementsByTagName('body')[0].removeAttribute('style');
        }

        // Clear Data and close the modal when the user clicks anywhere outside of the modal.
        window.onclick = function(event) {
            if (event.target == modal) {
                modalResetData();
                document.getElementsByTagName('body')[0].removeAttribute('style');
            }
        }

        newDate = new Date()
        monthArray = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12' ]

        function getDynamicMonth( monthOrder ) {
            var getNumericMonth = parseInt(monthArray[newDate.getMonth()]);
            var getNumericMonthInc = parseInt(monthArray[newDate.getMonth()]) + 1;
            var getNumericMonthDec = parseInt(monthArray[newDate.getMonth()]) - 1;

            if (monthOrder === 'default') {

                if (getNumericMonth < 10 ) {
                    return '0' + getNumericMonth;
                } else if (getNumericMonth >= 10) {
                    return getNumericMonth;
                }

            } else if (monthOrder === 'inc') {

                if (getNumericMonthInc < 10 ) {
                    return '0' + getNumericMonthInc;
                } else if (getNumericMonthInc >= 10) {
                    return getNumericMonthInc;
                }

            } else if (monthOrder === 'dec') {

                if (getNumericMonthDec < 10 ) {
                    return '0' + getNumericMonthDec;
                } else if (getNumericMonthDec >= 10) {
                    return getNumericMonthDec;
                }
            }
        }

        /* initialize the calendar
        -----------------------------------------------------------------*/

        var calendar = $('#calendar').fullCalendar({
            defaultView: 'agendaWeek',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: [
                @foreach($list_calendario as $list)
                    {
                        id: '{{ $list->id_calendario }}',
                        title: '{{ $list->titulo }}',
                        start: '{{ $list->fec_de }}',
                        end: '{{ $list->fec_hasta }}',
                        className: "bg-{{ $list->id_tipo_calendario }}",
                        description: '{{ preg_replace("/[\r\n|\n|\r]+/"," ",$list->descripcion) }}',
                        tipo: '{{ $list->id_tipo_calendario }}',
                        proveedor: '@php
                                        $busqueda1 = in_array($list->id_proveedor, array_column($list_proveedor_tela, 'id_proveedor'));
                                        $posicion1 = array_search($list->id_proveedor, array_column($list_proveedor_tela, 'id_proveedor'));
                                        if ($busqueda1 != false) {
                                            echo $list_proveedor_tela[$posicion1]['nombre_proveedor'];
                                        }
                                        if($list->infosap=="1"){
                                            $busqueda = in_array($list->id_proveedor, array_column($list_proveedor, 'clp_codigo'));
                                            $posicion = array_search($list->id_proveedor, array_column($list_proveedor, 'clp_codigo'));
                                            if ($busqueda != false) {
                                                echo $list_proveedor[$posicion]['clp_razsoc'];
                                            }
                                        }
                                        $busqueda2 = in_array($list->id_proveedor, array_column($list_proveedor_taller, 'id_proveedor'));
                                        $posicion2 = array_search($list->id_proveedor, array_column($list_proveedor_taller, 'id_proveedor'));
                                        if ($busqueda2 != false) {
                                            echo $list_proveedor_taller[$posicion2]['nombre_proveedor'];
                                        }
                                    @endphp',
                        base: '{{ $list->base }}',
                        cant_prendas: '{{ $list->cant_prendas }}',
                        id_proveedor: '{{ $list->id_proveedor }}',
                        infosap: '{{ $list->infosap }}'
                    },
                @endforeach
            ],
            editable: false, //EVITA QUE SE MUEVA EL BLOQUE EN EL CALENDARIO
            eventLimit: true,
            eventMouseover: function(event, jsEvent, view) {
                $(this).attr('id', event.id);

                var cant_prendasev = '\n Cantidad de Prendas '+event.cant_prendas;
                var proveedorev = '\n Proveedor '+event.proveedor+', ';
                var baseev = '\n Base '+event.base+', ';
                $('#'+event.id).popover({
                    template: '<div class="popover popover-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                    title: event.title,
                    content: baseev+proveedorev+event.description+', '+cant_prendasev,
                    placement: 'top',
                });
                $('#'+event.id).popover('show');
            },
            eventMouseout: function(event, jsEvent, view) {
                $('#'+event.id).popover('hide');
            },
            eventClick: function(info) {
                addEvent.style.display = 'none';
                editEvent.style.display = 'block';

                addEventTitle.style.display = 'none';
                editEventTitle.style.display = 'block';
                modal.style.display = "block";
                document.getElementsByTagName('body')[0].style.overflow = 'hidden';
                createBackdropElement();

                // Calendar Event Featch
                var eventId = info.id;
                var eventTitle = info.title;
                var eventTitle1 = info.cant_prendas;
                var eventDescription = info.description;
                var eventTipo = info.tipo;
                var eventBase = info.base;
                var eventProveedor = info.id_proveedor+'-'+info.infosap;

                // Task Modal Input
                var taskTitle = $('#task');
                var taskTitleValue = taskTitle.val(eventTitle);

                var taskTitle1 = $('#cant_prendas');
                var taskTitleValue = taskTitle1.val(eventTitle1);

                var taskDescription = $('#taskdescription');
                var taskDescriptionValue = taskDescription.val(eventDescription);

                var taskTipo = $('#r_'+eventTipo);
                var taskTipoValue = taskTipo.prop('checked',true);

                $('#cod_base').val(eventBase);
                $('#id_proveedor').val(eventProveedor);
                $(".basicp").select2({
                    dropdownParent: $('#addEventsModal')
                });

                var taskBoton = $('#div_eliminar');
                var taskBotonValue = taskBoton.html('<button type="button" class="btn btn-danger" onclick="Delete_Calendario_Logistico('+eventId+');">Eliminar</button>');

                var taskInputStarttDate = $("#start-date");
                var taskInputStarttDateValue = taskInputStarttDate.val(info.start.format("YYYY-MM-DD HH:mm:ss"));

                var taskInputEndDate = $("#end-date");
                var taskInputEndtDateValue = taskInputEndDate.val(info.end.format("YYYY-MM-DD HH:mm:ss"));
            
                var startDate = flatpickr(document.getElementById('start-date'), {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    defaultDate: info.start.format("YYYY-MM-DD HH:mm:ss"),
                });

                var abv = startDate.config.onChange.push(function(selectedDates, dateStr, instance) {
                    var endtDate = flatpickr(document.getElementById('end-date'), {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        minDate: dateStr
                    });
                })

                var endtDate = flatpickr(document.getElementById('end-date'), {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    defaultDate: info.end.format("YYYY-MM-DD HH:mm:ss"),
                    minDate: info.start.format("YYYY-MM-DD HH:mm:ss")
                });

                $('#edit-event').off('click').on('click', function(event) {
                    Update_Calendario_Logistico(eventId);
                });
            }
        })

        function enableDatePicker() {
            var startDate = flatpickr(document.getElementById('start-date'), {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: new Date()
            });

            var abv = startDate.config.onChange.push(function(selectedDates, dateStr, instance) {

                var endtDate = flatpickr(document.getElementById('end-date'), {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    minDate: dateStr
                });
            })

            var endtDate = flatpickr(document.getElementById('end-date'), {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: new Date()
            });
        }

        function randomString(length, chars) {
            var result = '';
            for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
            return result;
        }

        $("#add-e").off('click').on('click', function(event) {
            Insert_Calendario_Logistico();
        });

        // Setting dynamic style ( padding ) of the highlited ( current ) date

        function setCurrentDateHighlightStyle() {
            getCurrentDate = $('.fc-content-skeleton .fc-today').attr('data-date');
            if (getCurrentDate === undefined) {
                return;
            }
            splitDate = getCurrentDate.split('-');
            if (splitDate[2] < 10) {
                $('.fc-content-skeleton .fc-today .fc-day-number').css('padding', '3px 8px');
            } else if (splitDate[2] >= 10) {
                $('.fc-content-skeleton .fc-today .fc-day-number').css('padding', '3px 4px');
            }
        }
        setCurrentDateHighlightStyle();

        const mailScroll = new PerfectScrollbar('.fc-scroller', {
            suppressScrollX : true
        });

        var fcButtons = document.getElementsByClassName('fc-button');
        for(var i = 0; i < fcButtons.length; i++) {
            fcButtons[i].addEventListener('click', function() {
                const mailScroll = new PerfectScrollbar('.fc-scroller', {
                    suppressScrollX : true
                });        
                $('.fc-scroller').animate({ scrollTop: 0 }, 100);
                setCurrentDateHighlightStyle();
            })
        }
    });
</script>