@extends('master')

<?php $buildings = Buildings::all(); ?>



@section('content')

    <div class="row">
        @if (isset($message))
            <div class="large-12 columns alert-box success">
                {{ $message; }}
            </div>
        @endif

        <div class="large-12 columns buildingsIndex">
                <div class="large-12 columns">
                    <h3>Pregled objektov</h3>
                    <span class="right" style="clear: both;"><a id="modalLink" data-bid="/buildings/create" class="tiny button"><i class="fi-plus"></i> Nov objekt</a></span>
                </div>

                <div class="large-12 columns building-table">
                    <table>
                        <thead>
                        <tr>
                            <td></td>
                            <td>Šifra</td>
                            <td>Naziv</td>
                            <td>Upravnik</td>
                            <td>Tip</td>
                            <td>Naslov</td>
                            <td>Št. najemnikov</td>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $num = 1; ?>
                            @foreach ($buildings as $building)
                                <?php
                                // find building manager
                                $manager = Managers::where('buildingCode',$building->buildingCode)->first();
                                        if (count($manager)) { $manager = User::where('partnerCode',$manager->partnerCode)->first(); }
                                ?>
                                <tr>
                                    <td>{{ $num }}</td>
                                    <td>{{ $building->buildingCode }}</td>
                                    <td><a id="modalLink" data-bid="/buildings/edit/{{ $building->id }}">{{ $building->name }}</a></td>
                                    <td>@if (count($manager)) <a id="modalLink" data-bid="/users/edit/{{ $manager->id }}">{{ $manager->name }} {{ $manager->lastName }} ({{ $manager->companyName }})</a> @endif</td>
                                    <td>@if ($building->type == 2) Poslovni objekt @elseif ($building->type == 1) Stanovanjski objekt @else - @endif</td>
                                    <td>@if ($building->street !== '') {{ $building->street }} {{ $building->houseNumber }}, {{ $building->city }}@endif</td>
                                    <td>{{ User::where('group', $building->buildingCode)->count(); }}</td>
                                </tr>
                                <?php $num += 1; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@stop