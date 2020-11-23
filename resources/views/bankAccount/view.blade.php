@extends('layouts.appNew')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Details</h6></div>
                <div class="card-body">
                    <p class="font-weight-bold text-primary m-0">Durschnitt</p>
                    <table>
                        <tbody>
                        <tr>
                            <td class="font-weight-bold">Kontostand</td>
                            <td>${{ number_format($bankAccount->getAverageBalanceValue(), 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Differenz ($)</td>
                            <td>
                                ${{ number_format($bankAccount->getAverageBalanceDifferenceDollar(), 2, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Differenz (%)</td>
                            <td>
                                {{ number_format($bankAccount->getAverageBalanceDifferencePercentage(), 2, ',', '.') }}%
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="accordion" id="chartAccordion">
                <div class="card shadow mb-4">
                    <div class="card-header" id="chartHeading">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#chartBody">
                            Chart
                        </h6>
                    </div>
                    <div id="chartBody" class="collapse" aria-labelledby="chartHeading"
                         data-parent="#chartAccordion">
                        <div class="card-body">
                            <div id="balanceChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @can('viewAny', \App\Models\BankAccount\Goal::class)
            <div class="col-sm-8">
                <div class="card shadow mb-4">
                    <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Ziele</h6></div>
                    <div class="card-body">
                        <livewire:bank-account.display-goals :bankAccount="$bankAccount"/>
                    </div>
                </div>
            </div>
        @endcan

        @can('create', \App\Models\BankAccount\Goal::class)
            <div class="col-sm-4">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Ziel erstellen
                        </h6>
                    </div>
                    <div class="card-body">
                        <livewire:bank-account.create-goal :bankAccount="$bankAccount"/>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="card shadow mb-4">
                <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Kontostände</h6></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Erfasst am</th>
                                <th>Kontostand</th>
                                <th>Differenz ($)</th>
                                <th>Differenz (%)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($balances as $balance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($balance->captured)->format('d.m.Y') }}</td>
                                    <td>${{ number_format($balance->value, 2, ',', '.') }}</td>
                                    <td @if($balance->differenceDollar > 0) style="color: green;"
                                        @elseif($balance->differenceDollar < 0) style="color: red;" @endif>
                                        ${{ number_format($balance->differenceDollar, 2, ',', '.') }}
                                    </td>
                                    <td @if($balance->differencePercentage > 0) style="color: green;"
                                        @elseif($balance->differencePercentage < 0) style="color: red;" @endif>
                                        {{ number_format($balance->differencePercentage, 2, ',', '.') }}%
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @can('create', $bankAccount)
            <div class="col-sm-4">
                <div class="card shadow mb-4">
                    <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Kontostand erfassen</h6>
                    </div>
                    <div class="card-body">
                        <livewire:bank-account.create-balance :bankAccount="$bankAccount"/>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@section('customJS')
    <script type="text/javascript">
        $(document).ready(function () {
            Highcharts.setOptions({
                lang: {
                    decimalPoint: ',',
                    thousandsSep: '.',
                    months: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],
                    shortMonths: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
                    weekdays: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
                    shortWeekdays: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"]
                }
            });

            Highcharts.getJSON('/api/bankAccount/{{ $bankAccount->id }}/balances',
                function (data) {
                    Highcharts.chart('balanceChart', {
                        title: {
                            text: 'Kontostände'
                        },
                        chart: {
                            type: 'line',
                            zoomType: 'x'
                        },
                        yAxis: {
                            id: 'yA0',
                            title: {
                                enabled: true,
                                text: 'Kontostand'
                            }
                        },
                        xAxis: {
                            id: 'xA0',
                            allowDecimals: false,
                            type: 'datetime',
                            title: {
                                enabled: true,
                                text: 'Datum'
                            }
                        },
                        navigator: {
                            enabled: true
                        },
                        legend: {
                            enabled: false,
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        plotOptions: {
                            series: {
                                cursor: 'pointer',
                                label: {
                                    enabled: false,
                                    connectorAllowed: false
                                }
                            }
                        },
                        series: [
                            {
                                name: 'Kontostand',
                                type: 'line',
                                showInLegend: true,
                                dataLabels: {
                                    enabled: false
                                },
                                data: data['line'],
                                color: 'darkgreen'
                            },
                            {
                                name: 'Umsatz',
                                type: 'column',
                                showInLegend: true,
                                dataLabels: {
                                    enabled: false
                                },
                                data: data['column'],
                                color: '#4275f5'
                            }
                        ],
                        tooltip: {
                            pointFormat: '<span style="color:{point.color};">\u25CF</span> {series.name}: <b>$ {point.y:,.2f}</b><br/>'
                        },
                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        },
                        time: {
                            useUTC: false
                        }
                    });
                }
            )
        });
    </script>
@endsection