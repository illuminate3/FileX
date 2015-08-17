@extends('master')


@section('content')
    <div class="large-12 columns">
        <h2>Nova stranka</h2>

        {{ Form::open (['route' => 'users.store']) }}
        <div class="row">
            <div class="large-12 columns">
                {{ Form::label('podjetje', 'Podjetje') }}
                {{ Form::text('podjetje', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="row">
            <div class="large-5 columns left">
                {{ Form::label('ime', 'Ime') }}
                {{ Form::text('ime', null, ['class' => 'form-control']) }}
            </div>
            <div class="large-5 columns left">
                {{ Form::label('priimek', 'Priimek') }}
                {{ Form::text('ime', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="row">
            <div class="large-5 columns left">
                {{ Form::label('naslov', 'Naslov (ulica + hišna številka') }}
                {{ Form::text('naslov', null) }}
            </div>
            <div class="large-3 columns left">
                {{ Form::label('posta', 'Pošta') }}
                {{ Form::text('posta', null) }}
            </div>
            <div class="large-3 columns left">
                {{ Form::label('posta-st', 'Poštna št.') }}
                {{ Form::text('posta-st', null) }}
            </div>
        </div>

        <div class="row">
            <div class="large-4 columns">
                {{ Form::label('email', 'E-pošta') }}
                {{ Form::text('email', null) }}
            </div>
            <div class="large-4 columns">
                {{ Form::label('tel', 'Telefon') }}
                {{ Form::text('tel') }}
            </div>
            <div class="large-4 columns">
                {{ Form::label('fax', 'Telefaks') }}
                {{ Form::text('fax') }}
            </div>
        </div>

        <div class="row">
            <fieldset>
                <legend>Podatki o objektu</legend>
                <div class="large-5 columns">
                    {{ Form::label('objekt', 'Najemnik v objektu') }}
                    {{ Form::select('objekt') }}
                </div>
                <div class="large-3 columns left">
                     {{ Form::label('enota','Enota') }}
                     {{ Form::text('enota') }}
                </div>
                <div class="large-3 columns left">
                    {{ Form::label('pogodba','Številka pogodbe') }}
                    {{ Form::text('pogodba') }}
                </div>
            </fieldset>

            <fieldset>
                <legend>Povezane datoteke</legend>

            </fieldset>
        </div>

        <div class="row">
            <div class="large-4 left columns">
                {{ Form::label('datoteka', 'Dodaj datoteko') }}
                {{ Form::file('datoteka') }}
            </div>
        </div>

        <div class="large-12 columns center">
            <input type="submit" class="button" value="Shrani">
        </div>

        {{ Form::close() }}
    </div>
@stop
