<li><a class="edit_pegawai" data-id="{{$p->id}}">Edit</a></li>












<div class="modal fade" id="modal_ePegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel-1">Ubah Target</h4>
            </div>
            <div class="modal-body">

                <form method="post" action="{{route('pegawai_update')}}" onkeydown="return event.key != 'Enter';">
                    @csrf
                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input id="namaPegawai" type="text" name="namaPegawai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="jabatan" class="form-control" id="jabatan">
                            <option value="">- Pilih Jabatan</option>
                            <option value="1">Manajer</option>
                            <option value="2">SPV</option>
                            <option value="3">Staff</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="idPegawai" id="idPegawai" value="">
                        <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>