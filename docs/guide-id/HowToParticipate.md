Bagi kawan-kawan yang ingin berpartisipasi dalam pengembangan SangkilBiz3 dapat mengikuti langkah-langkah berikut.

# Mulai Berpartisipasi
## 1. Fork SangkilBiz3 ke repository anda sendiri kemudian clone.
```
$ git clone https://github.com/<user>/sangkilbiz3.git
```
Jika ada masalah setup GIT untuk GitHub di Linux, atau ada error seperti "Permission Denied (publickey)", silakan setup GIT anda agar dapat bekerja dengan GitHub.

## 2. Tambahkan SangkilBiz3 repository sebagai additional git remote dengan nama "upstream".
```
$ git remote add upstream https://github.com/sangkil/sangkilbiz3.git
```
## 3. Dapatkan code terbaru dari SangkilBiz3.
```
$ git fetch upstream
```
Ini harus anda lakukan tiap kali akan berkontribusi untuk memastikan anda bekerja dengan kode terakhir.

## 4. Membuat branch baru berdasarkan SangkilBiz3 master branch.
```
$ git checkout upstream/master
$ git checkout -b 999-name-of-your-branch-goes-here
```
## 5. Tulis kode anda.
Lakukan yang terbaik. Perbaiki issue yang ada. Tambahkan fitur dan lain-lain.
Pastikan kode anda bekerja dengan benar sebelum menguploadnya :D.

## 6. Update CHANGELOG.
Edit file CHANGELOG untuk memasukkan perubahan anda. Sisipkan baris pada CHANGELOG sesuai dengan perubahan yang anda lakukan. Baris yang anda masukkan harus berbentuk seperti

```
Bug #999: a description of the bug fix (Your Name)
Enh #999: a description of the enhancement (Your Name)
```
#999 adalah nomor issue anda.

## 7. Commit
tambahkan files/perubahan anda yang ingin dicomit ke staging area dengan

```
$ git add path/to/my/file.php
```
Anda bisa menggunakan opsi -p untuk memilih perubahan yang ingin dicommit.

Commit perubahan anda dengan deskripsi yang jelas. Anda bisa menambahkan nomor issue anda dengan format #XXX. GitHub akan otomatis menglinkkan commit anda dengan issue tersebut:

```
$ git commit -m "A brief description of this change which fixes #42 goes here"
```
> Deskripsi commit boleh dalam bahasa Indonesia tetapi diharapkan anda menggunakan bahasa Inggris :D.

## 8. Pull code terakhir SangkilBiz ke branch anda.
```
$ git pull upstream master
```
sekali lagi untuk memastikan anda bekerja dengan code terakhir dari SangkilBiz

## 9. Push code anda ke GitHub.
```
$ git push -u origin 999-name-of-your-branch-goes-here
```
## 10. Buat pull request.
Masuk ke repository anda di GitHub kemudian klik Pull Request. Pilih branch dan tambahkan detail di comment. Untuk menghubungkan "pull request" dengan issue, tambahkan di comment nomor issue tersebut dengan format #999.

> Satu "pull request" harusnya hanya untuk satu perubahan.

## 11. Seseorang akan mereview code anda.
Seseorang akan mereview code anda. Menanyakan sesuatu, meminta perubahan dan lain-lain. Lakukan langkah 5 (anda tidak perlu membuat "pull request" yang baru). Jika code anda diterima, ia akan dimerge dan menjadi bagian dari SangkilBiz. Jika ditolak, jangan berkecil hati, tiap orang punya pertimbangannya masing-masing :D.

## 12. Bersihkan.
Jika sudah selesai, baik karena diterima maupun ditolak. Bersihkan repository local anda.

```
$ git checkout master
$ git branch -D 999-name-of-your-branch-goes-here
$ git push origin --delete 999-name-of-your-branch-goes-here
```
## 13. Terima Kasih.
Jika ada yang salah dalam tulisan ini, mohon dimaafkan. Ane masih newbie gan :D.
Salam.

Ringkasan
```
$ git clone https://github.com/<user>/sangkilbiz3.git
$ cd sangkilbiz3
$ git remote add upstream git://github.com/sangkil/sangkilbiz3.git

$ git fetch upstream
$ git checkout upstream/master
$ git checkout -b 999-name-of-your-branch-goes-here

/* do your magic, update changelog if needed */

$ git add path/to/my/file.php
$ git commit -m "A brief description of this change which fixes #42 goes here"
$ git pull upstream master
$ git push -u origin 999-name-of-your-branch-goes-here
```