@extends('layouts.app')

@section('style')
    <style>
        .fc-daygrid-event {
            white-space: normal;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>My Calendar</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card">
                    <div id="calendar" class="calendar p-5"></div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/dist/fullcalendar/index.global.min.js') }}"></script>
    <script src="text/javascript"></script>
    <script>
        var events = new Array();
        @foreach ($getClassTimetable as $value)

            events.push({
                title: '{{ $value->class_name }} - {{ $value->subject_name }}',
                daysOfWeek: "{{ $value->fullcalendar_day }}",
                startTime: '{{ $value->start_time }}',
                endTime: '{{ $value->end_time }}'
            });
        @endforeach

        @foreach ($getExamTimetable as $exam)
        events.push({
            events_id: 1,
            title: '{{ $exam->class_name }} - {{ $exam->exam_name }} -  {{ $exam->subject_name }} || ({{ date('h:i A', strtotime($exam->start_time)) }} to {{ date('h:i A', strtotime($exam->end_time)) }})',
            start: '{{ $exam->exam_date }}',
            end: '{{ $exam->exam_date }}',
            color: 'red',
            url : '{{ url('teacher/my_exam_timetable') }}'
        });
    @endforeach



        // console.log(events);

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next, today',
                    center: 'title',
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                initialDate: '<?= date('Y-m-d') ?>',
                navLinks: true,
                editable: false,
                initialView: 'dayGridMonth',
                events: events
            });

            calendar.render();
        });
    </script>
@endsection
