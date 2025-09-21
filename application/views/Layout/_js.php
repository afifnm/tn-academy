        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
        <script src="<?= base_url('assets/')?>dist/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
            $('#example1').DataTable({
                "searching": true,
                "lengthChange": false,
                "pageLength": 20,
                "language": {
                    "search": "Pencarian "
                }
            });
            $('#example2').DataTable({
                "searching": true,
                "lengthChange": false,
                "language": {
                    "search": "Pencarian "
                }
            });
            $('#log').DataTable({"searching": false, "lengthChange": false});
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <script>
        <?php if($this->session->flashdata('notifikasi')): ?>
        Swal.fire({ 
            icon: '<?= $this->session->flashdata('icon') ?>', 
            text: '<?= $this->session->flashdata('notifikasi') ?>',
            confirmButtonText: 'OK',
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            customClass: {
                confirmButton: 'swal2-confirm-ungu' // pakai custom class
            }
        });
        <?php endif; ?>
        </script>
        <style>
        /* Tambahkan ini untuk styling tombol */
        .swal2-confirm-ungu {
            background-color: #6f42c1 !important; /* Ungu Bootstrap */
            color: #ffffff !important; /* Putih supaya teks kontras */
            border: none;
            box-shadow: none;
        }
        .swal2-confirm-ungu:hover {
            background-color: #5a32a3 !important; /* Ungu sedikit lebih gelap saat hover */
        }
        </style>
        <script
            src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <?php $this->session->unset_userdata('icon'); $this->session->unset_userdata('notifikasi');?>