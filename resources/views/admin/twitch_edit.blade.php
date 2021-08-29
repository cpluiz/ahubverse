@extends('admin.base')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form enctype="multipart/form-data" method="post" target="_self" id="userForm" action="{{route('twitch_channel_save', $channel->id ?? 0)}}" class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Editing Twitch Channel Info</h3>
                        <!-- /.card-header -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($errors->any())
                                <div class="alert alert-danger col-12">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{csrf_field()}}
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Twitch Channel User Name</label>
                                    <input type="text" id="channel_name" name="channel_name" class="form-control" placeholder="Channel User" value="{{old('name', $channel->channel_name)}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Linked to User</label>
                                    <select class="form-control" name="user_id">
                                        @foreach($users as $user)
                                            <option @if($user->id == $channel->user_id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- card footer -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <a href="{{route('users')}}" class="btn btn-default float-right">Cancelar</a>
                    </div>
                    <textarea name="follow_suggestions" id="suggestions_field" class="d-none">{{$channel->follow_suggestions}}</textarea>
                    <textarea name="ignore_users" id="ignore_field" class="d-none">{{$channel->ignore_users}}</textarea>
                    <!-- /.card footer -->
                </form>
                <!-- /.card -->
                @if($channel->id > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Follow Sugestions</h3>
                        <!-- /.card-header -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        <input id="streamer" type="text" class="form-control">
                                        <span class="input-group-append">
                                            <span class="btn btn-info btn-flat" id="add_suggestion">Adicionar a lista</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <tbody id="suggestion_list">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users to ignore</h3>
                        <!-- /.card-header -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 pb-3">Ignored users or stream bots</div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        <input id="ignore" type="text" class="form-control">
                                        <span class="input-group-append">
                                        <span class="btn btn-info btn-flat" id="add_ignore">Adicionar a lista</span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <tbody id="ignore_list">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        window.follow_suggestions = [];
        window.ignore_users = [];
        window.followTable = document.getElementById("suggestion_list");
        window.ignoreTable = document.getElementById("ignore_list");
        window.followField = document.getElementById('suggestions_field');
        window.ignoreField = document.getElementById('ignore_field');

        let createEntry = function(prefix, userName, elementList, parentElement, contentField, removeFunction){
            debugger;
            userName = userName.replaceAll(' ', '');
            if(elementList.includes(userName))
                return;
            let line = document.createElement('tr');
            line.setAttribute('id', prefix+userName);
            let first_collum = document.createElement('td');
            let second_collum = document.createElement('td');
            let streamerChannel = document.createElement('span')
            streamerChannel.innerText = userName;
            first_collum.appendChild(streamerChannel);
            let btngroup = document.createElement('div')
            btngroup.setAttribute('class', 'btn-group float-right');
            let btndelete = document.createElement('span')
            btndelete.setAttribute('class', 'btn btn-danger');
            btndelete.setAttribute('onclick', removeFunction+'("'+userName+'");');
            let deleticon = document.createElement('i')
            deleticon.setAttribute('class', 'fas fa-trash');
            btndelete.appendChild(deleticon);
            btngroup.appendChild(btndelete);
            second_collum.appendChild(btngroup)
            line.appendChild(first_collum);
            line.appendChild(second_collum);
            parentElement.appendChild(line);
            elementList.push(userName);
            contentField.innerText = JSON.stringify(elementList);
        }
        window.removeFollowerSuggestion = function(follow_user){
            follow_suggestions = follow_suggestions.filter(function(item) {
                return item !== follow_user
            });
            let itemToRemove = document.getElementById('ttv_'+follow_user);
            followTable.removeChild(itemToRemove);
            delete(itemToRemove);
            followField.innerText = JSON.stringify(follow_suggestions);
        }
        window.removeIgnored = function(userName){
            ignore_users = ignore_users.filter(function(item) {
                return item !== userName
            });
            let itemToRemove = document.getElementById('ign_'+userName);
            ignoreTable.removeChild(itemToRemove);
            delete(itemToRemove);
            ignoreField.innerText = JSON.stringify(ignore_users);
        }
        let auxList = [];

        if(followField.innerText.length > 0)
            auxList = JSON.parse(followField.innerText);
        for(let i = 0; i < auxList.length; i++)
            createEntry('ttv_', auxList[i], follow_suggestions, followTable, followField, 'removeFollowerSuggestion');

        auxList = [];
        if(ignoreField.innerText.length > 0)
            auxList = JSON.parse(ignoreField.innerText);
        for(let i = 0; i < auxList.length; i++)
            createEntry('ign_', auxList[i], ignore_users, ignoreTable, ignoreField, 'removeIgnored');

        $('#add_suggestion').on('click', function(){
            if($('#streamer').val().length > 0)
                createEntry('ttv_', $('#streamer').val(), follow_suggestions, followTable, followField, 'removeFollowerSuggestion');
            $('#streamer').val('');
        })
        $('#add_ignore').on('click', function(){
            if($('#ignore').val().length > 0)
                createEntry('ign_', $('#ignore').val(), ignore_users, ignoreTable, ignoreField, 'removeIgnored');
            $('#ignore').val('');
        })
    });
</script>
@endpush
