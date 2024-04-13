@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Exam Result <span style="color: blue"></span></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                @include('_message')
                @foreach ($getRecord as $value)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b>Exam Name : </b>{{ $value['exam_name'] }}</h3>
                            <br>
                            <h3 class="card-title"><b>Class Name : </b>{{ $value['class_name'] }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 400px">Subject Name</th>
                                        <th>Class Work</th>
                                        <th>Home Work</th>
                                        <th>Test Work</th>
                                        <th>Exam</th>
                                        <th>Full Marks</th>
                                        <th>Passing Mark</th>
                                        <th>Totle Mark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totle_score_all = 0;
                                        $full_marks_all = 0;
                                        $result_validation = 0;
                                    @endphp
                                    @foreach ($value['subject'] as $exam)
                                        @php
                                            $totle_score_all =
                                                $totle_score_all +
                                                $exam['class_work'] +
                                                $exam['home_work'] +
                                                $exam['test_work'] +
                                                $exam['exam'];
                                            $totle_score =
                                                $exam['class_work'] +
                                                $exam['home_work'] +
                                                $exam['test_work'] +
                                                $exam['exam'];
                                            $full_marks_all += $exam['full_marks'];
                                        @endphp

                                        <tr>
                                            <td>{{ $exam['subject_name'] }}</td>
                                            <td>{{ $exam['class_work'] }}</td>
                                            <td>{{ $exam['home_work'] }}</td>
                                            <td>{{ $exam['test_work'] }}</td>
                                            <td>{{ $exam['exam'] }}</td>
                                            <td>{{ $exam['full_marks'] }}</td>
                                            <td>{{ $exam['passing_mark'] }}</td>
                                            <td>
                                                <b> {{ $totle_score }} /
                                                    {{ $exam['full_marks'] }}</b>
                                            </td>
                                            <td>
                                                @if ($totle_score >= $exam['passing_mark'])
                                                    <span style="color: green;font-weight: bold">Pass</span>
                                                @else
                                                    @php
                                                        $result_validation = 1;
                                                    @endphp
                                                    <span style="color: red;font-weight: bold">Fail</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="3"><b>Grand Total Score : {{ $totle_score_all }} /
                                                {{ $full_marks_all }}</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="1">
                                            @php
                                                $precentage = ($totle_score_all * 100) / $full_marks_all;
                                                $getGrade = App\Models\MarksGradeModel::getGrade($precentage);
                                            @endphp

                                            <b>Grade : </b>{{ $getGrade }}
                                            <br>
                                        </td>
                                        <td colspan="2"><b>Percentage:
                                                {{ round(($totle_score_all * 100) / $full_marks_all, 2) }}%</b></td>

                                        <td colspan="2">
                                            <b>Result: @if ($result_validation == 0)
                                                    <span style="color: green;font-weight: bold">Pass</span>
                                                @else
                                                    <span style="color: red;font-weight: bold">Fail</span>
                                                @endif
                                            </b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    </div>
@endsection
