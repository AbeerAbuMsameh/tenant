@extends('Dashboard.master')

@section('title')
    Show ticket
@endsection
@section('Page-title')
    Ticket Details
@endsection
@section('js')
    <script>
        function printCard() {
            var printContents = document.getElementById("print-card").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();

            document.body.innerHTML = originalContents;
        }


    </script>
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="card card-custom position-relative overflow-hidden">
                    <!--begin::Shape-->
                    <div class="position-absolute opacity-30">
										<span class="svg-icon svg-icon-10x svg-logo-white">
											<!--begin::Svg Icon | path:assets/media/svg/shapes/abstract-8.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" width="176" height="165"
                                                 viewBox="0 0 176 165" fill="none">
												<g clip-path="url(#clip0)">
													<path
                                                        d="M-10.001 135.168C-10.001 151.643 3.87924 165.001 20.9985 165.001C38.1196 165.001 51.998 151.643 51.998 135.168C51.998 118.691 38.1196 105.335 20.9985 105.335C3.87924 105.335 -10.001 118.691 -10.001 135.168Z"
                                                        fill="#AD84FF"/>
													<path
                                                        d="M28.749 64.3117C28.749 78.7296 40.8927 90.4163 55.8745 90.4163C70.8563 90.4163 83 78.7296 83 64.3117C83 49.8954 70.8563 38.207 55.8745 38.207C40.8927 38.207 28.749 49.8954 28.749 64.3117Z"
                                                        fill="#AD84FF"/>
													<path
                                                        d="M82.9996 120.249C82.9996 144.964 103.819 165 129.501 165C155.181 165 176 144.964 176 120.249C176 95.5342 155.181 75.5 129.501 75.5C103.819 75.5 82.9996 95.5342 82.9996 120.249Z"
                                                        fill="#AD84FF"/>
													<path
                                                        d="M98.4976 23.2928C98.4976 43.8887 115.848 60.5856 137.249 60.5856C158.65 60.5856 176 43.8887 176 23.2928C176 2.69692 158.65 -14 137.249 -14C115.848 -14 98.4976 2.69692 98.4976 23.2928Z"
                                                        fill="#AD84FF"/>
													<path
                                                        d="M-10.0011 8.37466C-10.0011 20.7322 0.409554 30.7493 13.2503 30.7493C26.0911 30.7493 36.5 20.7322 36.5 8.37466C36.5 -3.98287 26.0911 -14 13.2503 -14C0.409554 -14 -10.0011 -3.98287 -10.0011 8.37466Z"
                                                        fill="#AD84FF"/>
													<path
                                                        d="M-2.24881 82.9565C-2.24881 87.0757 1.22081 90.4147 5.50108 90.4147C9.78135 90.4147 13.251 87.0757 13.251 82.9565C13.251 78.839 9.78135 75.5 5.50108 75.5C1.22081 75.5 -2.24881 78.839 -2.24881 82.9565Z"
                                                        fill="#AD84FF"/>
													<path
                                                        d="M55.8744 12.1044C55.8744 18.2841 61.0788 23.2926 67.5001 23.2926C73.9196 23.2926 79.124 18.2841 79.124 12.1044C79.124 5.92653 73.9196 0.917969 67.5001 0.917969C61.0788 0.917969 55.8744 5.92653 55.8744 12.1044Z"
                                                        fill="#AD84FF"/>
												</g>
											</svg>
                                            <!--end::Svg Icon-->
										</span>
                    </div>
                    <!--end::Shape-->
                    <div id="print-card">
                        <div class="row justify-content-center py-8 px-8 py-md-36 px-md-0 bg-primary">
                            <div class="col-md-9">
                                <div
                                    class="d-flex justify-content-between align-items-md-center flex-column flex-md-row">
                                    <div class="d-flex flex-column px-0 order-2 order-md-1">

                                    <span class="d-flex flex-column font-size-h5 font-weight-bold text-white">
													</span>
                                    </div>
                                    <h1 class="d-flex flex-column px-0 order-2 order-md-1 display-3 font-weight-boldest text-white order-1 order-md-2">
                                        TICKET DETAILS <br> <span
                                            class="d-flex flex-column font-size-h5 font-weight-bold text-white">
													Ticket # : {{$ticket->ticket_num  ?? '-'}}</span></h1>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center py-8 px-8 py-md-30 px-md-0">
                            <div class="col-md-9">
                                <div class="row pb-26">
                                    <div class="col-md-3 border-right-md pr-md-10 py-md-10">
                                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">Team</div>
                                        <div class="font-size-lg font-weight-bold mb-10">@if($ticket->team_id != null)
                                                {{$ticket->Team->name  ?? '-'}}
                                            @endif
                                        </div>


                                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">Report Source</div>
                                        <div class="font-size-lg font-weight-bold mb-10">
                                            {{$ticket->report_src  ?? '-' }}

                                        </div>

                                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">Impact</div>
                                        <div class="font-size-lg font-weight-bold mb-10">
                                            {{$ticket->impact  ?? '-'}}

                                        </div>


                                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">Urgency</div>
                                        <div class="font-size-lg font-weight-bold mb-10">
                                            @if($ticket->urgency == 'Low')
                                                <td class="font-weight-bold text-success">Low</td>
                                            @elseif ($ticket->urgency == 'Medium')
                                                <td><span class=" font-weight-bold  text-warning">Medium</span></td>
                                            @elseif ($ticket->urgency == 'High')
                                                <td><span class="font-weight-bold text-primary">High</span></td>
                                            @elseif ($ticket->urgency == 'Critical')
                                                <td><span class="font-weight-bold text-secondary">Critical</span></td>
                                            @elseif ($ticket->urgency == 'Urgent')
                                                <td><span class="font-weight-bold text-danger">Urgent</span></td>
                                            @endif

                                        </div>

                                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">Priority</div>
                                        <div class="font-size-lg font-weight-bold mb-10">
                                            @if( $ticket->priority == 'Low')
                                                <td><span
                                                        class="label label-lg font-weight-bold label-light-info label-inline">Low</span>
                                                </td>
                                            @elseif ( $ticket->priority == 'Medium')
                                                <td><span
                                                        class="label label-lg font-weight-bold label-light-warning label-inline">Medium</span>
                                                </td>
                                            @elseif ( $ticket->priority == 'High')
                                                <td><span
                                                        class="label label-lg font-weight-bold label-light-primary label-inline">High</span>
                                                </td>
                                            @elseif ( $ticket->priority == 'Critical')
                                                <td><span
                                                        class="label label-lg font-weight-bold label-light-dark label-inline">Critical</span>
                                                </td>
                                            @elseif ( $ticket->priority == 'Urgent')
                                                <td><span
                                                        class="label label-lg font-weight-bold label-light-danger label-inline">Urgent</span>
                                                </td>
                                            @endif
                                        </div>


                                    </div>
                                    <div class="col-md-9 py-10 pl-md-10">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="pt-1 pb-9 pl-0 pl-md-5 font-weight-bolder text-muted font-size-lg text-uppercase">
                                                        Type
                                                    </th>
                                                    <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">
                                                        Date
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="font-weight-bolder font-size-lg">
                                                    <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
																	<span class="navi-icon mr-2">
																		<i class="fa fa-genderless text-danger font-size-h2"></i>
																	</span>Report Date
                                                    </td>
                                                    <td class="border-top-0 text-right pt-7">{{$ticket->report_date  ?? '-'}}</td>
                                                </tr>

                                                <tr class="font-weight-bolder font-size-lg">
                                                    <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
																	<span class="navi-icon mr-2">
																		<i class="fa fa-genderless text-success font-size-h2"></i>
																	</span>Open Date
                                                    </td>
                                                    <td class="border-top-0 text-right pt-7">{{ $ticket->open_date  ?? '-'}}</td>
                                                </tr>

                                                <tr class="font-weight-bolder font-size-lg">
                                                    <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
																	<span class="navi-icon mr-2">
																		<i class="fa fa-genderless text-secondary font-size-h2"></i>
																	</span>Assign Date
                                                    </td>
                                                    <td class="border-top-0 text-right pt-7">{{$ticket->assign_date  ?? '-'}}</td>
                                                </tr>
                                                <tr class="font-weight-bolder font-size-lg">
                                                    <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
																	<span class="navi-icon mr-2">
																		<i class="fa fa-genderless text-primary font-size-h2"></i>
																	</span>Last Resolve Date
                                                    </td>
                                                    <td class="border-top-0 text-right pt-7">{{$ticket->last_resolve_date  ?? '-'}}</td>
                                                </tr>
                                                <tr class="font-weight-bolder font-size-lg">
                                                    <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
																	<span class="navi-icon mr-2">
																		<i class="fa fa-genderless text-danger font-size-h2"></i>
																	</span>Close Date
                                                    </td>
                                                    <td class="border-top-0 text-right pt-7">{{$ticket->close_date  ?? '-'}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 border-top pt-14 pb-10 pb-md-18">
                                        <div class="d-flex flex-column flex-md-row">
                                            <div class="d-flex flex-column">
                                                <div class="text-dark-50 font-size-lg font-weight-bold mb-3">DESCRIPTION
                                                </div>
                                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                                <span
                                                    class="font-weight-bold mr-15">{!!  $ticket->description !!}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center border-top py-8 px-8 py-md-28 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex font-size-sm flex-wrap">
                                <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1"
                                        onclick="printCard();">Print Ticket
                                </button>
                                <button type="button" class="btn btn-light-primary font-weight-bolder mr-3 my-1">
                                    Download
                                </button>

                                <a href="{{route('tickets.index')}}"
                                   class="btn btn-light-primary font-weight-bolder ml-sm-auto my-1">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
