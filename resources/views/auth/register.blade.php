@extends('layouts.app')

@section('content')
    <div class="wrapper-page">
        <div class="panel panel-color panel-primary panel-pages">
            <div class="panel-body">
                <h3 class="text-center m-t-0 m-b-30">
                    <span class=""><img src="images/logopt.png" alt="logo" height="100"></span>
                </h3>
                <h4 class="text-muted text-center m-t-0"><b>Sign Up</b></h4>
                <div class="card-body p-2">
                    <form method="POST" action="{{ route('register') }}" class="form-horizontal m-t-20">
                        @csrf

                        <div class="form-group">
                            <div class="mb-3">
                                <input id="" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" placeholder="User ID">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="mb-3">
                                <input id="emailbaru" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="emailbaru"
                                    value="{{ old('') }}" required autocomplete="email" placeholder="Email">

                                @error('')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <div class="input-group input-group-merge">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="Password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <div class="input-group input-group-merge">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm Password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div> @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <?php
                        
                        use App\Models\RuangRapat;
                        use App\Models\Divisi;
                        use App\Models\PegawaiAbsen;
                        
                        $ruangRapat = RuangRapat::all();
                        $divisi = Divisi::all();
                        $peserta_rapat = PegawaiAbsen::all();
                        ?>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="">Pilih Role</label>

                                <select name="role" id="role" class="form-control" onchange="showDiv(this)">
                                    <option value="2">Super Admin</option>
                                    <option value=" 1">Admin</option>
                                    <option value="3">User</option>
                                    <option value="4">Peserta</option>
                                </select>
                                @error('')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <select name="adminRuangan" id="adminRuangan" class="kondisi form-control"
                                    style="display:none ;">
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($ruangRapat as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <select name="divisiRapat" id="divisiRapat" class="kondisi form-control"
                                    style="display:none ;">
                                    <option value="">Pilih Peserta</option>
                                    @foreach ($peserta_rapat as $pr)
                                        <option value="{{ $pr->id }}">{{ $pr->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <div class="mb-3">
                                <select name="divisiRapat" id="divisiRapat" class="kondisi form-control"
                                    style="display:none ;">
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($divisi as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary w-md waves-effect waves-light"
                                    type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script text="type/javascript">
        //Fungsi untuk membuat select hidden
        function showDiv(select) {
            if (select.value == 1) {
                document.getElementById('adminRuangan').style.display = "block";
                // block :menampilkan id terkait
                document.getElementById('divisiRapat').style.display = "none";
                // none : menyembukan id terkait
            } else if (select.value == 3) {
                document.getElementById('adminRuangan').style.display = "none";
                document.getElementById('divisiRapat').style.display = "block";
            } else if (select.value == 4) {
                document.getElementById('adminRuangan').style.display = "none";
                document.getElementById('divisiRapat').style.display = "none";
                // document.getElementById('peserta_rapat').style.display = "block";

            } else {
                document.getElementById('adminRuangan').style.display = "none";
                document.getElementById('divisiRapat').style.display = "none";
                // get element by id : menampilkan elemen berdasarkan id nya
            }
        }
    </script>
    <script>
        // Menangkap elemen select
        var selectDivisi = document.getElementById('divisiRapat');

        // Menambahkan event listener pada perubahan pemilihan opsi
        selectDivisi.addEventListener('change', function() {
            // Mendapatkan nilai opsi yang dipilih
            var selectedOption = selectDivisi.options[selectDivisi.selectedIndex].value;

            // Jika opsi yang dipilih adalah "Pilih Divisi"
            if (selectedOption === "") {
                // Menonaktifkan tombol registrasi
                document.getElementById('tombolRegistrasi').disabled = true;
            } else {
                // Mengaktifkan tombol registrasi
                document.getElementById('tombolRegistrasi').disabled = false;
            }
        });
    </script>

    <!-- onchange, atribute js ketika ada perubahan event,maka menjalankan fungsi showdiv -->
    <!-- id tidak boleh bentrok -->

    <!-- style :none, : untuk menyembukian inputan select -->
    <!-- id tidak boleh bentrok -->
@endsection
