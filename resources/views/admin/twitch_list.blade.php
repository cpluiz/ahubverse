@extends('admin.base')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Usuários</h3>

                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{route('twitch_channel_edit', 0)}}" class="btn btn-success"><i class="fab fa-twitch"></i> Novo Canal</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="max-height: 66vh;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Channel Name</th>
                                <th></th>
                            </tr>
                            @foreach($channels as $channel)
                                <tr>
                                    <td>{{$channel->id}}</td>
                                    <td>{{$channel->channel_name}}</td>
                                    <td>
                                        <div class="btn-group float-right">
                                            <a href="{{route('twitch_channel_edit', $channel->id)}}" class="btn btn-success"><i class="fas fa-user-edit"></i></a>
                                            <button type="button" data-toggle="modal" data-channel_id="{{$channel->id}}" data-target="#confirmation-modal" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <div class="modal fade show" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Exclusão de canal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Essa ação vai remover permanentemente esse canal</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                    <a href="" data-url="{{route('twitch_channel_delete', '')}}" id="delete-channel" class="btn btn-outline-light">Confirmar</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@push('scripts')
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        bsCustomFileInput.init();
        $('#confirmation-modal').on('show.bs.modal', function(e){
            $('#delete-channel').attr('href', $('#delete-channel').data('url')+'/'+e.relatedTarget.dataset.channel_id);
        })
    });
</script>
@endpush
