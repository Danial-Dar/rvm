@extends('layouts.app')
@section('styles')
<style>
.ticCell {
    border: 1px solid;
}

th {
    text-align: center !important;
}

.titelCell {
    border-right: solid;
    border-width: 1px;
    width: 120px;
    height: 40px;
}

.dayCell {
    border-bottom: solid;
    border-width: 1px;
    width: 120px;
    height: 40px;
}

.saveBtn{
    background-color: white;
    width: 130px;
    height: 30px;
}

table td.highlighted {
        background-color: #87CEEB;
}
table td.default_highlighted {
        background-color: #007bff;
}
</style>

@endsection
@section('content')
<div class="contents">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-main user-member justify-content-sm-between ">
                    <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                        <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                            <h4 class="text-capitalize fw-500 breadcrumb-title">Select DNC Time</h4>
                            <span class="sub-title ml-sm-25 pl-sm-25">Note: All Times are according to CST, Any box selected in blue will block that time slot from having dial activity occuring. </span>
                            @if ($errors->any())
                                <div class="alert alert-danger" id="alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()">x</button>
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                    <div class="alert alert-success" id="alert-success">
                                        <ul>
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()" >x</button>
                                        <li>{{session('success')}}</li></ul>
                                    </div>
                            @endif
                            @if(session('error'))
                                    <div class="alert alert-danger" id="alert-danger">
                                        <ul>
                                        <button  style="float:right; background: none;border: none; " onclick="closeAlert()" >x</button>
                                        <li>{{session('error')}}</li></ul>
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class=" global-shadow border p-30 bg-white radius-xl w-100 mb-30 mt-30">
                        <table id="timeTable">
                                    <th scope="col">#</th>
                                    <th scope="col" class="titelCell" align="center">12AM</th>
                                    <th scope="col" class="titelCell" align="center">01AM</th>
                                    <th scope="col" class="titelCell" align="center">02AM</th>
                                    <th scope="col" class="titelCell" align="center">03AM</th>
                                    <th scope="col" class="titelCell" align="center">04AM</th>
                                    <th scope="col" class="titelCell" align="center">05AM</th>
                                    <th scope="col" class="titelCell" align="center">06AM</th>
                                    <th scope="col" class="titelCell" align="center">07AM</th>
                                    <th scope="col" class="titelCell" align="center">08AM</th>
                                    <th scope="col" class="titelCell" align="center">09AM</th>
                                    <th scope="col" class="titelCell" align="center">10AM</th>
                                    <th scope="col" class="titelCell" align="center">11AM</th>
                                    <th scope="col" class="titelCell" align="center">12PM</th>
                                    <th scope="col" class="titelCell" align="center">1PM</th>
                                    <th scope="col" class="titelCell" align="center">2PM</th>
                                    <th scope="col" class="titelCell" align="center">3PM</th>
                                    <th scope="col" class="titelCell" align="center">4PM</th>
                                    <th scope="col" class="titelCell" align="center">5PM</th>
                                    <th scope="col" class="titelCell" align="center">6PM</th>
                                    <th scope="col" class="titelCell" align="center">7PM</th>
                                    <th scope="col" class="titelCell" align="center">8PM</th>
                                    <th scope="col" class="titelCell" align="center">9PM</th>
                                    <th scope="col" class="titelCell" align="center">10PM</th>
                                    <th scope="col" class="titelCell" align="center">11PM</th>
                                    <?php

                                    ?>
                                    @for($i = 0; $i < count($days); $i++)
                                    <tr>
                                        <th class="dayCell"> {{$days[$i]}}</th>

                                        @for($j = 0; $j < 24; $j++)

                                            <?php
                                                $parse_from = \Carbon\Carbon::parse($j.':00:00')->format('H:i:s');
                                                $parse_to = \Carbon\Carbon::parse(($j+1).':00:00')->format('H:i:s');
                                                $var = $days[$i].'-'.$parse_from.'-'.$parse_to;  ?>

                                                <td class="ticCell @if(in_array( $var , $dnc_array )) highlighted @endif @if(in_array( $var , $defaultDNC )) default_highlighted @endif " id="{{$j}}"
                                                onclick="myFunc('{{$var}}', '{{$j}}',this)"   ></td>


                                        @endfor

                                    </tr>
                                    @endfor
                                        <!-- <td class="ticCell" id="11" onclick="myFunc('monday-22:00:00-23:00:00')"></td> -->
                                        <!-- <td class="ticCell" id="12" ></td>
                                        <td class="ticCell" id="13" ></td>
                                        <td class="ticCell" id="14" ></td>
                                        <td class="ticCell" id="15" ></td>
                                        <td class="ticCell" id="16" ></td>
                                        <td class="ticCell" id="17" ></td>
                                        <td class="ticCell" id="18" ></td>
                                        <td class="ticCell" id="19" ></td>
                                        <td class="ticCell" id="110" ></td>
                                        <td class="ticCell" id="111" ></td>
                                        <td class="ticCell" id="112" ></td>
                                        <td class="ticCell" id="113" ></td>
                                        <td class="ticCell" id="114" ></td>
                                        <td class="ticCell" id="115" ></td>
                                        <td class="ticCell" id="116" ></td>
                                        <td class="ticCell" id="117" ></td>
                                        <td class="ticCell" id="118" ></td>
                                        <td class="ticCell" id="119" ></td>
                                        <td class="ticCell" id="120" ></td>
                                        <td class="ticCell" id="121" ></td>
                                        <td class="ticCell" id="122" ></td>
                                        <td class="ticCell" id="123" ></td> -->

                                    <!-- </tr>
                                    <tr>
                                        <th class="dayCell"> Tue</th>
                                        <td class="ticCell" id="20" ></td>
                                        <td class="ticCell" id="21" ></td>
                                        <td class="ticCell" id="22" ></td>
                                        <td class="ticCell" id="23" ></td>
                                        <td class="ticCell" id="24" ></td>
                                        <td class="ticCell" id="25" ></td>
                                        <td class="ticCell" id="26" ></td>
                                        <td class="ticCell" id="27" ></td>
                                        <td class="ticCell" id="28" ></td>
                                        <td class="ticCell" id="29" ></td>
                                        <td class="ticCell" id="210" ></td>
                                        <td class="ticCell" id="211" ></td>
                                        <td class="ticCell" id="212" ></td>
                                        <td class="ticCell" id="213" ></td>
                                        <td class="ticCell" id="214" ></td>
                                        <td class="ticCell" id="215" ></td>
                                        <td class="ticCell" id="216" ></td>
                                        <td class="ticCell" id="217" ></td>
                                        <td class="ticCell" id="218" ></td>
                                        <td class="ticCell" id="219" ></td>
                                        <td class="ticCell" id="220" ></td>
                                        <td class="ticCell" id="221" ></td>
                                        <td class="ticCell" id="222" ></td>
                                        <td class="ticCell" id="223" ></td>
                                    </tr>
                                    <tr>
                                        <th class="dayCell"> Wed</th>
                                        <td class="ticCell" id="30" ></td>
                                        <td class="ticCell" id="31" ></td>
                                        <td class="ticCell" id="32" ></td>
                                        <td class="ticCell" id="33" ></td>
                                        <td class="ticCell" id="34" ></td>
                                        <td class="ticCell" id="35" ></td>
                                        <td class="ticCell" id="36" ></td>
                                        <td class="ticCell" id="37" ></td>
                                        <td class="ticCell" id="38" ></td>
                                        <td class="ticCell" id="39" ></td>
                                        <td class="ticCell" id="310" ></td>
                                        <td class="ticCell" id="311" ></td>
                                        <td class="ticCell" id="312" ></td>
                                        <td class="ticCell" id="313" ></td>
                                        <td class="ticCell" id="314" ></td>
                                        <td class="ticCell" id="315" ></td>
                                        <td class="ticCell" id="316" ></td>
                                        <td class="ticCell" id="317" ></td>
                                        <td class="ticCell" id="318" ></td>
                                        <td class="ticCell" id="319" ></td>
                                        <td class="ticCell" id="320" ></td>
                                        <td class="ticCell" id="321" ></td>
                                        <td class="ticCell" id="322" ></td>
                                        <td class="ticCell" id="323" ></td>
                                    </tr>

                                    <tr>
                                        <th class="dayCell"> Thu</th>
                                        <td class="ticCell" id="40" ></td>
                                        <td class="ticCell" id="41" ></td>
                                        <td class="ticCell" id="42" ></td>
                                        <td class="ticCell" id="43" ></td>
                                        <td class="ticCell" id="44" ></td>
                                        <td class="ticCell" id="45" ></td>
                                        <td class="ticCell" id="46" ></td>
                                        <td class="ticCell" id="47" ></td>
                                        <td class="ticCell" id="48" ></td>
                                        <td class="ticCell" id="49" ></td>
                                        <td class="ticCell" id="410" ></td>
                                        <td class="ticCell" id="411" ></td>
                                        <td class="ticCell" id="412" ></td>
                                        <td class="ticCell" id="413" ></td>
                                        <td class="ticCell" id="414" ></td>
                                        <td class="ticCell" id="415" ></td>
                                        <td class="ticCell" id="416" ></td>
                                        <td class="ticCell" id="417" ></td>
                                        <td class="ticCell" id="418" ></td>
                                        <td class="ticCell" id="419" ></td>
                                        <td class="ticCell" id="420" ></td>
                                        <td class="ticCell" id="421" ></td>
                                        <td class="ticCell" id="422" ></td>
                                        <td class="ticCell" id="423" ></td>
                                    </tr>

                                    <tr>
                                        <th class="dayCell"> Fri</th>
                                        <td class="ticCell" id="50" ></td>
                                        <td class="ticCell" id="51" ></td>
                                        <td class="ticCell" id="52" ></td>
                                        <td class="ticCell" id="53" ></td>
                                        <td class="ticCell" id="54" ></td>
                                        <td class="ticCell" id="55" ></td>
                                        <td class="ticCell" id="56" ></td>
                                        <td class="ticCell" id="57" ></td>
                                        <td class="ticCell" id="58" ></td>
                                        <td class="ticCell" id="59" ></td>
                                        <td class="ticCell" id="510" ></td>
                                        <td class="ticCell" id="511" ></td>
                                        <td class="ticCell" id="512" ></td>
                                        <td class="ticCell" id="513" ></td>
                                        <td class="ticCell" id="514" ></td>
                                        <td class="ticCell" id="515" ></td>
                                        <td class="ticCell" id="516" ></td>
                                        <td class="ticCell" id="517" ></td>
                                        <td class="ticCell" id="518" ></td>
                                        <td class="ticCell" id="519" ></td>
                                        <td class="ticCell" id="520" ></td>
                                        <td class="ticCell" id="521" ></td>
                                        <td class="ticCell" id="522" ></td>
                                        <td class="ticCell" id="523" ></td>
                                    </tr>
                                    <tr>
                                        <th class="dayCell"> Sat</th>
                                        <td class="ticCell" id="60" ></td>
                                        <td class="ticCell" id="61" ></td>
                                        <td class="ticCell" id="62" ></td>
                                        <td class="ticCell" id="63" ></td>
                                        <td class="ticCell" id="64" ></td>
                                        <td class="ticCell" id="65" ></td>
                                        <td class="ticCell" id="66" ></td>
                                        <td class="ticCell" id="67" ></td>
                                        <td class="ticCell" id="68" ></td>
                                        <td class="ticCell" id="69" ></td>
                                        <td class="ticCell" id="610" ></td>
                                        <td class="ticCell" id="611" ></td>
                                        <td class="ticCell" id="612" ></td>
                                        <td class="ticCell" id="613" ></td>
                                        <td class="ticCell" id="614" ></td>
                                        <td class="ticCell" id="615" ></td>
                                        <td class="ticCell" id="616" ></td>
                                        <td class="ticCell" id="617" ></td>
                                        <td class="ticCell" id="618" ></td>
                                        <td class="ticCell" id="619" ></td>
                                        <td class="ticCell" id="620" ></td>
                                        <td class="ticCell" id="621" ></td>
                                        <td class="ticCell" id="622" ></td>
                                        <td class="ticCell" id="623" ></td>
                                    </tr>
                                    <tr>
                                        <th class="dayCell"> Sun</th>
                                        <td class="ticCell" id="70" ></td>
                                        <td class="ticCell" id="71" ></td>
                                        <td class="ticCell" id="72" ></td>
                                        <td class="ticCell" id="73" ></td>
                                        <td class="ticCell" id="74" ></td>
                                        <td class="ticCell" id="75" ></td>
                                        <td class="ticCell" id="76" ></td>
                                        <td class="ticCell" id="77" ></td>
                                        <td class="ticCell" id="78" ></td>
                                        <td class="ticCell" id="79" ></td>
                                        <td class="ticCell" id="710" ></td>
                                        <td class="ticCell" id="711" ></td>
                                        <td class="ticCell" id="712" ></td>
                                        <td class="ticCell" id="713" ></td>
                                        <td class="ticCell" id="714" ></td>
                                        <td class="ticCell" id="715" ></td>
                                        <td class="ticCell" id="716" ></td>
                                        <td class="ticCell" id="717" ></td>
                                        <td class="ticCell" id="718" ></td>
                                        <td class="ticCell" id="719" ></td>
                                        <td class="ticCell" id="720" ></td>
                                        <td class="ticCell" id="721" ></td>
                                        <td class="ticCell" id="722" ></td>
                                        <td class="ticCell" id="723" ></td>
                                    </tr> -->
                        </table>
                        <button type="button" class="mt-30 btn btn-primary" id="btn-save-TS">Save Schedule</button>
                    </div>
                        @php
                            if(auth()->user()->role !== "company")
                                $dncTimeURL = 'user.dnc-time.store';
                            else
                                $dncTimeURL = 'company.dnc-time.store';
                        @endphp
                        <form action="{{route($dncTimeURL)}}" method="POSt" name="time_slots_form" id="time_slots_form">
                            @csrf
                            <div class="form-group mb-20">
                                <input type="hidden" name="timeslots" id="time_slots" class="form-control" value="{{implode(',',$dnc_array)}}" placeholder="Company Name" required>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    $('#alert-success').delay(3000).fadeOut();
    $('#alert-danger').delay(3000).fadeOut();
    var timeSets = [];

