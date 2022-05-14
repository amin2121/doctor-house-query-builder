@extends('layouts.app', ['title' => 'Dokter'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Dokter</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Data Dokter</h4>
        </div>
        <div class="card-body">
          <button class="btn btn-primary mb-3" data-target="#modal-tambah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Dokter</th>
                  <th>Alamat</th>
                  <th>No Telp</th>
                  <th>Spesialis</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($dokter as $dkr)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dkr->nama_dokter }}</td>
                    <td>{{ $dkr->alamat }}</td>
                    <td>{{ $dkr->no_telp }}</td>
                    <td>{{ $dkr->spesialis }}</td>
                    <td>
                      <button class="btn btn-info btn-sm" onclick="edit_data({{ $dkr->id }}, '{{ $dkr->nama_dokter }}', '{{ $dkr->alamat }}', '{{ $dkr->no_telp }}', '{{ $dkr->spesialis }}')" data-toggle="tooltip" data-placement="left" title="Edit">
                        <i class="fa fa-pencil-alt"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" onclick="delete_data({{ $dkr->id }})" data-toggle="tooltip" data-placement="left" title="Hapus"><i class="fa fa-trash"></i></button>
                      <form action="/dokter/{{ $dkr->id }}/delete" method="POST" id="form-edit-{{ $dkr->id }}">
                        @csrf
                        @method('delete')
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center">Data Kosong</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-2">
            {{ $dokter->links() }}
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
        <h5 class="modal-title">Tambah Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('dokter.store') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama-dokter">Nama Dokter</label>
            <input type="text" name="nama_dokter" class="form-control" id="nama-dokter">
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" class="form-control" id="alamat">
          </div>
          <div class="form-group">
            <label for="no-telp">No Telp</label>
            <input type="text" name="no_telp" class="form-control" id="no-telp">
          </div>
          <div class="form-group">
            <label for="spesialis">Spesialis</label>
            <input type="text" name="spesialis" class="form-control" id="spesialis">
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
        <h5 class="modal-title">Edit Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('dokter.edit') }}">
        @csrf
        @method('put')
        <input type="hidden" name="id" id="edit-id-dokter">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit-nama-dokter">Nama Dokter</label>
            <input type="text" name="nama_dokter" class="form-control" id="edit-nama-dokter">
          </div>
          <div class="form-group">
            <label for="edit-alamat">Alamat</label>
            <input type="text" name="alamat" class="form-control" id="edit-alamat">
          </div>
          <div class="form-group">
            <label for="edit-no-telp">No Telp</label>
            <input type="text" name="no_telp" class="form-control" id="edit-no-telp">
          </div>
          <div class="form-group">
            <label for="edit-spesialis">Spesialis</label>
            <input type="text" name="spesialis" class="form-control" id="edit-spesialis">
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
  
  function edit_data(id, nama_dokter, alamat, no_telp, spesialis) {
    $(`#edit-id-dokter`).val(id)
    $(`#edit-nama-dokter`).val(nama_dokter)
    $(`#edit-alamat`).val(alamat)
    $(`#edit-no-telp`).val(no_telp)
    $(`#edit-spesialis`).val(spesialis)

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