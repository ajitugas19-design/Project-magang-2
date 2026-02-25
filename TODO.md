# TODO - Connect Barcode Scanner with Inventory System

## Plan:

1. [x] Create a search API to find barang by barcode code
   - admin/cari_barang.php - API for admin module
   - manajemen/cari_barang.php - API for manajemen module
2. [x] Modify barang masuk modal in admin to add barcode input
   - admin/barang_masuk.php - Add barcode scanner input + JS function
3. [x] Modify barang masuk modal in manajemen to add barcode input
   - manajemen/barang_masuk.php - Add barcode scanner input + JS function
4. [x] Modify barang keluar modal in admin to add barcode input
   - admin/barang_keluar.php - Add barcode scanner input + JS function
5. [x] Modify barang keluar modal in manajemen to add barcode input
   - manajemen/barang_keluar.php - Add barcode scanner input + JS function

## Features Implemented:

- Input field to scan/type barcode
- Button to search for barang by barcode
- Auto-fill form when barcode is found
- Display detected barcode info in modal
- Support Enter key to trigger search
- Automatic modal opening after successful scan

## Files Modified:

- admin/cari_barang.php (NEW)
- manajemen/cari_barang.php (NEW)
- admin/barang_masuk.php
- admin/barang_keluar.php
- manajemen/barang_masuk.php
- manajemen/barang_keluar.php
