<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Exam Result</title>
    <style>
        @page {
            size: 8.3in 11.7in;
        }

        @page {
            size: A4;
        }

        .table-bg {
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
            text-align: center;
        }

        .margin-bottom {
            margin-bottom: 3px;
        }

        .th {
            border: 1px solid #000;
            padding: 10px;
        }

        .td {
            border: 1px solid #000;
            padding: 3px;
        }

        .text-container {
            text-align: left;
            padding-left: 5px;
        }

        @media print {
            @page {
                margin: 0;
                margin-right: 20px;
                margin-left: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="" id="page">
        <table style="width: 100%;text-align: center">
            <tr>
                <td width="5%"></td>
                <td width="16%"><img style="height: 100px;width: 100px;"
                        src="{{ $getSetting->getLogo() }}"
                        alt=""></td>
                <td align="left">
                    <h1>{!! $getSetting->school_name !!}</h1>
                </td>
            </tr>
        </table>
        <table style="width: 100%">
            <tr>
                <td width="5%"></td>
                <td width="70%">
                    <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>
                                <td width="27%">Name Of Student :</td>
                                <td style="border-bottom: 1px solid;width: 100%">{{ $getStudent->name }} {{ $getStudent->last_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>
                                <td width="23%">Admission No :</td>
                                <td style="border-bottom: 1px solid;width: 100%">{{ $getStudent->admission_number }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>
                                <td width="23%">Class :</td>
                                <td style="border-bottom: 1px solid;width: 100%">{{ $getClass->class_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="margin-bottom" style="width: 100%">
                        <tbody>
                            <tr>
                              
                                <td width="11%">Term :</td>
                                <td style="border-bottom: 1px solid;width: 100%">{{ $getExam->name }}</td>
                            </tr>
                        </tbody>
                    </table>

                </td>
                <td width="5%"></td>
                <td width="20%" valign="top">
                    <img style="height: 100px;width: 100px; border-radius: 6px"
                        src="{{ $getStudent->getProfileDirect() }}"
                        alt="">
                    <br>
                    Gender : {{ $getStudent->gender }}
                </td>
            </tr>
        </table>
        <br>
        <div>
            <table class="table-bg">
                <thead>
                    <tr>
                        <th class="th">Subject Name</th>
                        <th class="th">Class Work</th>
                        <th class="th">Home Work</th>
                        <th class="th">Test Work</th>
                        <th class="th">Exam</th>
                        <th class="th">Totle Mark</th>
                        <th class="th">Passing Mark</th>
                        <th class="th">Full Marks</th>
                        <th class="th">Result</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totle_score_all = 0;
                        $full_marks_all = 0;
                        $result_validation = 0;
                    @endphp
                    @foreach ($getExamMark as $exam)
                        @php
                            $totle_score_all =
                                $totle_score_all +
                                $exam['class_work'] +
                                $exam['home_work'] +
                                $exam['test_work'] +
                                $exam['exam'];
                            $totle_score =
                                $exam['class_work'] + $exam['home_work'] + $exam['test_work'] + $exam['exam'];
                            $full_marks_all += $exam['full_marks'];
                        @endphp
                        <tr>
                            <td class="td text-container">{{ $exam['subject_name'] }}</td>
                            <td class="td">{{ $exam['class_work'] }}</td>
                            <td class="td">{{ $exam['home_work'] }}</td>
                            <td class="td">{{ $exam['test_work'] }}</td>
                            <td class="td">{{ $exam['exam'] }}</td>
                            <td class="td">{{ $totle_score }}</td>
                            <td class="td">{{ $exam['passing_mark'] }}</td>
                            <td class="td">{{ $exam['full_marks'] }}</td>
                            <td class="td">
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
                        <td class="td" colspan="2">
                         <b>Grand Total : {{ $totle_score_all }} /
                                {{ $full_marks_all }}</b></td>
                 
                        </td>
                        <td class="td" colspan="2">
                            @php
                                $precentage = ($totle_score_all * 100) / $full_marks_all;
                                $getGrade = App\Models\MarksGradeModel::getGrade($precentage);
                            @endphp

                            <b>Grade : </b>{{ $getGrade }}
                            <br>
                        </td>
                        <td class="td" colspan="2"><b>Percentage:
                                {{ round(($totle_score_all * 100) / $full_marks_all, 2) }}%</b></td>

                        <td class="td" colspan="3">
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
            <div>
                <p>
                 {!! $getSetting->exam_description !!}
                </p>
            </div>
            <table class="margin-bottom" style="width: 100%">
                <tbody>
                    <tr>
                        <td width="14%">Signature :</td>
                        <td style="border-bottom: 1px solid;width: 100%"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
