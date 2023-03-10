@extends('layouts.app')

@section('scripts')

@role('satgas')
@vite(['resources/js/satgas.js'])
@endrole

@role('setkab')
@vite(['resources/js/setkab.js'])
@endrole

@role('walidata')
@vite(['resources/js/renaksi.js'])
@endrole

@endsection

@section('content')
<label for="my-modal-5" class="hidden" id="toggle-modal"></label>
<table id="mainTable" class="w-full"></table>
@endsection

@section('outside')
@role('walidata')
<input type="checkbox" id="my-modal-5" class="modal-toggle" />
<div class="modal">
    <div class="modal-box w-11/12 max-w-5xl">
        <h3 class="font-bold text-lg" id="reportTitle"></h3>
        <form id="reportForm" class="w-full flex flex-col justify-start items-start py-4 gap-4">
            <input type="text" hidden class="hidden" name="reportId" id="reportIdx">
            <input type="text" hidden class="hidden" name="programId" id="programIdx">
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Keluaran</h3>
                <p id="reportOutput"></p>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Penanggung Jawab</h3>
                <p id="reportInstanceResponsible"></p>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Instansi terkait</h3>
                <ol class="list-decimal list-inside" id="reportRelatedInstances">

                </ol>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Target</h3>
                <p id="reportTarget"></p>
            </div>
            <div class="flex flex-row gap-2 w-full">
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Bulan</h3>
                    <p id="reportMonth"></p>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Tahun</h3>
                    <p id="reportYear"></p>
                </div>
            </div>
            <div class="flex flex-row gap-2 w-full">
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Kuantitif</h3>
                    <p id="reportQuantitiveTarget"></p>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Satuan</h3>
                    <p id="reportUnit"></p>
                </div>
            </div>
            <div class="flex-row gap-2 w-full hidden" id="targetCountContainer">
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Kompilasi</h3>
                    <input name="compilation_target_count" type="number" value="0" placeholder="Realisasi target Kompilasi" class="input input-bordered w-full max-w-xs" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Integrasi</h3>
                    <input name="integration_target_count" type="number" value="0" placeholder="Realisasi target Integrasi" class="input input-bordered w-full max-w-xs" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Sinkronisasi</h3>
                    <input name="syncronization_target_count" type="number" value="0" placeholder="Realisasi target Sinkronisasi" class="input input-bordered w-full max-w-xs" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Publikasi</h3>
                    <input name="publication_target_count" type="number" value="0" placeholder="Realisasi target Publikasi" class="input input-bordered w-full max-w-xs" />
                </div>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Cakupan Wilayah Penyelesaian</h3>
                <div class="flex flex-col gap-2">
                    <label class="flex flex-row items-center justify-start w-full gap-2 cursor-pointer">
                        <input type="radio" name="areaOfRealization" value="all" class="radio checked:bg-primary radio-partial" checked />
                        <span class="label-text">Seluruh Indonesia</span>
                    </label>
                    <label class="flex flex-row items-center justify-start w-full gap-2 cursor-pointer">
                        <input type="radio" name="areaOfRealization" value="partial" class="radio checked:bg-primary radio-partial" />
                        <span class="label-text">Sebagian</span>
                    </label>
                </div>
            </div>
            <div id="provinceChecks" class="hidden grid-flow-row grid-cols-5 gap-2 max-w-full" style="grid-auto-rows: 1fr;">
                @foreach($provinces as $province)
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-2 items-start">
                        <input type="checkbox" class="checkbox checkbox-sm checkbox-primary chk-province" name="province_{{ $province->id }}" value="{{ $province->id }}" />
                        <span class="label-text">{{ $province->name }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Keterangan / Kendala</h3>
                <textarea name="description" id="reportDesc" class="textarea textarea-bordered" placeholder="Isi keterangan"></textarea>
            </div>
            <div class="flex-col gap-2 w-full hidden" id="compilationFileContainer">
                <h3 class="font-bold">Unggah Dokumen Kompilasi (Berita Acara atau Dokumen Pendukung Lainnya)</h3>
                <div class="form-control w-full">
                    <input name="compilation_doc" type="file" class="file-input file-input-bordered file-input-primary w-full" />
                    <label class="label">
                        <span class="label-text-alt">Maksimal ukuran unggah berkas: 40MB</span>
                    </label>
                </div>
                <div class="w-full flex flex-row gap-2 items-center justify-start flex-wrap" id="compilationFile"></div>
            </div>
            <div class="flex-col gap-2 w-full hidden" id="integrationFileContainer">
                <h3 class="font-bold">Unggah Dokumen Integrasi (Berita Acara atau Dokumen Pendukung Lainnya)</h3>
                <div class="form-control w-full">
                    <input name="integration_doc" type="file" class="file-input file-input-bordered file-input-primary w-full" />
                    <label class="label">
                        <span class="label-text-alt">Maksimal ukuran unggah berkas: 40MB</span>
                    </label>
                </div>
                <div class="w-full flex flex-row gap-2 items-center justify-start flex-wrap" id="integrationFile"></div>
            </div>
            <div class="modal-action w-full flex-row">
                <label for="my-modal-5" class="btn">Batal</label>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endrole

@role(['satgas', 'setkab'])
<input type="checkbox" id="my-modal-5" class="modal-toggle" />
<div class="modal">
    <div class="modal-box w-11/12 max-w-5xl">
        <h3 class="font-bold text-lg" id="reportTitle"></h3>
        <form id="reportForm" class="w-full flex flex-col justify-start items-start py-4 gap-4">
            <input type="text" hidden class="hidden" name="reportId" id="reportIdx">
            <input type="text" hidden class="hidden" name="programId" id="programIdx">
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Keluaran</h3>
                <p id="reportOutput"></p>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Penanggung Jawab</h3>
                <p id="reportInstanceResponsible"></p>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Instansi terkait</h3>
                <ol class="list-decimal list-inside" id="reportRelatedInstances">

                </ol>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Target</h3>
                <p id="reportTarget"></p>
            </div>
            <div class="flex flex-row gap-2 w-full">
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Bulan</h3>
                    <p id="reportMonth"></p>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Tahun</h3>
                    <p id="reportYear"></p>
                </div>
            </div>
            <div class="flex flex-row gap-2 w-full">
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Kuantitif</h3>
                    <p id="reportQuantitiveTarget"></p>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Satuan</h3>
                    <p id="reportUnit"></p>
                </div>
            </div>
            <div class="flex-row gap-2 w-full hidden" id="targetCountContainer">
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Kompilasi</h3>
                    <input disabled name="compilation_target_count" type="number" value="0" placeholder="Realisasi target Kompilasi" class="input input-bordered w-full max-w-xs" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Integrasi</h3>
                    <input disabled name="integration_target_count" type="number" value="0" placeholder="Realisasi target Integrasi" class="input input-bordered w-full max-w-xs" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Sinkronisasi</h3>
                    <input disabled name="syncronization_target_count" type="number" value="0" placeholder="Realisasi target Sinkronisasi" class="input input-bordered w-full max-w-xs" />
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <h3 class="font-bold">Target Publikasi</h3>
                    <input disabled name="publication_target_count" type="number" value="0" placeholder="Realisasi target Publikasi" class="input input-bordered w-full max-w-xs" />
                </div>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Cakupan Wilayah Penyelesaian</h3>
                <div class="flex flex-col gap-2">
                    <label class="flex flex-row items-center justify-start w-full gap-2 cursor-pointer">
                        <input disabled type="radio" name="areaOfRealization" value="all" class="radio checked:bg-primary radio-partial" checked />
                        <span class="label-text">Seluruh Indonesia</span>
                    </label>
                    <label class="flex flex-row items-center justify-start w-full gap-2 cursor-pointer">
                        <input disabled type="radio" name="areaOfRealization" value="partial" class="radio checked:bg-primary radio-partial" />
                        <span class="label-text">Sebagian</span>
                    </label>
                </div>
            </div>
            <div id="provinceChecks" class="hidden grid-flow-row grid-cols-5 gap-2 max-w-full" style="grid-auto-rows: 1fr;">
                @foreach($provinces as $province)
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-2 items-start">
                        <input disabled type="checkbox" class="checkbox checkbox-sm checkbox-primary chk-province" name="province_{{ $province->id }}" value="{{ $province->id }}" />
                        <span class="label-text">{{ $province->name }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Keterangan / Kendala</h3>
                <textarea disabled name="description" id="reportDesc" class="textarea textarea-bordered" placeholder="Isi keterangan"></textarea>
            </div>
            <div class="flex-col gap-2 w-full hidden" id="compilationFileContainer">
                <h3 class="font-bold">Dokumen Kompilasi (Berita Acara atau Dokumen Pendukung Lainnya)</h3>

                <div class="w-full flex flex-row gap-2 items-center justify-start flex-wrap" id="compilationFile"></div>
            </div>
            <div class="flex-col gap-2 w-full hidden" id="integrationFileContainer">
                <h3 class="font-bold">Dokumen Integrasi (Berita Acara atau Dokumen Pendukung Lainnya)</h3>

                <div class="w-full flex flex-row gap-2 items-center justify-start flex-wrap" id="integrationFile"></div>
            </div>
            <div class="flex flex-col gap-2 w-full">
                <h3 class="font-bold">Catatan Verifikasi</h3>
                <textarea name="verificationNote" id="verificationNote" class="textarea textarea-bordered" placeholder="Isi Catatan"></textarea>
            </div>
            <div class="modal-action w-full flex-row">
                <label for="my-modal-5" class="btn">Batal</label>
                <button class="btn btn-success text-white" type="submit">Verifikasi</button>
            </div>
        </form>
    </div>
</div>
@endrole
@endsection
