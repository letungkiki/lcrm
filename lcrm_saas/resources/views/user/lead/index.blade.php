@extends('layouts.user')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    <div class="row analytics">
        <div class="col-12 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.product') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadProduct }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadProduct/$leads)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{$leads?($leadProduct/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadProduct/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.design') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadDesign }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadDesign/$leads)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{$leads?($leadDesign/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadDesign/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.software') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadSoftware }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadSoftware/$leads)*100, 2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$leads?($leadSoftware/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadProduct/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.others') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                {{ $leadOthers }}
                            </div>
                            <div class="float-right">
                                {{ $leads?round(($leadOthers/$leads)*100,2):0 }}%
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{$leads?($leadOthers/$leads)*100:0}}%" aria-valuenow="{{$leads?($leadProduct/$leads)*100:0}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.leads_by_priority') }}</h4>
                </div>
                <div class="card-body">
                    <div id="leads_priority" class="max_height_300"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-white ">
                    <h4>{{ trans('lead.leads_by_month') }}</h4>
                </div>
                <div class="card-body">
                    <div id="leads_by_month" class="max_height_300"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header clearfix">
        @if($user->hasAccess(['leads.write']) || $orgRole=='admin')
            <div class="pull-right">
                <a href="{{ $type.'/create' }}" class="btn btn-primary m-b-10">
                    <i class="fa fa-plus-circle"></i> {{ trans('lead.new') }}</a>
                <a href="{{ $type.'/import' }}" class="btn btn-primary m-b-10">
                    <i class="fa fa-download"></i> {{ trans('lead.import') }}</a>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h4 class="float-left">
                <i class="material-icons">thumb_up</i>
                {{ $title }}
            </h4>
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    <i class="fa fa-fw fa-times removecard clickable"></i>
                                </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table id="data" class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>{{ trans('lead.creation_date') }}</th>
                    <th>{{ trans('lead.company_name') }}</th>
                    <th>{{ trans('lead.contact_name') }}</th>
                    <th>{{ trans('lead.product_name') }}</th>
                    <th>{{ trans('lead.email') }}</th>
                    <th>{{ trans('lead.phone') }}</th>
                    <th>{{ trans('lead.priority') }}</th>
                    <th>{{ trans('table.actions') }}</th>
                </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
            </div>
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        var chart1 = c3.generate({
            bindto: '#leads_priority',
            data: {
                columns: [
                        @foreach($priorities as $item)
                    ['{{$item['value']}}', {{$item['leads']}}],
                    @endforeach
                ],
                type : 'donut',
                colors: {
                    @foreach($priorities as $item)
                    '{{$item['value']}}': '{{$item['color']}}',
                    @endforeach
                }
            }
        });
        setTimeout(function () {
            chart1.resize()
        }, 500);


        //products by month
        var productsData = [
            ['leads'],
                @foreach($graphics as $item)
            [{{$item['leads']}}],
            @endforeach
        ];
        var chart2 = c3.generate({
            bindto: '#leads_by_month',
            data: {
                rows: productsData,
                type: 'bar'
            },
            color: {
                pattern: ['#3295ff']
            },
            axis: {
                x: {
                    tick: {
                        format: function (d) {
                            return formatMonth(d);
                        }
                    }
                }
            },
            legend: {
                show: true,
                position: 'bottom'
            },
            padding: {
                top: 10
            }
        });

        function formatMonth(d) {
            @foreach($graphics as $id => $item)
            if ('{{$id}}' == d) {
                return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
            }
            @endforeach
        }

        $(".sidebar-toggle").on("click",function () {
            setTimeout(function () {
                chart1.resize();
                chart2.resize();
            },200)
        });


    </script>
    @if(isset($type))
        <script type="text/javascript">
            var oTable;
            $(document).ready(function () {
                oTable = $('#data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    columns:[
                        {"data":"created_at"},
                        {"data":"company_name"},
                        {"data":"contact_name"},
                        {"data":"product_name"},
                        {"data":"email"},
                        {"data":"phone"},
                        {"data":"priority"},
                        {"data":"actions"}
                    ],
                    "ajax": "{{ url($type) }}" + ((typeof $('#data').attr('data-id') != "undefined") ? "/" + $('#id').val() + "/" + $('#data').attr('data-id') : "/data")
                });
                $('div.dataTables_length select').select2({
                    theme:"bootstrap"
                });
            });
        </script>
    @endif

@stop
