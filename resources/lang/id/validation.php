<?php

return [

    'accepted' => 'Kolom :attribute harus diterima.',
    'active_url' => 'Kolom :attribute bukan URL yang valid.',
    'after' => 'Kolom :attribute harus tanggal setelah :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa array.',
    'before' => 'Kolom :attribute harus tanggal sebelum :date.',
    'between' => [
        'numeric' => 'Nilai :attribute harus antara :min dan :max.',
        'file' => 'Ukuran berkas :attribute harus antara :min dan :max kilobyte.',
        'string' => 'Panjang teks :attribute harus antara :min dan :max karakter.',
        'array' => 'Jumlah item :attribute harus antara :min dan :max.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai true atau false.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
    'date_format' => 'Kolom :attribute tidak cocok dengan format :format.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus terdiri dari :digits angka.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'in' => 'Kolom :attribute yang dipilih tidak valid.',
    'integer' => 'Kolom :attribute harus berupa angka bulat.',
    'max' => [
        'numeric' => 'Nilai :attribute tidak boleh lebih dari :max.',
        'file' => 'Ukuran :attribute tidak boleh lebih dari :max kilobyte.',
        'string' => 'Teks :attribute tidak boleh lebih dari :max karakter.',
        'array' => 'Jumlah item pada :attribute tidak boleh lebih dari :max.',
    ],
    'min' => [
        'numeric' => 'Nilai :attribute tidak boleh kurang dari :min.',
        'file' => 'Ukuran :attribute minimal :min kilobyte.',
        'string' => 'Teks :attribute minimal harus :min karakter.',
        'array' => 'Jumlah item pada :attribute minimal harus :min.',
    ],
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'required' => 'Kolom :attribute wajib diisi.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'string' => 'Kolom :attribute harus berupa string.',
    'unique' => 'Nilai :attribute sudah digunakan.',
    'url' => 'Format :attribute tidak valid.',

    'custom' => [
        'scores.*' => [
            'required' => 'Nilai tidak boleh kosong.',
            'numeric'  => 'Nilai harus berupa angka.',
            'min'      => 'Nilai minimal adalah :min.',
            'max'      => 'Nilai maksimal adalah :max.',
        ],
    ],

];