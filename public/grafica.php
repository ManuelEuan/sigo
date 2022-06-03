<?php 
	if(isset($_GET['t']))
		$tipo = $_GET['t'];
	else{
		echo "Debe proporcionar un tipo de imagen.. CREATE IMAGE ERROR";
	}
	if(isset($_GET['vtotal'])&&isset($_GET['vpctv']))
	{
		$total = $_GET['vtotal'];
		$pctv = $_GET['vpctv'];
		
	}else{
		echo "Error al cargar la imagen";
		exit;
	}
	function barra_avance($im, $total, $pctv)
	{
		$fondo = imagecolorallocate($im, 255, 255, 255);
		$arc100 = imagecolorallocate($im, 19,126,255);
		$arcpct = imagecolorallocate($im, 159,195,247);
		$letra = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im,0,0,400,100, $fondo);
		
		imagestring ($im, 2,10,10,"Avance",$letra);
		imagestring ($im, 2,10,30,$pctv,$letra);
		imagestring ($im, 2,40,30,"|",$letra);
		imagestring ($im, 2,350,10,"Meta",$letra);
		imagestring ($im, 2,350,30,$total,$letra);

		imagefilledrectangle($im, 45, 33, 340, 41, $arc100);
	}
	function graficar($im, $total, $pctv)
	{
		if($total<=0)
		{
			$fondo = imagecolorallocate($im, 255, 255, 255);
			imagefilledrectangle($im,0,0,400,300, $fondo);
			$letra = imagecolorallocate($im, 0, 0, 0);
			imagestring ($im, 3,100,50,"Error en imagen",$letra);	
			
			return;
		}
		$fuente = dirname(__FILE__). '/fonts/Arial.ttf';
		
		$fondo = imagecolorallocate($im, 255, 255, 255);
		$arc100 = imagecolorallocate($im, 41, 34, 91);
		$arcpct = imagecolorallocate($im, 31, 111, 182);
		$letra = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im,0,0,400,300, $fondo);
		if($total!=0)
		{
			imagefilledarc($im,200,150,250,250,0,270,$arc100,IMG_ARC_EDGED);
			imagefilledarc($im,200,150,200,200,0,270,$fondo,IMG_ARC_EDGED);
		}
		
		$pct = $pctv*270/$total;

		//$pct = 240;
		//imagefilledarc($im,200,150,150,150,0,$pct,$arcpct,IMG_ARC_EDGED);
		if($pct>0)
		{
		imagefilledarc($im,200,150,150,150,0,$pct,$arcpct,IMG_ARC_EDGED);
		imagefilledarc($im,200,150,100,100,0,$pct,$fondo,IMG_ARC_EDGED);
		}
		imagefilledrectangle($im,230,40,260,50, $arcpct);
		imagefilledrectangle($im,230,80,260,90, $arc100);
		
		$texto = '$ '.number_format($pctv, 2,'.',',');
		$texto2 ='$'.number_format($total,2,'.',',');
		imagettftext($im,10,0,265,50,$letra,$fuente,"Ppto ejercido");
		imagettftext($im,10,0,265,70,$letra,$fuente,$texto);
		imagettftext($im,10,0,265,90,$letra,$fuente,"Ppto modificado");
		imagettftext($im,10,0,265,110,$letra,$fuente,$texto2);
		//imagestring ($im, 1,265,50,"Ppto ejercido: $".$pctv,$letra);
		//imagestring ($im, 1,265,70,"Ppto modificado: $".$total,$letra);	
	}
	
	header("Content-type: image/png");
	if($tipo=='b')
		$width = 300;
	else
		$width = 60;
	$image = imagecreatetruecolor(400,$width);
	if($tipo=='b')
		graficar($image, $total, $pctv);
	else
		barra_avance($image, $total, $pctv);

	imagePNG($image);
	imagedestroy($image);
?>