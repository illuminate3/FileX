@extends ('master')

<?php
    $documents = Documents::orderBy('group')->get();
    $group = '';
    $num = 1;
?>


@section('content')
    <div class="row documentsIndex">
        @if (isset($message))
            <div class="large-12 columns alert-box success" style="margin-top: 20px; margin-bottom: 0px;">
                {{ $message; }}
            </div>
        @endif

        <div class="large-12 columns">
            <h3>Pregled dokumentov</h3>
        </div>

        <div class="right large-12 columns" style="text-align: right;"><a id="modalLink" data-bid="/documents/add" class="tiny button"><i class="fi-plus"></i>Nov dokument</a></div>

            <div class="large-12 columns document-table">
            <table>
                <thead>
                    <tr>
                        <td></td>
                        <td>Mapa</td>
                        <td>Naziv</td>
                        <td>Avtor</td>
                        <td>Tip</td>
                        <td>Objekt</td>
                        <td>Status</td>
                        <td>Dodan</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <?php $timestamp = strtotime($document->created_at); $datetime = date("d. m. Y (H:i:s)", $timestamp); ?>
                        @if ($document->group == $group)
                            <tr>
                                <td>{{ $num }}</td>
                                <td></td>
                                <td>{{ $document->name }}</td>
                                <td>{{ User::find($document->owner)->name }} {{ User::find($document->owner)->lastName }}</td>
                                <td>{{ $document->extension }}</td>
                                <td>{{ Buildings::where('id',(Folders::where('id',$document->group)->pluck('group')))->pluck('name') }}</td>
                                <td>{{ $document->visibility }}</td>
                                <td>{{ $datetime }}</td>
                            </tr>
                        @else
                            <?php $group = $document->group; ?>
                            <tr>
                                <td>{{ $num }}</td>
                                <td>{{ Folders::where('id', $document->group)->pluck('name') }}</td>
                                <td>{{ $document->name }}</td>
                                <td>{{ User::find($document->owner)->name }} {{ User::find($document->owner)->lastName }}</td>
                                <td>{{ $document->extension }}</td>
                                <td>{{ Buildings::where('id',(Folders::where('id',$document->group)->pluck('group')))->pluck('name') }}</td>
                                <td>{{ $document->visibility }}</td>
                                <td>{{ $datetime }}</td>
                            </tr>
                        @endif
                        <?php $num += 1; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop