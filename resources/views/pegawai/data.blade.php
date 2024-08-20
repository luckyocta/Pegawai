@extends('layout')
@section('title', 'Pegawai')
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class ="col-12">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="ms-auto me-auto mt-3">Data Pegawai</h1>
        <form action="{{ route('pegawai.data') }}" method="GET" class="mb-3 form-inline">
            <div class="input-group">
                <input class="form-control mr-sm-2" type="search" name="search"
                    placeholder="Cari nama, alamat, atau no hp" value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
            </div>
        </form>
        <button class="mb-3 float-end btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Tambah
            Pegawai</button>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>

                    <th class="sortable" data-sort="asc">
                        Name
                        <a href="/sort/{{ isset($sort) ? $sort : 'asc', 'des' }}" class="sort-link"
                            onclick="sortTable(event, this, 0)">
                            <span class="sort-arrow asc"></span>
                            {{-- <th><a href="/sort/{{ isset($sort) ? $sort : 'asc', 'des' }}">Nama
                            </th> --}}
                    <th>
                        Alamat
                    </th>
                    <th>
                        No HP
                    </th>
                    <th>
                        Tanggal Lahir
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai as $pegawai)
                    <tr>

                        <td>{{ $pegawai->nama }}</td>
                        <td>{{ $pegawai->alamat }}</td>
                        <td>{{ $pegawai->nohp }}</td>
                        <td>{{ $pegawai->birthday }}</td>
                        <td width="150px">
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editEmployeeModal-{{ $pegawai->id }}">Edit</button>
                            <form action="{{ route('pegawai.delete', $pegawai->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Hapus Data Pegawai Ini ?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="editEmployeeModal-{{ $pegawai->id }}" tabindex="-1"
                        aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('pegawai.edit', $pegawai->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="nama-{{ $pegawai->id }}" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama-{{ $pegawai->id }}"
                                                name="nama" value="{{ $pegawai->nama }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat-{{ $pegawai->id }}" class="form-label">alamat</label>
                                            <input type="text" class="form-control" id="alamat-{{ $pegawai->id }}"
                                                name="alamat" value="{{ $pegawai->alamat }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nohp-{{ $pegawai->id }}" class="form-label">No HP</label>
                                            <input type="nohp" class="form-control" id="nohp-{{ $pegawai->id }}"
                                                name="nohp" value="{{ $pegawai->nohp }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="birthday-{{ $pegawai->id }}" class="form-label">Tanggal
                                                Lahir</label>
                                            <input type="text" class="form-control" id="birthday-{{ $pegawai->id }}"
                                                name="birthday" value="{{ $pegawai->birthday }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Tambah Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm" action="{{ route('pegawai.temp') }}" method="POST">
                        @csrf
                        {{-- <div class="mb-3">
                            <label for="profile" class="form-label">Photo Profile</label>
                            <div class="clsbox-1" runat="server">
                                <div class="dropzone clsbox" id="profile" name="profile"></div>
                            </div> --}}
                        {{-- <label for="profile" class="form-label">Photo Profile</label>
                            <input type="text" class="form-control" id="profile" name="profile" required> --}}

                        <div class="mb-3">
                            <label for="nama" class="form-label">Name</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="nohp" class="form-label">No HP</label>
                            <input type="number" class="form-control" id="nohp" name="nohp" required>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" name="birthday" required />
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