$(function () {
    var isMouseDown = false;
    $("#timeTable td")
            .mousedown(function () {
                isMouseDown = true;
                $(this).toggleClass("highlighted");
                // $(this).toggleClass("default_highlighted");
                // $(this).removeClass("default_highlighted");
                return false;
            })
            .mouseover(function () {
                if (isMouseDown) {
                    $(this).toggleClass("highlighted");
                    // $(this).toggleClass("default_highlighted");
                    // $(this).removeClass("default_highlighted");
                }
            });
    $(document).mouseup(function () {
        isMouseDown = false;
    });
    // $('#btn-save-TS').on('click', function () {
    //     saveTimeSave();
    // });
});

var saveTimeSave = function () {
    for (i = 1; i < 8; i++) {
        for (j = 0; j < 24; j++) {
            if ($("#" + i + "" + j).css("backgroundColor") == "rgb(135, 206, 235)") {
                if (timeSets.indexOf(i + "" + j) == -1) {
                    timeSets.push(i + "" + j);
                }
            }else{
                realIndex = timeSets.indexOf(i + "" + j);
                if (realIndex != -1) {
                    timeSets.splice(realIndex, 1);
                }
            }
        }
    }
    console.log(timeSets.valueOf());
    // $('#time_slots').val(timeSets.valueOf());
    // document.getElementById('time_slots_form').submit();
};



</script>

<script>
    var str = $('#time_slots').val();

    var newTimeSets = str !== "" ? str.split(",") : [];

    function myFunc(value, id,val){
        let defaultID = ['0','1','2','3','4','5','6','20','21','22','23'];
        if(defaultID.includes(id) === true){
            // $("#timeTable td")
            $(val).toggleClass("default_highlighted");
        }
        if (newTimeSets.includes(value) === true) {

            var ind = newTimeSets.indexOf(value);
            if (ind > -1) {
                newTimeSets.splice(ind, 1);
            }

        }else{

            newTimeSets.push(value);
        }



        console.log(newTimeSets.valueOf());

        $('#time_slots').val(newTimeSets.valueOf());
        // document.getElementById('time_slots_form').submit();

    }

    $('#btn-save-TS').on('click', function () {
        if ($('#time_slots').val() === "") {
            alert('Please Select Time Slot First');
        }
        else{
            document.getElementById('time_slots_form').submit();
        }
    });

</script>
@endsection
