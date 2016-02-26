@extends('app')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="glyphicon glyphicon-filter"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Total Balance</h4>

                                <div class="info">
                                    <strong class="amount">{{$total_balance}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="glyphicon glyphicon-time"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Last Reload Time</h4>

                                <div class="info">
                                    <strong class="amount time">{{$last_reload_time}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary widget-summary-sm">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="glyphicon glyphicon-upload"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Last Reload Amount</h4>

                                <div class="info">
                                    <strong class="amount">{{$last_reload_amount}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <div class="row">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Sms Status</h2>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed mb-none">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Timestamp</th>
                            <th class="text-center">Change</th>
                            <th class="text-center">Note</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                <td id="sms_transaction_log_id">#{{1024 + $item->id}}</td>
                                <td class="text-center">{{$item->created_at}}</td>
                                <td id="sms_transaction_log_change" class="text-center">{{$item->delta}}</td>
                                <td id="sms_transaction_log_note">{{$item->note}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $list->render() !!}
                </div>
            </div>
        </section>
    </div>
@endsection
