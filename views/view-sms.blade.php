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
                @include('elements.error-message-partial')
                @include('elements.success-message-partial')

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#sent">Sent</a></li>
                    <li><a data-toggle="tab" href="#pending">Pending</a></li>
                </ul>

                <div class="tab-content">
                    <div id="sent" class="tab-pane fade in active">
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
                    <div id="pending" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="{{ url('sms-management/delete-all') }}">
                                    {{ csrf_field() }}
                                    <button id="delete_all_pending_notification_button" class="btn btn-danger pull-right delete_with_confirm"><i class="fa fa-trash"></i> Delete all pending notification</button>
                                </form>
                                <br>
                                <br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-condensed mb-none">
                                        <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">From</th>
                                            <th class="text-center">To</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Route</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingItems as $pendingItem)
                                                <tr>
                                                    <td>{{ $pendingItem->id }}</td>
                                                    <td>@link($pendingItem->fromUser)</td>
                                                    <td>@link($pendingItem->toUser)</td>
                                                    <td>{{ $pendingItem->toUser->phone }}</td>
                                                    <td>{{ $pendingItem->route }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {!!  $pendingItems->render()  !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
