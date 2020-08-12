<div class="col-md-3 col-3 p-0" id="clubStatus{{ $shift->id }}">
    @include("partials.shiftStatus")
</div>

@if( is_null($shift->getPerson) )
    {!! Form::text('userName' . $shift->id,
                 Input::old('userName' . $shift->id),
                 array('placeholder'=>'=FREI=',
                       'id'=>'userName' . $shift->id,
                       'class'=>'col-8 col-md-8 ',
                       'autocomplete'=>'off'))
    !!}
@else

    {!! Form::text('userName' . $shift->id,
                 $shift->getPerson->prsn_name,
                 array('id'=>'userName' . $shift->id,
                       'class'=>'col-8 col-md-8',
                       'data-toggle' => "tooltip",
                       'data-placement' =>"top",
                       'title' => $shift->getPerson->fullName(),
                        'autocomplete'=>'off') )
    !!}
@endif

{{-- Show dropdowns only for members --}}
@auth
    <ul class="dropdown-menu dropdown-username" style="position: absolute;">
        <li class="dropdown-item" id="yourself">
            <a href="javascript:void(0);"
               onClick="document.getElementById('userName{{ ''. $shift->id }}').value='{{Auth::user()->name}}';
                       document.getElementById('club{{ ''. $shift->id }}').value='{{Lara\Section::current()->title}}';
                       document.getElementById('ldapId{{ ''. $shift->id }}').value='{{Auth::user()->person->prsn_ldap_id}}';
                       document.getElementById('btn-submit-changes{{ ''. $shift->id }}').click();">
                <b>{{ trans('mainLang.IDoIt') }}</b>
            </a>
        </li>
    </ul>
@endauth

<div>
    @if( is_null($shift->getPerson) )
        {!! Form::hidden('ldapId' . $shift->id,
                         '',
                         array('id'=>'ldapId' . $shift->id) )
        !!}
    @else
        {!! Form::hidden('ldapId' . $shift->id,
                         $shift->getPerson->prsn_ldap_id,
                         array('id'=>'ldapId' . $shift->id) )
        !!}
    @endif
</div>

<div>
        {!! Form::hidden('timestamp' . $shift->id,
                         $shift->updated_at,
                         array('id'=>'timestamp' . $shift->id) )
        !!}
</div>
