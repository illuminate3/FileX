@extends ('master')

<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 29. 06. 15
 * Time: 11.29
 */

$notes = Notes::all();
        $num = 1;
?>

<script>

</script>

@section ('content')
<div class="row notesIndex">
    @if (isset($message))
        <div class="large-12 columns alert-box success" style="margin-top: 20px; margin-bottom: 0px;">
            {{ $message; }}
        </div>
    @endif

    <div class="large-12 columns">
        <h3>Seznam obvestil</h3>
    </div>

    <div class="right large-12 columns" style="text-align: right;"><a id="modalLink" data-bid="/notes/add" class="tiny button"><i class="fi-plus"></i> Novo obvestilo</a></div>

        <div class="large-12 columns document-table">
            <table>
                <thead>
                <tr>
                    <td></td>
                    <td>Naziv</td>
                    <td>Avtor</td>
                    <td>Objekt</td>
                    <td>Status</td>
                    <td>Dodan</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($notes as $note)
                    <tr>
                        <td>{{ $num }}</td>
                        <td><a id="modalLink" href="" data-bid="/notes/edit/{{ $note->id }}">{{ $note->name }}</a></td>
                        <td>{{ User::find($note->owner)->name }} {{ User::find($note->owner)->lastName }}</td>
                        <td>{{ Buildings::where('buildingCode', $note->group)->pluck('name') }}</td>
                        <td>{{ $note->visibility }}</td>
                        <td>{{ $note->created_at }}</td>
                    </tr>
                    <?php $num += 1; ?>
                @endforeach
                </tbody>
            </table>
        </div>
</div>
@stop