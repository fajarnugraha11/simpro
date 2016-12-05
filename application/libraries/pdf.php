<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pdf {

    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/mpdf_v6/mpdf.php';

        if ($param == NULL)
        {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';
        }
        return new mPDF($param);
    }
    
    function print_data($html, $size, $pdfName, $action){
        $pdf = $this->load();
        ini_set('memory_limit', '32M');
        $pdf->mpdf('c',$size,'','' , 0 , 0 , 0 , 0 , 0 , 0, 'P');
        $pdf->SetTitle($pdfName);
        $pdf->WriteHTML($html);
        if($action == 'print'){
            $pdf->Output(); //print
        }else{
            $pdf->Output($pdfName,'D'); //download
        }
    }

    function save_pdf_file($html, $size, $pdfName, $source){
        $pdf = $this->load();
        ini_set('memory_limit', '32M');
        $pdf->mpdf('c',$size,'','' , 0 , 0 , 0 , 0 , 0 , 0, 'P');
        $pdf->SetTitle($pdfName);
        $pdf->WriteHTML($html);
        $pdf->Output($source,'F');

    }

    function get_existing_pdf($size,$source){
        $pdf = $this->load();
        $pdf->mpdf('',$size,'','',0,0,0,0,0,0);
        $pdf->SetImportUse();
        $pagecount = $pdf->SetSourceFile($source);
        $tplId = $pdf->ImportPage($pagecount);
        $pdf->UseTemplate($tplId);
        $pdf->WriteHTML('');
        $pdf->Output();
    }
}