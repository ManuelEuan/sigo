<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ranexoest extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->library('Class_options');
        $this->load->model('M_pat', 'pat');
        $this->load->model('M_reporteAnex','mra');
        $this->load->library('ReportePdf');
        $this->load->library('Pdf2text');
    }

    public function index()
    {
        $options = new Class_options();
        $datos['ejes'] = $options->options_tabla('eje');        
        $this->load->view('reporte/anexo_est',$datos);
    }

    public function readfile()
    {
        $mun = array("Abalá", "Acanceh", "Akil", "Baca", "Bokobá", "Buctzotz", "Cacalchén", "Calotmul", "Cansahcab", "Cantamayec", "Celestún", "Cenotillo", "Conkal", "Cuncunul", "Cuzamá", "Chacsinkín", "Chankom", "Chapab", "Chemax", "Chicxulub Pueblo", "Chichimilá", "Chikindzonot", "Chocholá", "Chumayel", "Dzán", "Dzemul", "Dzidzantún", "Dzilam de Bravo", "Dzilam González", "Dzitás", "Dzoncauich", "Espita", "Halachó", "Hocabá", "Hoctún", "Homún", "Huhí", "Hunucmá", "Ixil", "Izamal", "Kanasín", "Kantunil", "Kaua", "Kinchil", "Kopomá", "Mama", "Maní", "Maxcanú", "Mayapán", "Ciudad", "Mocochá", "Motul", "Muna", "Muxupip", "Opichén", "Oxkutzcab", "Panabá", "Peto", "Progreso", "Quintana Roo", "Río Lagartos", "Sacalum", "Samahil", "Sanahcat", "San Felipe", "Santa Elena", "Seyé", "Sinanché", "Sotuta", "Sucilá", "Sudzal", "Suma", "Tahdziú", "Tahmek", "Teabo", "Tecoh", "Tekal de Venegas", "Tekantó", "Tekax", "Tekit", "Tekom", "Telchac Pueblo", "Telchac Puerto", "Temax", "Temozón", "Tepakán", "Tetiz", "Teya", "Ticul", "Timucuy", "Tinum", "Tixcacalcupul", "Tixkokob", "Tixmehuac", "Tixpéhual", "Tizimín", "Tunkás", "Tzucacab", "Uayma", "Ucú", "Umán", "Valladolid", "Xocchel", "Yaxcabá", "Yaxkukul", "Yobaín");
        $anios = array('2018', '2019');
        $col = array("Entregables", "Total de Beneficiarios", "Beneficiarios Hombres", "Beneficiarias Mujeres", "Beneficiarios con Discapacidad", "Beneficiarios Maya hablantes");
        //$tablas = array("5.1","5.2","5.3","5.4","5.5","5.6","5.7","5.8","5.9","5.10","5.11","5.12","5.13","7.1","7.2","7.3","7.4","7.5","7.6","7.7","7.8","7.9","7.10","7.11","7.12","6.1","6.2","6.3","6.4","6.5","9.1","9.2","8.1","8.2","8.3","8.4","4.1","4.2","4.3","4.4","4.5","4.6","4.7","4.8","4.9","2.1","2.2","2.3","2.4","2.5","2.6","2.7","2.8","2.9","2.10","2.11","2.12","2.13","2.14","2.15","2.16","2.17","2.18","2.19","2.20","2.21","2.22","2.23","2.24","2.25","2.26","2.27","2.28","2.29","2.30","2.31","2.32","2.33","2.34","2.35","2.36","2.37","2.38","2.39","2.40","2.41","2.42","2.43","2.44","2.45","2.46","2.47","2.48","2.49","2.50","2.51","2.52","2.53","2.54","2.55","2.56","2.57","2.58","2.59","1.1","1.2","1.3","1.4","1.5","1.6","1.7","1.8","1.9","1.10","1.11","1.12","1.13","1.14","1.15","1.16","1.17","1.18","1.19","1.20","1.21","1.22","1.23","1.24","1.25","1.26","1.27","1.28","1.29","1.30","1.31","1.32","1.33","1.34","1.35","1.36","1.37","1.38","1.39","1.40","1.41","1.42","1.43","1.44","1.45","1.46","1.47","1.48","1.49","1.50","1.51","1.52","1.53","1.54","1.55","1.56","1.57","1.58","1.59","3.1","3.2","3.3","3.4","3.5","3.6","3.7","3.8","3.9","3.10","3.11","3.12","3.13","3.14","3.15","3.16","3.17");
        $tablas = array("1.1"=> array("iIdEntregable"=> 1673, "iIdActividad"=> 745, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 4),
        "1.2"=> array("iIdEntregable"=> 2958, "iIdActividad"=> 1230, "vDependencia"=> "IYEM", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.3"=> array("iIdEntregable"=> 1859, "iIdActividad"=> 893, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.4"=> array("iIdEntregable"=> 1863, "iIdActividad"=> 893, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.5"=> array("iIdEntregable"=> 2021, "iIdActividad"=> 811, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 14),
        "1.6"=> array("iIdEntregable"=> 2023, "iIdActividad"=> 811, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 14),
        "1.7"=> array("iIdEntregable"=> 2018, "iIdActividad"=> 811, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 14),
        "1.8"=> array("iIdEntregable"=> 2001, "iIdActividad"=> 810, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 14),
        "1.9"=> array("iIdEntregable"=> 2687, "iIdActividad"=> 780, "vDependencia"=> "IYEM", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.10"=> array("iIdEntregable"=> 1755, "iIdActividad"=> 780, "vDependencia"=> "IYEM", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.11"=> array("iIdEntregable"=> 3313, "iIdActividad"=> 699, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.12"=> array("iIdEntregable"=> 1714, "iIdActividad"=> 699, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.13"=> array("iIdEntregable"=> 1711, "iIdActividad"=> 699, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.14"=> array("iIdEntregable"=> 1713, "iIdActividad"=> 699, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.15"=> array("iIdEntregable"=> 1715, "iIdActividad"=> 699, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.16"=> array("iIdEntregable"=> 1717, "iIdActividad"=> 699, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.17"=> array("iIdEntregable"=> 1768, "iIdActividad"=> 788, "vDependencia"=> "IYEM", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.18"=> array("iIdEntregable"=> 1756, "iIdActividad"=> 789, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.19"=> array("iIdEntregable"=> 2963, "iIdActividad"=> 1237, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.20"=> array("iIdEntregable"=> 1793, "iIdActividad"=> 803, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 14),
        "1.21"=> array("iIdEntregable"=> 1792, "iIdActividad"=> 803, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 14),
        "1.22"=> array("iIdEntregable"=> 1796, "iIdActividad"=> 803, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 14),
        "1.23"=> array("iIdEntregable"=> 1788, "iIdActividad"=> 801, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 4),
        "1.24"=> array("iIdEntregable"=> 1790, "iIdActividad"=> 804, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.25"=> array("iIdEntregable"=> 1858, "iIdActividad"=> 892, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 4),
        "1.26"=> array("iIdEntregable"=> 1631, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.27"=> array("iIdEntregable"=> 3320, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.28"=> array("iIdEntregable"=> 1629, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.29"=> array("iIdEntregable"=> 1626, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.30"=> array("iIdEntregable"=> 1632, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.31"=> array("iIdEntregable"=> 1627, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.32"=> array("iIdEntregable"=> 1635, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.33"=> array("iIdEntregable"=> 3321, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.34"=> array("iIdEntregable"=> 1637, "iIdActividad"=> 724, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.35"=> array("iIdEntregable"=> 1667, "iIdActividad"=> 733, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.36"=> array("iIdEntregable"=> 1658, "iIdActividad"=> 733, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.37"=> array("iIdEntregable"=> 1651, "iIdActividad"=> 733, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.38"=> array("iIdEntregable"=> 1652, "iIdActividad"=> 733, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.39"=> array("iIdEntregable"=> 2989, "iIdActividad"=> 733, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.40"=> array("iIdEntregable"=> 1654, "iIdActividad"=> 733, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.41"=> array("iIdEntregable"=> 1992, "iIdActividad"=> 809, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.42"=> array("iIdEntregable"=> 3294, "iIdActividad"=> 751, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.43"=> array("iIdEntregable"=> 1685, "iIdActividad"=> 751, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.44"=> array("iIdEntregable"=> 3293, "iIdActividad"=> 751, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.45"=> array("iIdEntregable"=> 1686, "iIdActividad"=> 751, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.46"=> array("iIdEntregable"=> 1699, "iIdActividad"=> 755, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.47"=> array("iIdEntregable"=> 2711, "iIdActividad"=> 697, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.48"=> array("iIdEntregable"=> 2712, "iIdActividad"=> 697, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.49"=> array("iIdEntregable"=> 2760, "iIdActividad"=> 1180, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.50"=> array("iIdEntregable"=> 3312, "iIdActividad"=> 748, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.51"=> array("iIdEntregable"=> 1677, "iIdActividad"=> 748, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.52"=> array("iIdEntregable"=> 2036, "iIdActividad"=> 814, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.53"=> array("iIdEntregable"=> 2038, "iIdActividad"=> 814, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.54"=> array("iIdEntregable"=> 2044, "iIdActividad"=> 813, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.55"=> array("iIdEntregable"=> 2045, "iIdActividad"=> 813, "vDependencia"=> "SEPASY", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.56"=> array("iIdEntregable"=> 1616, "iIdActividad"=> 711, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "1.57"=> array("iIdEntregable"=> 1797, "iIdActividad"=> 806, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.58"=> array("iIdEntregable"=> 1791, "iIdActividad"=> 805, "vDependencia"=> "SEFOET", "vEje"=> " con Economía Inclusiva", "iOds"=> 8),
        "1.59"=> array("iIdEntregable"=> 1751, "iIdActividad"=> 704, "vDependencia"=> "SEDER", "vEje"=> " con Economía Inclusiva", "iOds"=> 2),
        "2.1"=> array("iIdEntregable"=> 1915, "iIdActividad"=> 918, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.2"=> array("iIdEntregable"=> 1913, "iIdActividad"=> 918, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.3"=> array("iIdEntregable"=> 1724, "iIdActividad"=> 763, "vDependencia"=> "COBAY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.4"=> array("iIdEntregable"=> 1728, "iIdActividad"=> 763, "vDependencia"=> "COBAY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.5"=> array("iIdEntregable"=> 3358, "iIdActividad"=> 762, "vDependencia"=> "IBECEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.6"=> array("iIdEntregable"=> 3353, "iIdActividad"=> 762, "vDependencia"=> "IBECEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.7"=> array("iIdEntregable"=> 2966, "iIdActividad"=> 762, "vDependencia"=> "IBECEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.8"=> array("iIdEntregable"=> 3351, "iIdActividad"=> 762, "vDependencia"=> "IBECEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.9"=> array("iIdEntregable"=> 3356, "iIdActividad"=> 762, "vDependencia"=> "IBECEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.10"=> array("iIdEntregable"=> 3359, "iIdActividad"=> 762, "vDependencia"=> "IBECEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.11"=> array("iIdEntregable"=> 3346, "iIdActividad"=> 1521, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.12"=> array("iIdEntregable"=> 3344, "iIdActividad"=> 1521, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.13"=> array("iIdEntregable"=> 3345, "iIdActividad"=> 1521, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.14"=> array("iIdEntregable"=> 3347, "iIdActividad"=> 1521, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.15"=> array("iIdEntregable"=> 3348, "iIdActividad"=> 1521, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.16"=> array("iIdEntregable"=> 3349, "iIdActividad"=> 1521, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.17"=> array("iIdEntregable"=> 2151, "iIdActividad"=> 826, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.18"=> array("iIdEntregable"=> 1738, "iIdActividad"=> 766, "vDependencia"=> "CONALEP", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.19"=> array("iIdEntregable"=> 3283, "iIdActividad"=> 1183, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.20"=> array("iIdEntregable"=> 3326, "iIdActividad"=> 1513, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 1),
        "2.21"=> array("iIdEntregable"=> 2153, "iIdActividad"=> 827, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.22"=> array("iIdEntregable"=> 1905, "iIdActividad"=> 912, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.23"=> array("iIdEntregable"=> 1894, "iIdActividad"=> 908, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.24"=> array("iIdEntregable"=> 3328, "iIdActividad"=> 1511, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.25"=> array("iIdEntregable"=> 2186, "iIdActividad"=> 832, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 1),
        "2.26"=> array("iIdEntregable"=> 2189, "iIdActividad"=> 832, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 1),
        "2.27"=> array("iIdEntregable"=> 2192, "iIdActividad"=> 832, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.28"=> array("iIdEntregable"=> 3350, "iIdActividad"=> 720, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.29"=> array("iIdEntregable"=> 3324, "iIdActividad"=> 720, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.30"=> array("iIdEntregable"=> 2930, "iIdActividad"=> 1204, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 1),
        "2.31"=> array("iIdEntregable"=> 2776, "iIdActividad"=> 871, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.32"=> array("iIdEntregable"=> 1887, "iIdActividad"=> 905, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.33"=> array("iIdEntregable"=> 1889, "iIdActividad"=> 905, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.34"=> array("iIdEntregable"=> 2779, "iIdActividad"=> 872, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.35"=> array("iIdEntregable"=> 2778, "iIdActividad"=> 872, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.36"=> array("iIdEntregable"=> 2781, "iIdActividad"=> 872, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.37"=> array("iIdEntregable"=> 2780, "iIdActividad"=> 872, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.38"=> array("iIdEntregable"=> 1879, "iIdActividad"=> 901, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.39"=> array("iIdEntregable"=> 1880, "iIdActividad"=> 901, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.40"=> array("iIdEntregable"=> 2787, "iIdActividad"=> 874, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.41"=> array("iIdEntregable"=> 2786, "iIdActividad"=> 874, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.42"=> array("iIdEntregable"=> 2785, "iIdActividad"=> 874, "vDependencia"=> "SSY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.43"=> array("iIdEntregable"=> 1870, "iIdActividad"=> 897, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.44"=> array("iIdEntregable"=> 1871, "iIdActividad"=> 897, "vDependencia"=> "DIF ", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 2),
        "2.45"=> array("iIdEntregable"=> 2250, "iIdActividad"=> 840, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.46"=> array("iIdEntregable"=> 2253, "iIdActividad"=> 840, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.47"=> array("iIdEntregable"=> 2257, "iIdActividad"=> 841, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.48"=> array("iIdEntregable"=> 2259, "iIdActividad"=> 841, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.49"=> array("iIdEntregable"=> 1709, "iIdActividad"=> 722, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.50"=> array("iIdEntregable"=> 3331, "iIdActividad"=> 723, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.51"=> array("iIdEntregable"=> 3330, "iIdActividad"=> 723, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.52"=> array("iIdEntregable"=> 3332, "iIdActividad"=> 723, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.53"=> array("iIdEntregable"=> 3329, "iIdActividad"=> 723, "vDependencia"=> "SEDESOL", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 3),
        "2.54"=> array("iIdEntregable"=> 2260, "iIdActividad"=> 842, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.55"=> array("iIdEntregable"=> 2262, "iIdActividad"=> 842, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.56"=> array("iIdEntregable"=> 2263, "iIdActividad"=> 842, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.57"=> array("iIdEntregable"=> 2283, "iIdActividad"=> 844, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "2.58"=> array("iIdEntregable"=> 2284, "iIdActividad"=> 844, "vDependencia"=> "SEGEY", "vEje"=> " con Calidad de Vida y Bienestar Social", "iOds"=> 4),
        "3.1"=> array("iIdEntregable"=> 3254, "iIdActividad"=> 1398, "vDependencia"=> "IDEY", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 3),
        "3.2"=> array("iIdEntregable"=> 3253, "iIdActividad"=> 1398, "vDependencia"=> "IDEY", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 3),
        "3.3"=> array("iIdEntregable"=> 2988, "iIdActividad"=> 793, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.4"=> array("iIdEntregable"=> 1830, "iIdActividad"=> 793, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.5"=> array("iIdEntregable"=> 1827, "iIdActividad"=> 793, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.6"=> array("iIdEntregable"=> 1814, "iIdActividad"=> 793, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.7"=> array("iIdEntregable"=> 1831, "iIdActividad"=> 793, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.8"=> array("iIdEntregable"=> 3125, "iIdActividad"=> 909, "vDependencia"=> "INDEMAYA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.9"=> array("iIdEntregable"=> 2008, "iIdActividad"=> 799, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.10"=> array("iIdEntregable"=> 2002, "iIdActividad"=> 799, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.11"=> array("iIdEntregable"=> 2010, "iIdActividad"=> 800, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.12"=> array("iIdEntregable"=> 3265, "iIdActividad"=> 800, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.13"=> array("iIdEntregable"=> 3263, "iIdActividad"=> 800, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "3.14"=> array("iIdEntregable"=> 2708, "iIdActividad"=> 1179, "vDependencia"=> "SEDECULTA", "vEje"=> " Cultural con Identidad para el Desarrollo", "iOds"=> 11),
        "4.1"=> array("iIdEntregable"=> 2915, "iIdActividad"=> 1194, "vDependencia"=> "SDS", "vEje"=> " Verde y Sustentable", "iOds"=> 6),
        "4.2"=> array("iIdEntregable"=> 2914, "iIdActividad"=> 1194, "vDependencia"=> "SDS", "vEje"=> " Verde y Sustentable", "iOds"=> 6),
        "4.3"=> array("iIdEntregable"=> 2935, "iIdActividad"=> 1215, "vDependencia"=> "JAPAY", "vEje"=> " Verde y Sustentable", "iOds"=> 6),
        "4.4"=> array("iIdEntregable"=> 2934, "iIdActividad"=> 1215, "vDependencia"=> "JAPAY", "vEje"=> " Verde y Sustentable", "iOds"=> 6),
        "4.5"=> array("iIdEntregable"=> 3049, "iIdActividad"=> 786, "vDependencia"=> "SDS", "vEje"=> " Verde y Sustentable", "iOds"=> 15),
        "4.6"=> array("iIdEntregable"=> 1817, "iIdActividad"=> 777, "vDependencia"=> "SDS", "vEje"=> " Verde y Sustentable", "iOds"=> 11),
        "4.7"=> array("iIdEntregable"=> 1815, "iIdActividad"=> 777, "vDependencia"=> "SDS", "vEje"=> " Verde y Sustentable", "iOds"=> 11),
        "4.8"=> array("iIdEntregable"=> 1795, "iIdActividad"=> 782, "vDependencia"=> "SDS", "vEje"=> " Verde y Sustentable", "iOds"=> 15),
        "4.9"=> array("iIdEntregable"=> 2913, "iIdActividad"=> 782, "vDependencia"=> "SDS", "vEje"=> " Verde y Sustentable", "iOds"=> 15),
        "5.1"=> array("iIdEntregable"=> 2035, "iIdActividad"=> 959, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.2"=> array("iIdEntregable"=> 2033, "iIdActividad"=> 959, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.3"=> array("iIdEntregable"=> 2034, "iIdActividad"=> 959, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.4"=> array("iIdEntregable"=> 2995, "iIdActividad"=> 961, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.5"=> array("iIdEntregable"=> 2047, "iIdActividad"=> 964, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.6"=> array("iIdEntregable"=> 2994, "iIdActividad"=> 964, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.7"=> array("iIdEntregable"=> 2992, "iIdActividad"=> 964, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.8"=> array("iIdEntregable"=> 2046, "iIdActividad"=> 964, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.9"=> array("iIdEntregable"=> 3104, "iIdActividad"=> 1345, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.10"=> array("iIdEntregable"=> 3102, "iIdActividad"=> 1345, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.11"=> array("iIdEntregable"=> 3101, "iIdActividad"=> 1345, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.12"=> array("iIdEntregable"=> 3105, "iIdActividad"=> 1345, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "5.13"=> array("iIdEntregable"=> 3103, "iIdActividad"=> 1345, "vDependencia"=> "SEMUJERES", "vEje"=> "Igualdad de género oportunidades y no discriminación", "iOds"=> 5),
        "6.1"=> array("iIdEntregable"=> 3337, "iIdActividad"=> 1516, "vDependencia"=> "SIIES", "vEje"=> "Innovación, conocimiento y tecnología", "iOds"=> 4),
        "6.2"=> array("iIdEntregable"=> 3338, "iIdActividad"=> 1516, "vDependencia"=> "SIIES", "vEje"=> "Innovación, conocimiento y tecnología", "iOds"=> 4),
        "6.3"=> array("iIdEntregable"=> 3336, "iIdActividad"=> 1516, "vDependencia"=> "SIIES", "vEje"=> "Innovación, conocimiento y tecnología", "iOds"=> 4),
        "6.4"=> array("iIdEntregable"=> 3323, "iIdActividad"=> 1505, "vDependencia"=> "SIIES", "vEje"=> "Innovación, conocimiento y tecnología", "iOds"=> 4),
        "6.5"=> array("iIdEntregable"=> 3335, "iIdActividad"=> 1519, "vDependencia"=> "SIIES", "vEje"=> "Innovación, conocimiento y tecnología", "iOds"=> 4),
        "7.1"=> array("iIdEntregable"=> 3247, "iIdActividad"=> 1395, "vDependencia"=> "SGG", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.2"=> array("iIdEntregable"=> 2152, "iIdActividad"=> 1069, "vDependencia"=> "CEEAV", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.3"=> array("iIdEntregable"=> 2144, "iIdActividad"=> 1067, "vDependencia"=> "CEEAV", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.4"=> array("iIdEntregable"=> 2147, "iIdActividad"=> 1067, "vDependencia"=> "CEEAV", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.5"=> array("iIdEntregable"=> 2349, "iIdActividad"=> 1105, "vDependencia"=> "INDERM", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.6"=> array("iIdEntregable"=> 2342, "iIdActividad"=> 1093, "vDependencia"=> "FGE", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.7"=> array("iIdEntregable"=> 2359, "iIdActividad"=> 1108, "vDependencia"=> "INDERM", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.8"=> array("iIdEntregable"=> 2356, "iIdActividad"=> 1108, "vDependencia"=> "INDERM", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.9"=> array("iIdEntregable"=> 2346, "iIdActividad"=> 1096, "vDependencia"=> "FGE", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.10"=> array("iIdEntregable"=> 2974, "iIdActividad"=> 1245, "vDependencia"=> "CEPREDEY", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.11"=> array("iIdEntregable"=> 2792, "iIdActividad"=> 876, "vDependencia"=> "SSY", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "7.12"=> array("iIdEntregable"=> 2371, "iIdActividad"=> 1111, "vDependencia"=> "INDERM", "vEje"=> "Paz, Justicia y Gobernabilidad", "iOds"=> 16),
        "8.1"=> array("iIdEntregable"=> 3319, "iIdActividad"=> 1501, "vDependencia"=> "SAF", "vEje"=> "Gobierno Abierto, Eficiente y Finanzas Sanas", "iOds"=> 17),
        "8.2"=> array("iIdEntregable"=> 3322, "iIdActividad"=> 1503, "vDependencia"=> "SEPLAN", "vEje"=> "Gobierno Abierto, Eficiente y Finanzas Sanas", "iOds"=> 17),
        "8.3"=> array("iIdEntregable"=> 3318, "iIdActividad"=> 1187, "vDependencia"=> "SEPLAN", "vEje"=> "Gobierno Abierto, Eficiente y Finanzas Sanas", "iOds"=> 16),
        "8.4"=> array("iIdEntregable"=> 3160, "iIdActividad"=> 1356, "vDependencia"=> "SECOGEY", "vEje"=> "Gobierno Abierto, Eficiente y Finanzas Sanas", "iOds"=> 16),
        "9.1"=> array("iIdEntregable"=> 2964, "iIdActividad"=> 1239, "vDependencia"=> "IVEY", "vEje"=> "Ciudades y Comunidades Sostenibles", "iOds"=> 11),
        "9.2"=> array("iIdEntregable"=> 2970, "iIdActividad"=> 1238, "vDependencia"=> "SOP", "vEje"=> "Ciudades y Comunidades Sostenibles", "iOds"=> 11));

        //$fileName = 'public/reportes/anexo_verde.pdf';
        $fileName = 'public/reportes/anexos/8_anexo_gobierno.pdf';
        $reader = new Pdf2text;
        $output = $reader->decode($fileName);
        $code = utf8_encode($output);

        // Produce: <body text='black'>
        $bodytag = str_replace("\00", "", $code);
        $vchar = explode("\n", $bodytag);
        //print_r($arr_exp);
        $anio_act = '';        
        $tabla_act = '';
        $mun_act = '';
        $tit_act = '';
        $datos = array();
        $cont = 0;       
        $cont_anio = 0; 

        //foreach ($arr_exp as $vchar[$i]) {
        for ($i=0; $i < count($vchar); $i++) {             

            if($vchar[$i]!=" " && !in_array($vchar[$i], $col))
            {
                $char = substr($vchar[$i], 0, 5);

                if($char!='ND: N' && $char!='Nota:' && $char!='Fuent' && $char != 'Power')
                {
                    //echo $char;
                    if($char=='Tabla')
                    {
                        $nchar = substr($vchar[$i], 6, 5);
                        if($tabla_act != $nchar)
                        {
                            $tabla_act = trim($nchar);                        
                            $tit_act = explode('.', trim(substr($vchar[$i], 11)));
                            $anio_tab = array();
                            
                        }
                    }
                    else
                    {                        
                        if(in_array($vchar[$i], $anios)) {
                            if(!in_array($vchar[$i], $anio_tab))                                
                                array_push($anio_tab, $vchar[$i]);
                        }
                        elseif(in_array($vchar[$i], $mun)) {
                            if($mun_act != $vchar[$i])
                                $mun_act = $vchar[$i];
                        }
                        else
                        {                            
                            if(count($anio_tab) == 1)
                            {                                
                                if(count($anio_tab) > 0 && $tabla_act != '' && $mun_act!='')
                                {
                                    $anio_act = $anio_tab[0];                                    

                                    if(in_array($vchar[$i-1], $mun) || in_array($vchar[$i-2], $mun) || in_array($vchar[$i-3], $mun) || in_array($vchar[$i-4], $mun) || in_array($vchar[$i-5], $mun) || in_array($vchar[$i-6], $mun))
                                    {


                                        if(!isset($datos[$tabla_act]['actividad'])) $datos[$tabla_act]['actividad'] = $tit_act[0];
                                        if(!isset($datos[$tabla_act]['entregable'])) $datos[$tabla_act]['entregable'] = $tit_act[1];

                                        $exp_tab = explode('.', $tabla_act);
                                        $n_tab = $exp_tab[0].'.'.$exp_tab[1];

                                        if(isset($tablas[$n_tab])) 
                                        {
                                            $entregableid = $tablas[$n_tab]['iIdEntregable']; 
                                            $actividadid = $tablas[$n_tab]['iIdActividad'];

                                            $datos[$tabla_act]['vDependencia'] = $tablas[$n_tab]['vDependencia'];
                                            $datos[$tabla_act]['vEje'] = $tablas[$n_tab]['vEje'];
                                            $datos[$tabla_act]['iOds'] = $tablas[$n_tab]['iOds'];

                                            
                                            
                                            

                                            //$datos[$tabla_act]['iIdEntregable'] = $tablas[$n_tab]['iIdEntregable']; 
                                            //$datos[$tabla_act]['iIdActividad'] = $tablas[$n_tab]['iIdActividad'];
                                            
                                            $detalle = $this->mra->carga_detalle($entregableid, $actividadid, $anio_act);
                                                                                        
                                            if(count($detalle) > 0 && $detalle != false)
                                            {
                                                $datos[$tabla_act]['iIdActividad'] = $detalle[0]->iIdActividad;
                                                $datos[$tabla_act]['iIdEntregable'] = $detalle[0]->iIdEntregable;
                                                $datos[$tabla_act]['iIdDetalleEntregable'] = $detalle[0]->iIdDetalleEntregable;
                                                $datos[$tabla_act]['iIdDetalleActividad'] = $detalle[0]->iIdDetalleActividad;

                                            }
                                        }
                                        $datos[$tabla_act][$anio_act][$mun_act][] = $vchar[$i];
                                    }
                                    $cont++;                                    
                                }                                
                            }
                            elseif(count($anio_tab) == 2)
                            {
                                if(count($anio_tab) > 0 && $tabla_act != '' && $mun_act!='')
                                {
                                    //if($cont_anio < 6 ) $anio_act = $anio_tab[0];
                                    //elseif($cont_anio >= 6 && $cont_anio < 12) $anio_act = $anio_tab[1];
                                    //else $cont_anio = 0;

                                    if(in_array($vchar[$i-1], $mun) || in_array($vchar[$i-2], $mun) || in_array($vchar[$i-3], $mun) || in_array($vchar[$i-4], $mun) || in_array($vchar[$i-5], $mun) || in_array($vchar[$i-6], $mun))
                                    {

                                        if(!isset($datos[$tabla_act]['actividad'])) $datos[$tabla_act]['actividad'] = $tit_act[0];
                                        if(!isset($datos[$tabla_act]['entregable'])) $datos[$tabla_act]['entregable'] = $tit_act[1];

                                        $exp_tab = explode('.', $tabla_act);
                                        $n_tab = $exp_tab[0].'.'.$exp_tab[1];

                                        //$datos[$tabla_act]['explode'] = $exp_tab;
                                        //$datos[$tabla_act]['tab'] = $n_tab;

                                        if(isset($tablas[$n_tab]))
                                        {                                            
                                            $entregableid = $tablas[$n_tab]['iIdEntregable']; 
                                            $actividadid = $tablas[$n_tab]['iIdActividad'];

                                            $datos[$tabla_act]['vDependencia'] = $tablas[$n_tab]['vDependencia'];
                                            $datos[$tabla_act]['vEje'] = $tablas[$n_tab]['vEje'];
                                            $datos[$tabla_act]['iOds'] = $tablas[$n_tab]['iOds'];

                                            //$datos[$tabla_act]['iIdEntregable'] = $tablas[$n_tab]['iIdEntregable']; 
                                            //$datos[$tabla_act]['iIdActividad'] = $tablas[$n_tab]['iIdActividad'];
                                            
                                            $detalle = $this->mra->carga_detalle($entregableid, $actividadid, $anio_tab[0]);                                            
                                            if(count($detalle) > 0 && $detalle != false)
                                            {
                                                $datos[$tabla_act]['iIdActividad'] = $detalle[0]->iIdActividad;
                                                $datos[$tabla_act]['iIdEntregable'] = $detalle[0]->iIdEntregable;
                                                $datos[$tabla_act]['iIdDetalleEntregable'] = $detalle[0]->iIdDetalleEntregable;
                                                $datos[$tabla_act]['iIdDetalleActividad'] = $detalle[0]->iIdDetalleActividad;

                                            }
                                        }
                                        $datos[$tabla_act][$anio_tab[0]][$mun_act][] = $vchar[$i];
                                    }
                                    elseif(in_array($vchar[$i-8], $mun) || in_array($vchar[$i-9], $mun) || in_array($vchar[$i-10], $mun) || in_array($vchar[$i-11], $mun) || in_array($vchar[$i-12], $mun) || in_array($vchar[$i-13], $mun))
                                    {                                        
                                        if(!isset($datos[$tabla_act]['actividad'])) $datos[$tabla_act]['actividad'] = $tit_act[0];
                                        if(!isset($datos[$tabla_act]['entregable'])) $datos[$tabla_act]['entregable'] = $tit_act[1];

                                        $exp_tab = explode('.', $tabla_act);
                                        $n_tab = $exp_tab[0].'.'.$exp_tab[1];

                                        //$datos[$tabla_act]['explode'] = $exp_tab;
                                        //$datos[$tabla_act]['tab'] = $n_tab;

                                        if(isset($tablas[$n_tab])) 
                                        {
                                            $entregableid = $tablas[$n_tab]['iIdEntregable']; 
                                            $actividadid = $tablas[$n_tab]['iIdActividad'];

                                            $datos[$tabla_act]['vDependencia'] = $tablas[$n_tab]['vDependencia'];
                                            $datos[$tabla_act]['vEje'] = $tablas[$n_tab]['vEje'];
                                            $datos[$tabla_act]['iOds'] = $tablas[$n_tab]['iOds'];

                                            //$datos[$tabla_act]['iIdEntregable'] = $tablas[$n_tab]['iIdEntregable']; 
                                            //$datos[$tabla_act]['iIdActividad'] = $tablas[$n_tab]['iIdActividad'];

                                            $detalle = $this->mra->carga_detalle($entregableid, $actividadid, $anio_tab[1]);                                            
                                            if(count($detalle) > 0 && $detalle != false)
                                            {
                                                $datos[$tabla_act]['iIdActividad'] = $detalle[0]->iIdActividad;
                                                $datos[$tabla_act]['iIdEntregable'] = $detalle[0]->iIdEntregable;
                                                $datos[$tabla_act]['iIdDetalleEntregable'] = $detalle[0]->iIdDetalleEntregable;
                                                $datos[$tabla_act]['iIdDetalleActividad'] = $detalle[0]->iIdDetalleActividad;

                                            }
                                        }
                                        $datos[$tabla_act][$anio_tab[1]][$mun_act][] = $vchar[$i];
                                    }

                                    $cont++;
                                    //$cont_anio++;
                                }
                            }
                        }
                    }

                }                
            }
        }
        

        //print_r($datos);
        /**************************** genera excel *************************/
        //foreach ($datos as $key => $vdatos) {
        //    $eje = explode('.', $key);
        //    $resp = $this->excel_anex($key, $vdatos, $eje[0]);
        //    print_r($resp);
        //    //echo $key;
        //    //print_r($vdatos);
        //}

        /**************************** genera excel *************************/

        //$resp = $this->excel_anex_resp($datos);
        $tabla;
        $eje;
        $nombre;

        //print_r($datos);
        foreach ($datos as $kdatos => $vdatos) {
            
            $tabla = $kdatos;
            $exp = explode('.', $tabla);
            $eje = $exp[0];
            $nombre = $vdatos['actividad'].'. '.$vdatos['entregable'];            
            //$anio = $vdatos['anio'];
            

            //echo $kdatos; print_r($vdatos);
            $datos_anex = array(
                'eje' => $eje,
                'notabla' =>  $tabla,
                'nombretabla' =>  $nombre,
                //'avance' =>  '',
                //'totalbene' =>  '',
                //'beneh' =>  '',
                //'benem' =>  '',
                //'discapacitados' =>  '',
                //'mayahablantes' =>  '',
                'iidactividad' => $vdatos['iIdActividad'],          
                'iidentregable' => $vdatos['iIdEntregable']            
            );
            //print_r($vdatos);

            foreach ($vdatos as $kanio => $vanio) {
                if(is_array($vanio))
                {
                    $datos_anex['anio'] = $kanio;                    
                    foreach ($vanio as $kmun => $vmun) {
                    echo $vmun[5];
                    /*
                        $datos_anex['municipio'] = $kmun;

                        $datos_anex['avance']= $vmun[0];
                        $datos_anex['totalbene']= $vmun[1];
                        $datos_anex['beneh']= $vmun[2];
                        $datos_anex['benem']= $vmun[3];
                        $datos_anex['discapacitados']= $vmun[4];
                        $datos_anex['mayahablantes']= $vmun[5];
                        //print_r($datos_anex);
                        $insert = $this->mra->guarda_anex($datos_anex);
                        echo $insert;
                    */
                    }
                }
            }
            



        }
    }

    private function excel_anex_resp($datos)
    {
        print_r($datos);
        $dir = 'public/reportes/datos_abiertos/';
        if(is_dir($dir)==false)
        {
            if(!mkdir($dir, 0777, true)) {
                die('Fallo al crear las carpetas...');                
            }                        
        }    
    }

    private function excel_anex($tabla, $datos, $eje)
    {        
        
        $dir = 'public/reportes/anexos/'.$eje.'/';

        /************************************************************************/
        
        $reporte = new PHPExcel();
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $reporte = $reader->load('public/reportes/anexo_rep.xls');

        $reporte->setActiveSheetIndex('0');
        $cont_anex = 2;
        $anio_actual = '';

        echo $eje;
        foreach ($datos as $key => $vdatos) {            
            if(is_array($vdatos))
            {
                //echo $key;
                //print_r($vdatos);

                if($key == 2018)
                {
                    foreach ($vdatos as $key3 => $vanio) {
                        $reporte->getActiveSheet()->SetCellValue('A'.$cont_anex, $key3);
                        $reporte->getActiveSheet()->SetCellValue('B'.$cont_anex, $vanio[0]);
                        $reporte->getActiveSheet()->SetCellValue('C'.$cont_anex, $vanio[1]);
                        $reporte->getActiveSheet()->SetCellValue('D'.$cont_anex, $vanio[2]);
                        $reporte->getActiveSheet()->SetCellValue('E'.$cont_anex, $vanio[3]);
                        $reporte->getActiveSheet()->SetCellValue('F'.$cont_anex, ($vanio[4] == 'ND') ? 0 : $vanio[4]);
                        $reporte->getActiveSheet()->SetCellValue('G'.$cont_anex, ($vanio[5] == 'ND') ? 0 : $vanio[5]);

                        $cont_anex++;
                    }
                }
                elseif($key == 2019)
                {
                    if($cont_anex > 2) $cont_anex = 2;
                    foreach ($vdatos as $key3 => $vanio) {
                        $reporte->getActiveSheet()->SetCellValue('J'.$cont_anex, $key3);
                        $reporte->getActiveSheet()->SetCellValue('K'.$cont_anex, $vanio[0]);
                        $reporte->getActiveSheet()->SetCellValue('L'.$cont_anex, $vanio[1]);
                        $reporte->getActiveSheet()->SetCellValue('M'.$cont_anex, $vanio[2]);
                        $reporte->getActiveSheet()->SetCellValue('N'.$cont_anex, $vanio[3]);
                        $reporte->getActiveSheet()->SetCellValue('O'.$cont_anex, ($vanio[4] == 'ND') ? 0 : $vanio[4]);
                        $reporte->getActiveSheet()->SetCellValue('P'.$cont_anex, ($vanio[5] == 'ND') ? 0 : $vanio[5]);

                        $cont_anex++;
                    }
                }
            }
        }

        if(is_dir($dir)==false)
        {
            if(!mkdir($dir, 0777, true)) {
                die('Fallo al crear las carpetas...');
                $ruta = 'public/reportes/'.$tabla.'.xls';
            }            
            else 
                $ruta = $dir.$tabla.'.xls';
        }
        else 
            $ruta = $dir.$tabla.'.xls';


        $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');        
        $imprimir->save($ruta);
        echo 'ok: '.$tabla;
        

        /*********************************************************************/

        /*
        $reporte = new PHPExcel();
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $reporte = $reader->load('public/reportes/anexo_rep.xls');

        $reporte->setActiveSheetIndex('0');
        $cont_anex = 2;
        $anio_actual = '';
        foreach ($datos as $key => $vdato) {
            foreach ($vdato as $key2 => $value) {                
                if(is_array($value))
                {
                    if($key2 == 2018)
                    {
                        foreach ($value as $key3 => $vanio) {
                            $reporte->getActiveSheet()->SetCellValue('A'.$cont_anex, $key3);
                            $reporte->getActiveSheet()->SetCellValue('B'.$cont_anex, $vanio[0]);
                            $reporte->getActiveSheet()->SetCellValue('C'.$cont_anex, $vanio[1]);
                            $reporte->getActiveSheet()->SetCellValue('D'.$cont_anex, $vanio[2]);
                            $reporte->getActiveSheet()->SetCellValue('E'.$cont_anex, $vanio[3]);
                            $reporte->getActiveSheet()->SetCellValue('F'.$cont_anex, ($vanio[4] == 'ND') ? 0 : $vanio[4]);
                            $reporte->getActiveSheet()->SetCellValue('G'.$cont_anex, ($vanio[5] == 'ND') ? 0 : $vanio[5]);

                            $cont_anex++;
                        }
                    }
                    elseif($key2 == 2019)
                    {
                        if($cont_anex > 2) $cont_anex = 2;
                        foreach ($value as $key3 => $vanio) {
                            $reporte->getActiveSheet()->SetCellValue('J'.$cont_anex, $key3);
                            $reporte->getActiveSheet()->SetCellValue('K'.$cont_anex, $vanio[0]);
                            $reporte->getActiveSheet()->SetCellValue('L'.$cont_anex, $vanio[1]);
                            $reporte->getActiveSheet()->SetCellValue('M'.$cont_anex, $vanio[2]);
                            $reporte->getActiveSheet()->SetCellValue('N'.$cont_anex, $vanio[3]);
                            $reporte->getActiveSheet()->SetCellValue('O'.$cont_anex, ($vanio[4] == 'ND') ? 0 : $vanio[4]);
                            $reporte->getActiveSheet()->SetCellValue('P'.$cont_anex, ($vanio[5] == 'ND') ? 0 : $vanio[5]);

                            $cont_anex++;
                        }
                    }
                }
            }            
        }
        
        $ruta = 'public/reportes/'.$eje[0].'/2.5.xls';
        $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
        $imprimir->save($ruta); 

        */
    }    

    public function rep_excel()
    {
        $datos = json_decode($this->input->post('datos'));        
        $cont = 2;
        $reporte = new PHPExcel();
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $reporte = $reader->load('public/reportes/rev_anexo.xls');

        $reporte->setActiveSheetIndex('0');
        
        for ($i=0; $i < count($datos); $i++) {             
            $reporte->getActiveSheet()->SetCellValue('A'.$cont, $datos[$i]->actid);
            $reporte->getActiveSheet()->SetCellValue('B'.$cont, $datos[$i]->actividad);
            $reporte->getActiveSheet()->SetCellValue('C'.$cont, $datos[$i]->entid);
            $reporte->getActiveSheet()->SetCellValue('D'.$cont, $datos[$i]->entregable);
            $reporte->getActiveSheet()->SetCellValue('E'.$cont, $datos[$i]->ejeid);
            $reporte->getActiveSheet()->SetCellValue('F'.$cont, $datos[$i]->nom_ar);
            $reporte->getActiveSheet()->SetCellValue('G'.$cont, $datos[$i]->cont);
            $reporte->getActiveSheet()->SetCellValue('H'.$cont, $datos[$i]->ods);
            $reporte->getActiveSheet()->SetCellValue('I'.$cont, $datos[$i]->depid);

            $cont++;
        }
        
        $ruta = 'public/reportes/rep_anexo.xls';
        $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
        $imprimir->save($ruta);
        echo 'ok';
    }


    public function carga_actividades()
    {
        $ejeid = $this->input->post('SelEje');
        $anio = $this->input->post('anio');
        $maya = (isset($_POST['maya'])) ? true:false;
        $actividades = $this->mra->carga_actividades_mapa($ejeid, $anio);        
        if($actividades!=false && count($actividades) > 0)
        {
            $cont = 1;
            foreach ($actividades as $vact)
            {
                $municipios = $this->mra->carga_municipios($vact->iIdEntregable);
                $anios = $this->mra->carga_anios($vact->iIdEntregable, $anio);
                $total_ben = $this->mra->valida_totalben($vact->iIdEntregable);
                
                // Para determinar y dar formato a los titulos de las tablas
                $vact->vNombreActividad = trim($vact->vNombreActividad);
                $vact->vNombreEntregable = trim($vact->vNombreEntregable);
                $vact->vNombreEntregableMaya = trim($vact->vNombreEntregableMaya);

                if(substr($vact->vNombreActividad, -1) != '.') $vact->vNombreActividad.='. ';
                if(substr($vact->vNombreEntregable, -1) != '.') $vact->vNombreEntregable.='.';
                if(substr($vact->vNombreEntregableMaya, -1) != '.') $vact->vNombreEntregableMaya.='.';

                /*************************************************************/

                if(count($total_ben) > 0)
                {
                    $tot_disc = $total_ben[0]->discap;
                    $tot_len = $total_ben[0]->leng;

                    if($tot_len == 0)
                        $vact->benmy_nd = 1;
                    else 
                        $vact->benmy_nd = 0;

                    if($tot_disc == 0)
                        $vact->bend_nd = 1;
                    else 
                        $vact->bend_nd = 0; 
                }
                else 
                {
                    $vact->bend_nd = 0;
                    $vact->benmy_nd = 0;
                }

                if(count($municipios) > 0 && count($anios) > 0)
                {
                    $vact->datos = 1;
                    $vact->numtabla = $cont;
                    $cont++;
                }
                else
                { 
                    $vact->datos = 0;
                    $vact->numtabla = $cont;
                }
            }
            $resp['datos'] = $actividades;

            $resp['resp'] = 'correcto';
            $resp['message'] = 'Correcto';
        }
        else 
        {
            $resp['datos'] = array();
            $resp['resp'] = 'error_d';
            $resp['message'] = 'Sin actividades';
        }

        echo json_encode($resp);

    }

    public function genera_archivos()
    {
        ini_set('max_execution_time', 300); // 5 Minutos máximo
        $sel_eje = $this->input->post('sel_eje', TRUE);
        $sel_anio = $this->input->post('sel_anio', TRUE);
        $numods = $this->input->post('sel_numods', TRUE);

        $actid = $this->input->post('iIdActividad', TRUE);
        $entid = $this->input->post('iIdEntregable', TRUE);
        //$depid = $this->input->post('iIdDependencia', TRUE);
        $ejeid = $this->input->post('iIdEje', TRUE);
        //$temaid = $this->input->post('iIdTema', TRUE);
        $actividad = $this->input->post('vActividad', TRUE);
        $entregable = $this->input->post('vEntregable', TRUE);
        $entregable_maya = $this->input->post('vTituloMaya',true);
        $mismoben = $this->input->post('iMismosBeneficiarios', TRUE);
        $cont = $this->input->post('cont', TRUE);

        $benmy_nd = $this->input->post('benmy_nd', TRUE);
        $bend_nd = $this->input->post('bend_nd', TRUE);
        // Titulo (se cambio debido a que se implemento una versión en lengua maya)
        $leng = $this->input->post('maya',true); // Indica el idioma 0: Español, 1: Maya
        $numtabla = $this->input->post('numtabla',true);

        $titulo = ($leng == 0) ? $actividad.$entregable:$entregable_maya; 

        $txtEntregable = array(0 => 'Entregables', 1 => 'K`uubi');
        $txtBenH = array(0 => 'Beneficiarios Hombres', 1 => 'Anta´an Xi´ib');
        $txtBenM = array(0 => 'Beneficiarios Mujeres', 1 => 'Anta´an Co´olel');
        $txtMun = array(0 => 'Municipios', 1 => 'méektaankajilo’ob');
        $txtCont = array(0 => '(Continuación)', 1 => '(Táanil)');
        $txtFuen = array(0 => 'Fuente: Elaborado con datos del SIGO con información de ', 1 => 'Cuuchil beeta´an yeetel baaloob u t´ia ojeetbil SIGO u t´ia ojeetbil ');
        $imgODS = array(0 => '_500.png', 1=> '_m_500.png');
        
        $c_tem = 0;        
        $b_ini = 0;
        $b_fin = 0;
        $indices = array('1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '2.1', '2.2', '2.3', '2.4', '2.5', '2.6', '3.1', '3.2', '3.3', '3.4', '3.5', '3.6', '4.1', '4.2', '4.3', '4.4', '4.5', '4.6', '4.7', '5.1', '5.2', '6.1', '6.2', '7.1', '7.2', '7.3', '8.1', '8.2', '8.3', '8.4', '9.1', '9.2', '9.3', '9.4', '10.1');

        switch ($sel_eje) {
            case 1: $rc = 0; $gc = 169; $bc = 132; break;
            case 2: $rc =12; $gc =63; $bc =108; break;
            case 3: $rc = 126; $gc = 101; $bc = 170; break;
            case 4: $rc = 149; $gc = 193; $bc = 31; break;
            case 5: $rc = 110; $gc = 54; $bc = 140; break;
            case 6: $rc = 0; $gc = 168; $bc = 228; break;
            case 7: $rc = 29; $gc = 29; $bc = 27; break;
            case 8: $rc = 78; $gc = 137; $bc = 148; break;
            case 9: $rc = 56; $gc = 115; $bc = 185; break;
            default:  $rc = 0; $gc = 45; $bc = 100; break;
        }

        if($entid > 0 && $actid > 0)
        {
            $municipios = $this->mra->carga_municipios($entid);
            $anios = $this->mra->carga_anios($entid, $sel_anio);
            //$nom_dep = $this->mra->carga_dependencia($depid);
            $nom_dep = $this->mra->carga_dependencia2($actid);
            $c_an = count($anios);
            $c_mun = 0;
            $ar_an = array();
            $ar_an2 = array();

            if(count($municipios) > 0 && count($anios) > 0)
            {
                if($b_ini==0)
                {
                    $pdf = new ReportePdf('L', 'mm', 'A4', true, 'UTF-8', false);
                    $pdf->SetTitle('Tabla_Anexo_'.$sel_eje);
                    $pdf->SetHeaderMargin(30);
                    $pdf->SetTopMargin(30);                
                    $pdf->setFooterMargin(20);
                    $pdf->SetAutoPageBreak(true);
                    $pdf->SetAuthor('SEPLAN');
                    $pdf->SetDisplayMode('real', 'default');
                    $pdf->setPrintHeader(false);
                    $pdf->setPrintFooter(false);
                    $b_ini = 1;
                    $b_fin = 1;
                }

                $pdf->AddPage('L', 'A4');

                if($entid != $c_tem) { $c_tem = $entid; }
                $nom_tabla = 'Tabla '.$ejeid.'.'.$numtabla.'. '.$titulo;


                $pdf->SetTextColor($rc, $gc, $bc);
                $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array($rc, $gc, $bc)));
                $pdf->SetFont('pantonblack', '', 12);
                $pdf->MultiCell(250, 5, $nom_tabla, 0, 'L', 0, 1, '', '', true);
                $pdf->SetFont('pantonblack', '', 8);
                $pdf->MultiCell(250, 5, '', 0, 'L', 0, 1, '', '', true);
                $pdf->MultiCell(250, 5, '', 0, 'L', 0, 1, '', '', true);
                /* colocar número de páginas */

                $pdf->Image('public/img/ods/'.$numods.$imgODS[$leng], 273, 14, 15, 15, 'PNG', '', '', false, 300, '', false, false, 0, 'C', false, false);                   

                $pdf->SetFillColor($rc, $gc, $bc);
                $pdf->SetFont('barlowb', '', 6);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->MultiCell(20, 13, $txtMun[$leng], 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');

                $init = 30;
                if($c_an > 1)
                {
                    $ln = 0;
                    $ln_h = 0;
                    //$cl1 = 125;
                    $cl2 = 18; $cl3 = 19; $cl4 = 19; $cl5 = 19; $cl6 = 25; $cl7 = 25; $ln = 0;
                    $cl1 = $cl2 + $cl4 + $cl5;
                }
                else 
                {                            
                    $ln = 1;
                    $ln_h = 1;
                    //$cl1 = 210; 
                    $cl2 = 30; $cl3 = 30; $cl4 = 35; $cl5 = 30; $cl6 = 45; $cl7 = 40; $ln = 1;
                    $cl1 = $cl2 + $cl4 + $cl5;
                }

                $c_can = $c_an;
                foreach ($anios as $van)
                {
                    //$ar_acum[$van->iAnio] = array('t_ent' => 0, 't_ben' => 0, 't_benh' => 0, 't_benm' => 0, 't_bend' => 0, 't_benmy' => 0);
                    //$acum_reg = array("1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0);
                    $ar_acum[$van->iAnio] = array('t_ent' => 0, 't_benh' => 0, 't_benm' => 0);
                    $acum_reg = array("1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0);

                    $ar_an[$van->iAnio] = $van->iAnio;
                    
                    $pdf->MultiCell($cl1, 5, $van->iAnio, 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(5, 5, '', 1, 'C', 1, $ln, '', '', true);

                    $c_can--;
                    if($c_can <= 1) $ln = 1;
                }

                $c_can = $c_an;
                foreach ($ar_an as $van_p) {
                    $init = ($c_an == $c_can) ? $init:'';
                    $pdf->MultiCell($cl2, 8, $txtEntregable[$leng], 1, 'C', 1, 0, $init, '', true);
                    //$pdf->MultiCell($cl3, 8, 'Total de Beneficiarios', 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell($cl4, 8, $txtBenH[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell($cl5, 8, $txtBenM[$leng], 1, 'C', 1, 0, '', '', true);
                    //$pdf->MultiCell($cl6, 8, 'Beneficiarios con Discapacidad', 1, 'C', 1, 0, '', '', true);
                    //$pdf->MultiCell($cl7, 8, 'Beneficiarios Maya hablantes', 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(5, 8, '', 1, 'C', 1, $ln_h, '', '', true);

                    $c_can--;
                    if($c_can <= 1) { $ln_h = 1;}
                }

                foreach ($municipios as $vmun) {
                    $init_s = 30;
                    if($c_an > 1)
                    {
                        $ln_s = 0;
                        $ln_hs = 0;                                    
                    }
                    else 
                    {                                    
                        $ln_s = 1;
                        $ln_hs = 1;                                    
                    }

                    if($c_mun == 16)
                    {
                        /********************************+ pinta de nuevo el encabezado*******************************************/
                        $pdf->AddPage('L', 'A4');

                        $nom_tabla = 'Tabla '.$ejeid.'.'.$numtabla.'. '.$titulo.' '.$txtCont[$leng];
                        $pdf->SetTextColor($rc, $gc, $bc);
                        $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array($rc, $gc, $bc)));
                        $pdf->SetFont('pantonblack', '', 12);
                        $pdf->MultiCell(250, 5, $nom_tabla, 0, 'L', 0, 1, '', '', true);
                        $pdf->SetFont('pantonblack', '', 8);
                        //$pdf->MultiCell(250, 5, 'Acciones y beneficiarios por sexo y municipio', 0, 'L', 0, 1, '', '', true);
                        $pdf->MultiCell(250, 5, '', 0, 'L', 0, 1, '', '', true);
                        $pdf->Image('public/img/ods/'.$numods.$imgODS[$leng], 273, 14, 15, 15, 'PNG', '', '', false, 300, '', false, false, 0, 'C', false, false);
                        $pdf->SetFillColor($rc, $gc, $bc);
                        $pdf->SetFont('barlowb', '', 6);
                        $pdf->SetTextColor(255, 255, 255);
                        $pdf->MultiCell(20, 13, $txtMun[$leng], 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');

                        

                        $c_can = $c_an;
                        foreach ($anios as $van) 
                        {
                            $ar_an2[$van->iAnio] = $van->iAnio;
                            $pdf->MultiCell($cl1, 5, $van->iAnio, 1, 'C', 1, 0, '', '', true);
                            $pdf->MultiCell(5, 5, '', 1, 'C', 1, $ln_s, '', '', true);

                            $c_can--;
                            if($c_can <= 1) $ln_s = 1;
                        }

                        $c_can = $c_an;
                        foreach ($ar_an2 as $van_p) {
                            $init_s = ($c_an == $c_can) ? $init_s:'';
                            $pdf->MultiCell($cl2, 8, $txtEntregable[$leng], 1, 'C', 1, 0, $init_s, '', true);
                            //$pdf->MultiCell($cl3, 8, 'Total de Beneficiarios', 1, 'C', 1, 0, '', '', true);
                            $pdf->MultiCell($cl4, 8, $txtBenH[$leng], 1, 'C', 1, 0, '', '', true);
                            $pdf->MultiCell($cl5, 8, $txtBenM[$leng], 1, 'C', 1, 0, '', '', true);
                            //$pdf->MultiCell($cl6, 8, 'Beneficiarios con Discapacidad', 1, 'C', 1, 0, '', '', true);
                            //$pdf->MultiCell($cl7, 8, 'Beneficiarios Maya hablantes', 1, 'C', 1, 0, '', '', true);
                            $pdf->MultiCell(5, 8, '', 1, 'C', 1, $ln_hs, '', '', true);

                            $c_can--;
                            if($c_can <= 1) { $ln_hs = 1;}
                        }

                        /********************************+ pinta de nuevo el encabezado*******************************************/
                        $c_mun = 1;
                    }

                    $pdf->MultiCell(20, 8, $vmun->vMunicipio, 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
                    $c_m = $c_an;
                    $ln_av = ($c_an > 1) ? 0 : 1;
                    $pdf->SetFont('barlow', '', 6);
                    $pdf->SetTextColor(0, 0, 0); 
                    foreach ($anios as $van_d)
                    {
                        if($mismoben == 1) 
                        {
                            $ultimo_mes = $this->mra->carga_umes($entid, $van_d->iAnio);
                            $ult_m = $ultimo_mes[0]->mes;
                        }
                        else $ult_m = 0;

                        
                        $avances = $this->mra->carga_avances($vmun->iIdMunicipio, $entid, $van_d->iAnio, 0);
                        $avances_mben = $this->mra->carga_avances($vmun->iIdMunicipio, $entid, $van_d->iAnio, $ult_m);

                        if($avances!=false && count($avances) > 0) 
                        {
                            if($mismoben == 1)
                            {

                                $t_ent = $avances[0]->sum_avance;
                                if(count($avances_mben) > 0)
                                {
                                    //$t_ben = $avances_mben[0]->sum_benh + $avances_mben[0]->sum_benm;
                                    $t_benh = $avances_mben[0]->sum_benh;
                                    $t_benm = $avances_mben[0]->sum_benm;
                                    //$t_bend = $avances_mben[0]->sum_disch + $avances_mben[0]->sum_discm;
                                    //$t_benmy = $avances_mben[0]->sum_lenh + $avances_mben[0]->sum_lenm;
                                }
                                else
                                {
                                    $t_ben = 0;
                                    $t_benh = 0;
                                    $t_benm = 0;
                                    $t_bend = 0;
                                    $t_benmy = 0;
                                }
                                
                            }
                            else
                            {
                                $t_ent = $avances[0]->sum_avance;
                                //$t_ben = $avances[0]->sum_benh + $avances[0]->sum_benm;
                                $t_benh = $avances[0]->sum_benh;
                                $t_benm = $avances[0]->sum_benm;
                                //$t_bend = $avances[0]->sum_disch + $avances[0]->sum_discm;
                                //$t_benmy = $avances[0]->sum_lenh + $avances[0]->sum_lenm;
                            }


                            /*****************************+ acumulados por entregable y municipios ***************************************/

                            $ar_acum[$van_d->iAnio]['t_ent'] += $t_ent;
                            //$ar_acum[$van_d->iAnio]['t_ben'] += $t_ben;
                            $ar_acum[$van_d->iAnio]['t_benh'] += $t_benh;
                            $ar_acum[$van_d->iAnio]['t_benm'] += $t_benm;
                            //$ar_acum[$van_d->iAnio]['t_bend'] += $t_bend;
                            //$ar_acum[$van_d->iAnio]['t_benmy'] += $t_benmy;

                            $region = $this->mra->carga_region($vmun->iIdMunicipio);
                            
                            $reg_id = $region[0]->iIdRegion;
                            $acum_reg[$reg_id]+= $t_ent;

                            /*if($t_bend > 0) 
                                $txt_d = (is_float($t_bend)) ? number_format($t_bend, 1, '.', ',') : number_format($t_bend, 0, '.', ',');
                            else
                            {
                                
                                
                                if($bend_nd == 1)
                                    $txt_d = 'ND';
                                else 
                                    $txt_d = 0;
                            }

                            if($t_benmy > 0) 
                                $txt_my = (is_float($t_benmy)) ? number_format($t_benmy, 1, '.', ',') : number_format($t_benmy, 0, '.', ',');                         
                            else
                            {
                                if($benmy_nd == 1)
                                    $txt_my = 'ND';
                                else 
                                    $txt_my = 0;
                            }*/


                            
                            $txt_ent = Decimal($t_ent); //(is_float($t_ent)) ? number_format($t_ent, 2, '.', ',') : number_format($t_ent, 0, '.', ',');
                            //$txt_ben = (is_float($t_ben)) ? number_format($t_ben, 1, '.', ',') : number_format($t_ben, 0, '.', ',');
                            $txt_benh = (is_float($t_benh)) ? number_format($t_benh, 1, '.', ',') : number_format($t_benh, 0, '.', ',');
                            $txt_benm = (is_float($t_benm)) ? number_format($t_benm, 1, '.', ',') : number_format($t_benm, 0, '.', ',');

                            /*****************************+ acumulados por entregable y municipios ***************************************/

                            $pdf->MultiCell($cl2, 8, $txt_ent, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            //$pdf->MultiCell($cl3, 8, $txt_ben, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            $pdf->MultiCell($cl4, 8, $txt_benh, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            $pdf->MultiCell($cl5, 8, $txt_benm, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            //$pdf->MultiCell($cl6, 8, $txt_d, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M'); 
                            //$pdf->MultiCell($cl7, 8, $txt_my, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            $pdf->MultiCell(5, 8, '', 1, 'C', 1, $ln_av, '', '', true);
                        }
                        else
                        {
                            $pdf->MultiCell($cl2, 8, 0, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            //$pdf->MultiCell($cl3, 8, 0, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            $pdf->MultiCell($cl4, 8, 0, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            $pdf->MultiCell($cl5, 8, 0, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            //$pdf->MultiCell($cl6, 8, ($bend_nd == 1) ? 'ND' : 0, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M'); 
                            //$pdf->MultiCell($cl7, 8, ($benmy_nd == 1) ? 'ND' : 0, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
                            $pdf->MultiCell(5, 8, '', 1, 'C', 1, $ln_av, '', '', true);

                        }

                        $c_m--;
                        if($c_m <= 1) $ln_av = 1;
                    }
                    $pdf->SetFont('barlowb', '', 6);
                    $pdf->SetTextColor(255, 255, 255);
                    
                    $c_mun++;
                }

                $init_ac = 30;
                $c_acum = $c_an;
                foreach ($ar_acum as $vacum) 
                {                
                    $txt_ent_ac = Decimal($vacum['t_ent']);//(is_float($vacum['t_ent'])) ? number_format($vacum['t_ent'], 1, '.', ',') : number_format($vacum['t_ent'], 0, '.', ',');
                    //$txt_ben_ac = (is_float($vacum['t_ben'])) ? number_format($vacum['t_ben'], 1, '.', ',') : number_format($vacum['t_ben'], 0, '.', ',');                         
                    $txt_benh_ac = (is_float($vacum['t_benh'])) ? number_format($vacum['t_benh'], 1, '.', ',') : number_format($vacum['t_benh'], 0, '.', ',');
                    $txt_benm_ac = (is_float($vacum['t_benm'])) ? number_format($vacum['t_benm'], 1, '.', ',') : number_format($vacum['t_benm'], 0, '.', ',');
                    


                    /*if($vacum['t_bend'] > 0)
                        $txt_bend_ac = (is_float($vacum['t_bend'])) ? number_format($vacum['t_bend'], 1, '.', ',') : number_format($vacum['t_bend'], 0, '.', ',');
                    else
                    {
                        if($bend_nd == 1)
                            $txt_bend_ac = 'ND';
                        else 
                            $txt_bend_ac = 0;
                    }


                    if($vacum['t_benmy'] > 0)
                        $txt_benmy_ac = (is_float($vacum['t_benmy'])) ? number_format($vacum['t_benmy'], 1, '.', ',') : number_format($vacum['t_benmy'], 0, '.', ',');
                    else
                    {
                        if($benmy_nd == 1)
                            $txt_benmy_ac = 'ND';
                        else 
                            $txt_benmy_ac = 0;
                    }
                    */


                    $pdf->MultiCell($cl2, 8, $txt_ent_ac, 1, 'C', 1, 0, $init_ac, '', true, 0, false, true, 8, 'M');
                    //$pdf->MultiCell($cl3, 8, $txt_ben_ac, 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
                    $pdf->MultiCell($cl4, 8, $txt_benh_ac, 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
                    $pdf->MultiCell($cl5, 8, $txt_benm_ac, 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
                    //$pdf->MultiCell($cl6, 8, $txt_bend_ac, 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
                    //$pdf->MultiCell($cl7, 8, $txt_benmy_ac, 1, 'C', 1, 0, '', '', true, 0, false, true, 8, 'M');
                    $pdf->MultiCell(5, 8, '', 1, 'C', 1, 0, '', '', true);

                    $c_acum--;
                    if($c_acum != $c_an) $init_ac = '';

                }
                
                if(count($nom_dep) > 0 && $nom_dep!=false)
                {                    
                    $fuente = $txtFuen[$leng].$nom_dep[0]->vNombreCorto.'.';
                    $nombre_dep = $nom_dep[0]->vNombreCorto;
                }
                else
                {
                    $fuente = 'Fuente no disponible.';
                    $nombre_dep = '';
                }
                
                $pdf->ln(17);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('barlow', '', 8);
                
                /*if($bend_nd == 1 || $benmy_nd == 1)
                {
                    $pdf->MultiCell(0, 5, 'ND: No disponible.', 0, 'L', 0, 1, '', '', true);
                    if($bend_nd == 1 && $benmy_nd == 1)
                        $pdf->MultiCell(0, 5, 'Nota: Los registros administrativos de este programa no identifican beneficiarios con discapacidad ni beneficiarios maya hablantes.', 0, 'L', 0, 1, '', '', true);
                    elseif($bend_nd == 1)
                        $pdf->MultiCell(0, 5, 'Nota: Los registros administrativos de este programa no identifican beneficiarios con discapacidad.', 0, 'L', 0, 1, '', '', true);
                    elseif($benmy_nd == 1) 
                        $pdf->MultiCell(0, 5, 'Nota: Los registros administrativos de este programa no identifican beneficiarios maya hablantes.', 0, 'L', 0, 1, '', '', true);
                }*/

                $pdf->MultiCell(0, 5, $fuente, 0, 'L', 0, 1, '', '', true);
                unset($ar_acum);
            }

            if($b_fin == 1)
            {
                $pdf->lastPage();
                $pdf->Output(__DIR__.'/../../public/reportes/TablaAnexo_'.$ejeid.'.'.$numtabla.'.pdf', 'F');                    
                $resp['resp'] = 'correcto';
                $resp['message'] = 'Reporte generado correctamente';
                $resp['url'] = base_url().'public/reportes/TablaAnexo_'.$ejeid.'.'.$numtabla.'.pdf';
                $resp['nom_ar'] = 'TablaAnexo_'.$ejeid.'.'.$numtabla.'.pdf';
                $resp['ejeid'] = $ejeid;
                $resp['ods'] = $numods;
                $resp['actid'] = $actid;
                $resp['entid'] = $entid;
                $resp['depid'] = $nom_dep[0]->iIdDependencia;
                $resp['actividad'] = $actividad;
                $resp['entregable'] = $entregable;
                $resp['dep'] = $nombre_dep;
                $resp['cont'] = $cont;
            }
            else
            {
                $resp['resp'] = 'error_d';
                $resp['message'] = 'Sin datos';
            }
        }
        else
        {
            $resp['resp'] = 'error_d';
            $resp['message'] = 'Sin datos';
        }

        echo json_encode($resp);

    }

    public function descargar()
    {
        ini_set('max_execution_time', 300); // 5 Minutos máximo
        $anio = $this->input->post('anio', TRUE);
        $eje = $this->input->post('eje', TRUE);
        $maya = $this->input->post('len_maya', TRUE);
        $archivos = $this->input->post('arc');

        // Se genera un excel con la relación de archivos
        $datos = json_decode($this->input->post('datos'));        
        $cont = 2;
        $reporte = new PHPExcel();
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $reporte = $reader->load('public/reportes/rev_anexo.xls');

        $reporte->setActiveSheetIndex('0');
        
        for ($i=0; $i < count($datos); $i++)
        {             
            $reporte->getActiveSheet()->SetCellValue('A'.$cont, $datos[$i]->actid);
            $reporte->getActiveSheet()->SetCellValue('B'.$cont, $datos[$i]->actividad);
            $reporte->getActiveSheet()->SetCellValue('C'.$cont, $datos[$i]->entid);
            $reporte->getActiveSheet()->SetCellValue('D'.$cont, $datos[$i]->entregable);
            $reporte->getActiveSheet()->SetCellValue('E'.$cont, $datos[$i]->ejeid);
            $reporte->getActiveSheet()->SetCellValue('F'.$cont, $datos[$i]->nom_ar);
            $reporte->getActiveSheet()->SetCellValue('G'.$cont, $datos[$i]->cont);
            $reporte->getActiveSheet()->SetCellValue('H'.$cont, $datos[$i]->ods);
            $reporte->getActiveSheet()->SetCellValue('I'.$cont, $datos[$i]->depid);

            $cont++;
        }
        
        $ruta = 'public/reportes/rep_anexo_'.$eje.'.xls';
        $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
        $imprimir->save($ruta);

        // Se genera el anexo de obra
        //$ruta_anexobra = $this->anexo_obra($eje,$anio,$maya);
        $ruta_anexobra = '';
        $t_ar = count($archivos);
        if($t_ar > 0)
        {
            $usid = $_SESSION[PREFIJO.'_idusuario'];
            $directorio = "public/reportes";

            
            $zip = new ZipArchive();
            $dir = $directorio.'/anexo_'.$eje.'_'.$anio.'.zip';           

            if(file_exists($dir))
            {
                unlink($dir);
            }

            if($zip->open($dir, ZIPARCHIVE::CREATE)==TRUE)
            {

                for ($i=0; $i < $t_ar; $i++) {                                         
                    if(file_exists($directorio.'/'.$archivos[$i])) {
                        $zip->addFile($directorio.'/'.$archivos[$i]);                 

                    }                    
                }
                $zip->addFile($directorio.'/rep_anexo_'.$eje.'.xls');
                if($ruta_anexobra != '') $zip->addFile($ruta_anexobra);
                $zip->close();
                

                for ($i=0; $i < $t_ar; $i++)
                {                                         
                    if(file_exists($directorio.'/'.$archivos[$i])) unlink($directorio.'/'.$archivos[$i]);
                }

                unlink($directorio.'/rep_anexo_'.$eje.'.xls');
                if($ruta_anexobra != '') unlink($ruta_anexobra);
                echo $dir;
            }
        }        

    }

    public function anexObra()
    {        
        for ($i=1; $i < 10 ; $i++) { 
            $this->anexo_obra($i,2020,0);
        }
        
    }

    public function anexo_obra($eje,$anio,$leng)
    { 
        ini_set('max_execution_time', 150); // 3 Minutos máximo
        $txtTotal = array(0=>'Inversión total: ',1=>'Tuu laacal: ');
        $txtFuen = array(0 => 'Fuente: Elaborado con datos del Sistema de Seguimiento de Obra Pública.' ,1=>'Cuuchil beeta´an yeetel baaloob u t´ia ojeetbil Sistema de Seguimiento de Obra Pública');
        $txtEquip = array(0=> 'Equipamiento: ', 1=>'Nu´ukulil: ');
        $txtNom = array(0=>'Nombre de la obra', 1=>'meyajo’ob');
        $txtMun = array(0 => 'Municipio', 1=> 'méektaankajilo’ob');
        $txtLoc = array(0 => 'Localidad', 1=> 'Localidad');
        $txtInv = array(0 => 'Inversión', 1=> 'Tu`ux c uta`atal a tak`iin');
        $txtEst = array(0 => 'Estatus', 1=> 'Estatus');
        $txtObras = array(0 => 'Obras ', 1=> 'meyajo’ob ');

        $obras = $this->mra->vista_anexo($eje,$anio);

        if($obras->num_rows() > 0)
        {
            // Consultamos nombres de los ejes
            $veje = $this->mra->datos_eje($eje);

            switch ($eje)
            {
                case 1: $rc = 0; $gc = 169; $bc = 132; break;
                case 2: $rc =12; $gc =63; $bc =108; break;
                case 3: $rc = 126; $gc = 101; $bc = 170; break;
                case 4: $rc = 149; $gc = 193; $bc = 31; break;
                case 5: $rc = 110; $gc = 54; $bc = 140; break;
                case 6: $rc = 0; $gc = 168; $bc = 228; break;
                case 7: $rc = 29; $gc = 29; $bc = 27; break;
                case 8: $rc = 78; $gc = 137; $bc = 148; break;
                case 9: $rc = 56; $gc = 115; $bc = 185; break;
                default: $rc = 0; $gc = 45; $bc = 100; break;
            }

            $pdf = new ReportePdf('L', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Tabla_Anexo_'.$eje);
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(30);                
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('SEPLAN');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            if($leng == 1) $veje->vEje = $veje->vEjeMaya;
            // Primera página
            $pdf->AddPage('L', 'A4');
            $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array($rc, $gc, $bc)));
            $pdf->SetFillColor($rc, $gc, $bc);
            $pdf->SetTextColor($rc, $gc, $bc);
            $pdf->SetFont('pantonblack', '', 12);
            
            // Nombre del eje
            $pdf->MultiCell(0, 8, $veje->vEje, 0, 'L', 0, 1, 25, '', true);
            
            $monto = $anio = 0;
            $grupo = '';
            
            $obras = $obras->result();   
            foreach ($obras as $vob)
            {                        
                $y_nom = 0;
                $y_mun = 0;
                $y_loc = 0;
                if($leng == 1)
                {
                    switch (trim($vob->vEstatus)) {
                        case 'Concluida':
                            $vob->vEstatus = 'Ts’o’oksa’abij';
                            break;
                        case 'En proceso':
                            $vob->vEstatus = 'Táan u meyajta’al';
                            break;
                    }

                    $vob->vNombreModificado = $vob->vNombreMaya;
                }
                
                
                // Estado del cursor en Y
                $act_y = $pdf->getY();

                if($anio != $vob->iAnio)
                {   
                    // Encabezado por año
                    if($anio != 0)
                    { 
                        // Imprimimos los totales
                        /*$pdf->SetTextColor(255, 255, 255);
                        $pdf->SetFont('barlowb', '', 8);
                        $pdf->MultiCell(30, 8,$txtTotal[$leng], 1, 'C', 1, 0, 170, '', true);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('barlowb', '', 8);
                        $pdf->MultiCell(45, 8, '$ '.number_format($monto, 2, '.', ','), 1, 'C', 0, 1, '', '', true);*/
                        $pdf->ln(10);                       
                        $monto = 0;
                    }

                    $pdf->SetTextColor($rc, $gc, $bc);
                    $pdf->SetFont('pantonblack', '', 12);
                    $pdf->MultiCell(0, 8, $txtObras[$leng].$vob->iAnio, 0, 'L', 0, 1, 25, '', true);
                    // Encabezado de las columnas
                    $pdf->SetTextColor(255, 255, 255);
                    $pdf->SetFont('barlowb', '', 8);
                    $pdf->MultiCell(115, 8, $txtNom[$leng], 1, 'C', 1, 0, 25, '', true);
                    $pdf->MultiCell(30, 8, $txtMun[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(30, 8, $txtLoc[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(45, 8, $txtInv[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(25, 8, $txtEst[$leng], 1, 'C', 1, 1, '', '', true);

                    $anio = $vob->iAnio;
                }
                else if($grupo != $vob->vGrupo)
                {
                    $grupo = $vob->vGrupo;
                    // Encabezado por año
                    if($anio != 0)
                    { 
                        // Imprimimos los totales
                        /*$pdf->SetTextColor(255, 255, 255);
                        $pdf->SetFont('barlowb', '', 8);
                        $pdf->MultiCell(30, 8, $txtTotal[$leng], 1, 'C', 1, 0, 170, '', true);
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('barlowb', '', 8);
                        $pdf->MultiCell(45, 8, '$ '.number_format($monto, 2, '.', ','), 1, 'C', 0, 1, '', '', true);
                        */
                        $pdf->ln(10);                       
                        $monto = 0;
                    }
                    $pdf->SetTextColor($rc, $gc, $bc);
                    $pdf->SetFont('pantonblack', '', 12);
                    $pdf->MultiCell(0, 8, $txtEquip[$leng].$veje->vEje, 0, 'L', 0, 1, 25, '', true);
                    // Encabezado de las columnas
                    $pdf->SetTextColor(255, 255, 255);
                    $pdf->SetFont('barlowb', '', 8);
                    $pdf->MultiCell(115, 8, $txtNom[$leng], 1, 'C', 1, 0, 25, '', true);
                    $pdf->MultiCell(30, 8, $txtMun[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(30, 8, $txtLoc[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(45, 8, $txtInv[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(25, 8, $txtEst[$leng], 1, 'C', 1, 1, '', '', true);
                }
                else if($act_y >= 160)  // Verificación brinco de página
                {
                    $pdf->AddPage('L', 'A4');

                    $pdf->SetTextColor(255, 255, 255);
                    $pdf->SetFont('barlowb', '', 8);
                    $pdf->MultiCell(115, 8, $txtNom[$leng], 1, 'C', 1, 0, 25, '', true);
                    $pdf->MultiCell(30, 8, $txtMun[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(30, 8, $txtLoc[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(45, 8, $txtInv[$leng], 1, 'C', 1, 0, '', '', true);
                    $pdf->MultiCell(25, 8, $txtEst[$leng], 1, 'C', 1, 1, '', '', true);
                }

                $pdf->SetFont('barlow', '', 8);

                $y_nom = ceil($pdf->getStringHeight(115, trim($vob->vNombreModificado))+2);
                $y_mun = ceil($pdf->getStringHeight(30, trim($vob->vMunicipio))+2);
                $y_loc = ceil($pdf->getStringHeight(30, trim($vob->vLocalidad))+2);
                
                $y = max($y_nom, $y_mun, $y_loc);

                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell(115, $y, trim($vob->vNombreModificado), 1, 'L', 0, 0, 25, '', true);
                $pdf->MultiCell(30, $y, trim($vob->vMunicipio), 1, 'C', 0, 0, '', '', true);
                $pdf->MultiCell(30, $y, trim($vob->vLocalidad), 1, 'C', 0, 0, '', '', true);
                $pdf->MultiCell(45, $y, '$ '.number_format($vob->nCosto, 2, '.', ','), 1, 'C', 0, 0, '', '', true);
                $pdf->MultiCell(25, $y, trim($vob->vEstatus), 1, 'C', 0, 1, '', '', true);

                $monto+=$vob->nCosto;
            }                   
            
            // Totales
            /*$pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('barlowb', '', 8);
            $pdf->MultiCell(30, 8, $txtTotal[$leng], 1, 'C', 1, 0, 170, '', true);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('barlowb', '', 8);
            $pdf->MultiCell(45, 8, '$ '.number_format($monto, 2, '.', ','), 1, 'C', 0, 1, '', '', true);
            */
            $pdf->ln(10);
            
            $pdf->MultiCell(0, 5, $txtFuen[$leng], 0, 'L', 0, 1, 25, '', true);
        

            $pdf->lastPage();
            ob_end_clean();
            $ruta = 'public/reportes/AnexoObra'.$eje.'.pdf';
            $pdf->Output(__DIR__.'/../../public/reportes/AnexoObra'.$eje.'.pdf', 'F');
        }
        else $ruta = '';
    
        return $ruta;
    }

}