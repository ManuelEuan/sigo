<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Class_PDF extends TCPDF{
    function __construct()
    {
        parent::__construct();
    }
}

class PDF extends Class_PDF {
    public function Header()
    {
        $fontsize = 9;
        $x = $this->GetX();
        $y = $this->GetY() + 5;

        $this->Image('assets/imagenes/logo_yuc_tomo.png', 10, 3, 30, 25, 'PNG','', 'N', false,'', '', false, false, 0, false, false, false);
        $this->SetX($x);
        $this->SetY($y);
        
        $this->SetFillColor(255,255,255);
        $this->SetFont('helvetica','B',$fontsize+5);
        $this->Multicell(0,0,'TuzNetworks',0,'C',false,1);

        $this->SetFont('helvetica','B',$fontsize);        
        $this->Multicell(0,0,'Domicilio de la Dependencia ',0,'C',false,1);        
        $this->Multicell(0,0,'Ciudad, ',0,'C',false,1);
    }

    public function Footer() 
    {
        /*$this->SetFont('helvetica','',7);
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');*/
        $this->Image('assets/imagenes/pie_tomo.png', 10, 3, 30, 25, 'PNG','', 'N', false,'', '', false, false, 0, false, false, false);
    }
}

class MYPDF extends Class_PDF{
    public function Header()
    {
        $fontsize = 9;
        $x = $this->GetX();
        $y = $this->GetY() + 5;
        
        $headerData = $this->getHeaderData();
        $idcliente = $headerData['string']['idcliente'];
        $numpago = $headerData['string']['numpago'];
        $idpago = $headerData['string']['idpago'];
        $fecha = $headerData['string']['fecha'];

		$this->Image('assets/img/solo_logo.jpg', 10, 4, 45, 40, 'JPEG','', 'N', false,'', '', false, false, 0, false, false, false);
        $this->SetX($x);
        $this->SetY($y);
        $this->Multicell(60,0,'',0,'R',false,0);

        $this->SetFillColor(255,255,255);
        $this->RoundedRect(157, $this->GetY(), 43, 20, 3.50, '1111', 'DF');

        $this->SetFont('helvetica','B',$fontsize+5);
        $this->Multicell(70,0,'TuzNetworks',0,'C',false,1);
        $this->Multicell(60,0,'',0,'R',false,0);
        $this->SetFont('helvetica','B',$fontsize);
        $this->Multicell(60,0,'Domicilio de la Dependencia ',0,'C',false,0);
        // Cell auxiliar para acomodar la fecha
        $this->Multicell(28,0,'',0,'C',false,0);
        $this->Multicell(12,0,'Folio :',1,'L',false,0);
        $this->SetFont('helvetica','B',$fontsize+1);
        $this->Multicell(28,0,'  A-'.str_pad($idpago, 5, "0", STR_PAD_LEFT).'-'.$numpago,0,'L',false,1);

        $this->SetFont('helvetica','B',$fontsize);
        $this->Multicell(60,0,'',0,'R',false,0);
        $this->Multicell(50,0,'Ciudad, ',0,'C',false,0);
        // Cell auxiliar para acomodar la fecha
        $this->Multicell(38,0,'',0,'C',false,0);
        $this->Multicell(12,0,'Fecha :',1,'L',false,0);
        $this->SetFont('helvetica','',$fontsize);
        $this->Multicell(0,0,$fecha,0,'L',false,1);

        $this->SetFont('helvetica','B',$fontsize);
        $this->Multicell(55,0,'',0,'R',false,0);
        $this->Multicell(60,0,'Celular: 9991 33 43 20',0,'C',false,1);
        /*$this->Multicell(50,0,'No. Cliente :',0,'R',false,0);
        $this->SetFont('helvetica','',$fontsize);
        $this->Multicell(30,0,str_pad($idcliente, 6, "0", STR_PAD_LEFT),0,'R',false,1);*/

        $this->SetFont('helvetica','B',$fontsize);
        $this->Multicell(66,0,'',0,'R',false,0);
        $this->SetFillColor(255,255,0);
        $this->Multicell(38,0,' Soporte: 999 1 12 23 22',0,'C',true,1);
        $this->SetFillColor(255,255,255);
        
        
    }
		
    public function Footer() 
    {
    }
}
?>