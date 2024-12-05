@extends('layouts.plantilla')

@section('content')
    <style>
        @foreach($list_tipo_calendario_todo as $list)
            .radio-<?= $list['id_tipo_calendario']; ?> span.new-control-indicator {
                border: 2px solid <?= $list['color']; ?>; 
            }
            .new-control.new-checkbox.new-checkbox-text.checkbox-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-chk-content, .new-control.new-checkbox.new-checkbox-text.checkbox-outline-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-chk-content {
                color: <?= $list['color']; ?>; 
            }
            .new-control.new-checkbox.checkbox-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-control-indicator {
                background: <?= $list['color']; ?>; 
            }
            .new-control.new-checkbox.checkbox-outline-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-control-indicator {
                border: 2px solid <?= $list['color']; ?>; 
            }
            .new-control.new-checkbox.checkbox-outline-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-control-indicator:after {
                border-color: <?= $list['color']; ?>; 
            }
            .new-control.new-radio.radio-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-control-indicator {
                background: <?= $list['color']; ?>; 
            }
            .new-control.new-radio.radio-classic-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-control-indicator {
                border: 3px solid <?= $list['color']; ?>; 
            }
            .new-control.new-radio.radio-classic-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-control-indicator:after {
                background-color: <?= $list['color']; ?>; 
            }
            .new-control.new-radio.new-radio-text.radio-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-radio-content, .new-control.new-radio.new-radio-text.radio-classic-<?= $list['id_tipo_calendario']; ?> > input:checked ~ span.new-radio-content {
                color: <?= $list['color']; ?>; 
            }
            .label-<?= $list->id_tipo_calendario; ?>:before {
                background: <?= $list->color." !important"; ?>
            }
            .bg-<?= $list->id_tipo_calendario; ?> {
                background-color: <?= $list->background; ?> !important;
                border-color: <?= $list->color; ?> !important;
                color: #fff;
                -webkit-box-shadow: none !important;
                box-shadow: none !important; 
            }
            a.bg-<?= $list->id_tipo_calendario; ?>:hover {
                background-color: inherit !important;
                border-width: 2px !important; 
            }
            .fc-day-grid-event.bg-<?= $list->id_tipo_calendario; ?> .fc-content:before {
                background: <?= $list->color; ?>; 
            }
        @endforeach
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area p-3">
                            <div class="calendar-upper-section">
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="labels">
                                            @foreach ($list_tipo_calendario_todo as $list)
                                                <p class="label label-{{ $list->id_tipo_calendario }}">{{ $list->nom_tipo_calendario }}</p>
                                            @endforeach
                                        </div>
                                    </div>                                                
                                    <div class="col-md-4 col-12">
                                        <form action="javascript:void(0);" class="form-horizontal mt-md-0 mt-3 text-md-right text-center">
                                            <button id="myBtn" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mr-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Agregar Cita</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

                <!-- The Modal -->
                <div id="addEventsModal"data-backdrop="static"  class="modal animated fadeIn">

                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        
                        <!-- Modal content -->
                        <div class="modal-content">

                            <div class="modal-body">

                                <span id="close_modal" class="close">&times;</span>

                                <div class="add-edit-event-box">
                                    <div class="add-edit-event-content">
                                        <h5 class="add-event-title modal-title">Registrar Nueva Cita</h5>
                                        <h5 class="edit-event-title modal-title">Editar Cita</h5>

                                        <form id="formulario_cal" method="POST" enctype="multipart/form-data" class="needs-validation">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="start-date" class="">De:</label>
                                                        <div class="d-flex">
                                                            <input id="start-date" placeholder="Fecha Inicial" class="form-control" type="text" name="start-date" value="<?= date('Y-m-d h:i') ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="end-date" class="">Hasta:</label>
                                                        <div class="d-flex">
                                                            <input id="end-date" placeholder="Fecha Final" type="text" class="form-control" name="end-date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="write-e" class="">Título:</label>
                                                    <div class="d-flex">
                                                        <input id="write-e" type="text" placeholder="Título" class="form-control" name="task">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="taskdescription" class="">Descripción:</label>
                                                    <div class="d-flex">
                                                        <textarea id="taskdescription" placeholder="Descripción" rows="2" class="form-control" name="taskdescription"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="cod_base" class="">Base:</label>
                                                    <div id="div_base" class="d-flex">
                                                        <select class="form-control" name="cod_base" id="cod_base">
                                                            <option value="0" >Seleccione</option>
                                                            @foreach ($list_base as $list)
                                                                <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="cant_prendase" class="">Cantidad:</label>
                                                    <div class="d-flex">
                                                        <input id="cant_prendase" type="text" placeholder="Cantidad" class="form-control" name="cant_prendas">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label>Tipo:</label>
                                                </div>
                                                @foreach ($list_tipo_calendario as $list)
                                                    <div class="form-group col-lg-3">
                                                        <label class="new-control new-radio 
                                                        radio-<?= $list->id_tipo_calendario ?>">
                                                            <input type="radio" 
                                                            <?php if($list->id_tipo_calendario=="2" && 
                                                            (session('usuario')->id_puesto=="75")){ echo "checked"; } ?> 
                                                            class="new-control-input mr-2" 
                                                            id="r_<?= $list->id_tipo_calendario ?>" 
                                                            name="id_tipo_calendario" 
                                                            value="<?= $list->id_tipo_calendario ?>">
                                                            <span class="new-control-indicator"></span><?= $list->nom_tipo_calendario ?>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <input type="hidden" class="form-control" id="id_calendario" name="id_calendario">
                                        </form>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button id="add-e" class="btn">Guardar</button>
                                <button id="edit-event" class="btn">Guardar</button>
                                <button id="discard_modal" class="btn" data-dismiss="modal">Cerrar</button>
                            </div>

                        </div>

                    </div>

                </div>                
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#calendarios_logisticos").attr('aria-expanded','true');
            $("#calendarios_logisticos").addClass('active');

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
                modal.style.display = "none";
                for (i = 0; i < input.length; i++) {
                    input[i].value = '';
                }
                for (j = 0; j < textarea.length; j++) {
                    textarea[j].value = '';
                i
                }
                clearRadioGroup("marker");
                // Get Modal Backdrop
                var getModalBackdrop = document.getElementsByClassName('modal-backdrop')[0];
                document.body.removeChild(getModalBackdrop)
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
                            proveedor: 'Proveedor',
                            base: '{{ $list->base }}',
                            invitacion: '{{ $list->invitacion }}',
                            cant_prendas: '{{ $list->cant_prenda }}'
                        },
                    @endforeach
                ],
                editable: true,
                eventLimit: true,
                eventMouseover: function(event, jsEvent, view) {
                    $(this).attr('id', event.id);

                    $('#'+event.id).popover({
                        template: '<div class="popover popover-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                        title: event.title,
                        content: event.description,
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
                    var eventTitle = info.title;
                    var eventDescription = info.description;

                    // Task Modal Input
                    var taskTitle = $('#write-e');
                    var taskTitleValue = taskTitle.val(eventTitle);

                    var taskDescription = $('#taskdescription');
                    var taskDescriptionValue = taskDescription.val(eventDescription);

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
                        event.preventDefault();
                        /* Act on the event */
                        var radioValue = $("input[name='marker']:checked").val();

                        var taskStartTimeValue = document.getElementById("start-date").value;
                        var taskEndTimeValue = document.getElementById("end-date").value;

                        info.title = taskTitle.val();
                        info.description = taskDescription.val();
                        info.start = taskStartTimeValue;
                        info.end = taskEndTimeValue;
                        info.className = radioValue;

                        $('#calendar').fullCalendar('updateEvent', info);
                        modal.style.display = "none";
                        modalResetData();
                        document.getElementsByTagName('body')[0].removeAttribute('style');
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
                var radioValue = $("input[name='marker']:checked").val();
                var randomAlphaNumeric = randomString(10, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
                var inputValue = $("#write-e").val();
                var inputStarttDate = document.getElementById("start-date").value;
                var inputEndDate = document.getElementById("end-date").value;

                var arrayStartDate = inputStarttDate.split(' ');

                var arrayEndDate = inputEndDate.split(' ');

                var startDate = arrayStartDate[0];
                var startTime = arrayStartDate[1];

                var endDate = arrayEndDate[0];
                var endTime = arrayEndDate[1];

                var concatenateStartDateTime = startDate+'T'+startTime+':00';
                var concatenateEndDateTime = endDate+'T'+endTime+':00';

                var inputDescription = document.getElementById("taskdescription").value;
                var myCalendar = $('#calendar');
                myCalendar.fullCalendar();
                var myEvent = {
                    timeZone: 'UTC',
                    allDay : false,
                    id: randomAlphaNumeric,
                    title:inputValue,
                    start: concatenateStartDateTime,
                    end: concatenateEndDateTime,
                    className: radioValue,
                    description: inputDescription
                };
                myCalendar.fullCalendar( 'renderEvent', myEvent, true );
                modal.style.display = "none";
                modalResetData();
                document.getElementsByTagName('body')[0].removeAttribute('style');
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
@endsection