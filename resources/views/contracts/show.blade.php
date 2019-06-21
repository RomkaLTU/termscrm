@extends('layouts.app')

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutartis') }}: <strong>{{ $contract->contract_nr }}</strong> &nbsp;
                    @hasrole('Admin')
                        <a href="{{ route('contracts.edit', $contract->id) }}"><i class="fas fa-edit"></i></a>
                    @endhasrole
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="objektaiBtn" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Objektai') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="objektaiBtn">
                            <a class="dropdown-item" href="{{ route('contracts.objects.index', $contract->id) }}">{{ __('Sutarties objektai') }}</a>
                            <a class="dropdown-item" href="{{ route('contracts.objects.create', $contract->id) }}">{{ __('Pridėti objektą') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-6">
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <table class="table table-borderless inner-table">
                                <tbody>
                                <tr>
                                    <th scope="row" class="bg-light">Sutarties numeris: </th>
                                    <td>{{ $contract->contract_nr }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Sutarties statusas: </th>
                                    <td>{{ $contract->contract_status }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Adresas:</th>
                                    <td>{{ $contract->customer_address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Užsakovas:</th>
                                    <td>{{ $contract->customer }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Galiojimas:</th>
                                    <td>{{ $contract->validity_value }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Pratęsti iki:</th>
                                    <td>{{ $contract->validity_extend_till_value }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Žodinė:</th>
                                    <td>{{ $contract->validity_verbal ? 'Taip' : 'Ne' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Tyrimų sritys:</th>
                                    <td>
                                        @foreach($research_areas as $ra)
                                            <span class="kt-badge kt-badge--primary kt-badge--md kt-badge--inline kt-badge--pill mr-2 mb-1">
                                                {{ $ra->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                </tr>
                                @hasrole('Admin')
                                <tr>
                                    <th scope="row" class="bg-light">Sutarties suma:</th>
                                    <td>{{ $contract->contract_value }}</td>
                                </tr>
                                @endhasrole
                                @hasrole('Admin')
                                    <tr>
                                        <th scope="row" class="bg-light">Sąskaitos:</th>
                                        <td>
                                            <div class="kt-list-timeline">
                                                <div class="kt-list-timeline__items">
                                                    @foreach($contract->invoices as $invoice)
                                                        <div class="kt-list-timeline__item">
                                                            <span class="kt-list-timeline__badge"></span>
                                                            <span class="kt-list-timeline__text">
                                                                Sąsk. nr. {{ $invoice->id }} Suma {{ $invoice->total }} {{ $invoice->status ? 'Apmokėta' : 'Neapmokėta' }}
                                                            </span>
                                                            <span class="kt-list-timeline__time">{{ $invoice->updated_at }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endhasrole
                                @hasrole('Admin')
                                <tr>
                                    <th scope="row" class="bg-light">Dokumentai:</th>
                                    <td>
                                        @foreach($documents as $document)
                                            <div>
                                                <a href="{{ $document['url'] }}" target="_blank">{{ $document['name'] }}</a>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endhasrole
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
