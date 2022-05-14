@extends('layouts.app', ['title' => 'Jenis Obat'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Jenis Obat</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Data Jenis Obat</h4>
        </div>
        <div class="card-body">
          <button class="btn btn-primary mb-3" data-target="#modal-tambah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Jenis Obat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($jenis_obat as $j_obat)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $j_obat->jenis_obat }}</td>
                    <td>
                      <button class="btn btn-info btn-sm" onclick="edit_data({{ $j_obat->id }}, '{{ $j_obat->jenis_obat }}')" data-toggle="tooltip" data-placement="left" title="Edit">
                        <i class="fa fa-pencil-alt"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" onclick="delete_data({{ $j_obat->id }})" data-toggle="tooltip" data-placement="left" title="Hapus"><i class="fa fa-trash"></i></button>
                      <form action="/jenis_obat/{{ $j_obat->id }}/delete" method="POST" id="form-edit-{{ $j_obat->id }}">
                        @csrf
                        @method('delete')
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" class="text-center">Data Kosong</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-2">
            {{ $jenis_obat->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jenis Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('jenis_obat.store') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="">Jenis Obat</label>
            <input type="text" name="jenis_obat" class="form-control">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Jenis Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('jenis_obat.edit') }}">
        @csrf
        @method('put')
        <input type="hidden" name="id" id="edit-id-obat">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Jenis Obat</label>
            <input type="text" name="jenis_obat" class="form-control" id="edit-jenis-obat">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  
  function edit_data(id, jenis_obat) {
    $(`#edit-id-obat`).val(id)
    $(`#edit-jenis-obat`).val(jenis_obat)

    $(`#modal-edit`).modal('toggle')
  }

  function delete_data(id) {
    swal({
      title: 'Apakah Anda Yakin?',
      text: 'Ingin Menghapus Data Ini!',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $(`#form-edit-${id}`).submit()
      }
    });
  }

</script>

@stop