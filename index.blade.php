@extends('layouts.app')

@section('title', '| '.__('permissions.users'))

@section('content')


<div class="container">
<div class="row">
<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-sitemap">  {{__('questions.organization')}}</i>  

    @role('Superadmin') 
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">{{__('permissions.permissions')}}</a>
    <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">{{__('permissions.roles')}}</a>
    @endrole
    </h1><hr>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{__('questions.name_person')}}</th>
                    <th>{{__('questions.group')}} </th>
                    <th>{{__('permissions.operations')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($organizations as $org)
                <tr>

                    <td>{{ $org->name }}</td>
                    <td>
                    @foreach ($org->groups as $group)
                        <b>{{ $group->name }}</b>: 
                        @foreach ($group->users as $user)
                            {{ $user->name }}, 
                        @endforeach
                        <p>
                    @endforeach
                    </td>
                    <td>
                    <a href="{{ route('organizations.edit', $org->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class='fa fa-pencil-square-o'></i></a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['organizations.destroy', $org->id] ]) !!}
                    @role('Superadmin')
                        <button type="submit" name="delete" formmethod="POST" class="btn btn-danger"><i class='fa fa-trash'></i></button>                    {!! Form::close() !!}
                    @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>


    <a href="{{ route('organizations.create') }}" class="btn btn-success">{{__('permissions.add_org')}}</a>

</div>

</div>
</div>

@endsection