<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $page_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Replaced AdminLTE/Bootstrap with Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // override Tailwind defaults for a more modern look
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-200': '#5CDEFF',
                        'blue-500': '#5CDEFF',
                        'blue-600': '#00ccff',
                        'blue-700': '#3b82f6',

                    },
                },
            },
        }
    </script>


    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- bootstrap wysihtml5 - text editor -->
    <link src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link src="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css') ?>" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* Fixed layout styles for proper sidebar positioning */
        @media (min-width: 1024px) {
            .main-content-wrapper {
                margin-left: 16rem;
                /* 256px sidebar width */
                width: calc(100% - 16rem);
            }
        }

        .main-content-wrapper {
            margin-left: 0;
            width: 100%;
        }

        table {
            max-width: 100% !important;
            width: 100%;
        }

        /* table>tbody {
            height: calc(100vh - 35rem);
            overflow-y: auto !important;
        } */



        /* for select2 override */
        .select2-container--default {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db !important;
            border-radius: 0.75rem !important;
            padding: 0.5rem !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black !important;
            border-radius: 0.375rem !important;
            margin-right: 0.3rem !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__clear {
            color: black !important;
            margin-left: 0.25rem !important;
            font-size: 1rem !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            border: none !important;
            color: black;
            padding: 0.25rem 0.8rem !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice:hover {
            background-color: rgba(0, 0, 0, 0.2) !important;
            color: white !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #f3f4f6;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <!-- jQuery 3 -->
    <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url('assets/bower_components/jquery-ui/jquery-ui.min.js') ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- Keep essential functionality scripts but remove AdminLTE specific ones -->
    <!-- Morris.js charts -->
    <script src="<?php echo base_url('assets/bower_components/raphael/raphael.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/morris.js/morris.min.js') ?>"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') ?>">
    </script>
    <!-- barcode--->
    <script type="module" src="assets/dist/js/scanner.js"></script>
    </script>
    <!-- jvectormap -->
    <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') ?>"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url('assets/bower_components/moment/min/moment.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') ?>">
    </script>
    <!-- datepicker -->
    <script
        src="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>">
    </script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url('assets/bower_components/select2/dist/js/select2.full.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/fileinput/fileinput.min.js') ?>"></script>
    <!-- ChartJS -->
    <script src="<?php echo base_url('assets/bower_components/Chart.js/Chart.js') ?>"></script>
    <!-- icheck -->
    <script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>">
    </script>


</head>
<!-- Updated body classes for modern layout -->

<body class="bg-gray-50 font-sans antialiased ">