@component('mail::message')
# Permohonan Rapat Baru

Terdapat Permohonan Rapat Baru.
Mohon segera Di cek
<br>
<br>
@component('mail::button', ['url' => 'http://localhost:8000/permohonan_rapat'])
Cek Sekarang
@endcomponent

Terima Kasih<br>
@endcomponent