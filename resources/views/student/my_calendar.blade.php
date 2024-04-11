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
        @foreach ($getMyTimetable as $timetable)
            @foreach ($timetable['week'] as $week)
                events.push({
                    title: '{{ $timetable['name'] }}',
                    daysOfWeek: "{{ $week['fullcalendar_day'] }}",
                    startTime: '{{ $week['start_time'] }}',
                    endTime: '{{ $week['end_time'] }}'
                });
            @endforeach
        @endforeach

        @foreach ($getExamTimetable as $velueE)
            @foreach ($velueE['exam'] as $exam)

                events.push({
                    events_id: 1,
                    title: '{{ $velueE['name'] }} -  {{ $exam['subject_name'] }} || ({{ date('h:i A', strtotime($exam['start_time'])) }} to {{ date('h:i A', strtotime($exam['end_time'])) }})',
                    start: '{{ $exam['exam_date'] }}',
                    end: '{{ $exam['exam_date'] }}',
                    color: 'red',
                    url: '{{ url('student/my_exam_timetable') }}'
                });
            @endforeach
        @endforeach


        console.log(events);

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
