<?php
session_start();
require('fpdf.php');
require('../config.php');
$user=$_SESSION['user'];
$month=date('m');
	$year=date('Y');
	$amount=0;
	$pmount=0;
	if ($month==1){
		$month=12;
		$year--;
	}
	else
		$month--;
	
	$result=mysql_query("select sum(amount) as tamount from bill where cid=(select cid from customer where email='$user') and status ='DUE' and bill_date >= '$year-$month-01'");
	$count=mysql_num_rows($result);
	if($count != 0){
		$row=mysql_fetch_array($result);
		$amount=$row['tamount'];
	}
	
	$result=mysql_query("select sum(amount) as pamount from bill where cid=(select cid from customer where email='$user') and status ='DUE' and bill_date < '$year-$month-01'");
	$count=mysql_num_rows($result);
	if($count != 0){
		$row=mysql_fetch_array($result);
		$pamount=$row['pamount']+$row['pamount']*5/100;
	}
class PDF extends FPDF
{
	var $B;
	var $I;
	var $U;
	var $HREF;

	function PDF($orientation='P', $unit='mm', $size='A4')
	{
	    // Call parent constructor
	    $this->FPDF($orientation,$unit,$size);
	    // Initialization
	    $this->B = 0;
	    $this->I = 0;
	    $this->U = 0;
	    $this->HREF = '';
	}

	function WriteHTML($html)
	{
	    // HTML parser
	    $html = str_replace("\n",' ',$html);
	    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	    foreach($a as $i=>$e)
	    {
	        if($i%2==0)
	        {
	            // Text
	            if($this->HREF)
	                $this->PutLink($this->HREF,$e);
	            else
	                $this->Write(5,$e);
	        }
	        else
	        {
	            // Tag
	            if($e[0]=='/')
	                $this->CloseTag(strtoupper(substr($e,1)));
	            else
	            {
	                // Extract attributes
	                $a2 = explode(' ',$e);
	                $tag = strtoupper(array_shift($a2));
	                $attr = array();
	                foreach($a2 as $v)
	                {
	                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
	                        $attr[strtoupper($a3[1])] = $a3[2];
	                }
	                $this->OpenTag($tag,$attr);
	            }
	        }
	    }
	}

	function OpenTag($tag, $attr)
	{
	    // Opening tag
	    if($tag=='B' || $tag=='I' || $tag=='U')
	        $this->SetStyle($tag,true);
	    if($tag=='A')
	        $this->HREF = $attr['HREF'];
	    if($tag=='BR')
	        $this->Ln(5);
	}

	function CloseTag($tag)
	{
	    // Closing tag
	    if($tag=='B' || $tag=='I' || $tag=='U')
	        $this->SetStyle($tag,false);
	    if($tag=='A')
	        $this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
	    // Modify style and select corresponding font
	    $this->$tag += ($enable ? 1 : -1);
	    $style = '';
	    foreach(array('B', 'I', 'U') as $s)
	    {
	        if($this->$s>0)
	            $style .= $s;
	    }
	    $this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
	    // Put a hyperlink
	    $this->SetTextColor(0,0,255);
	    $this->SetStyle('U',true);
	    $this->Write(5,$txt,$URL);
	    $this->SetStyle('U',false);
	    $this->SetTextColor(0);
	}
	// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(127,100,50);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40,30,40,40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
        //$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
      //  $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$name=mysql_query("Select * from customer where email='$user'");
$row=mysql_fetch_array($name);

$html = '<b>Name : </b>'.$row["name"].'<br><br><b>Email : </b>'.$row["email"].'<br><br><b>Phone : </b>'.$row["phone"].'<br><br><b>Address: </b>'.$row["address"].'<br> ';

$pdf = new PDF();
// First page
$pdf->AddPage();
$pdf->SetFont('Arial','',20);
//$pdf->Write(5,"EDBMS BILL ",'0','1','C');
$pdf->Cell(0,10,'EDBMS BILL STATUS',1,0,'C');
$pdf->SetFont('','U');
$pdf->SetFont('');
$pdf->ln('20');
$pdf->SetLeftMargin(10);
$pdf->SetFontSize(14);
$pdf->WriteHTML($html);
$pdf->ln('10');
$tamount=$amount+$pamount;
$header = array('Month','Amount','Due Date','Status');
$pdf->SetFont('Arial','',14);
$data=array();
$result=mysql_query("select * from bill where bill.cid =( select cid from customer where email='".$user."' )");

while($row=mysql_fetch_array($result)){
	
	$array=explode('-',$row['bill_date']);
	if($array[1]==12){
		$array[0]+=1;
		$array[1]=1;
	}
	else
		$array[1]+=1;
	$element=$array[0]."-".$array[1]."-".$array[2];
	
	$arr=array($row['bill_date'],$row['amount'],$element,$row['status']);
	array_push($data, $arr);
}

$pdf->FancyTable($header,$data);

$pdf->Output();
// Second page
//$pdf->AddPage();
//$pdf->SetLink($link);
//$pdf->Image('logo.png',10,12,30,0,'','http://www.fpdf.org');
?>