<?php

use Mpdf\Tag\Strong;

/**



 *



 */



class Page_pdf2Controller extends Page_mainController



{



    public function generarAction()



    {



        require_once VENDOR_PATH . 'autoload.php';



        ini_set("pcre.backtrack_limit", "5000000");



        $this->setLayout('blanco');



        ini_set("memory_limit", -1);



        //require_once __DIR__ . '/vendor/autoload.php';



        // Create an instance of the class:



        $mpdf = new \Mpdf\Mpdf();



        $url = $this->_getSanitizedParam("url");



        $orientacion = $this->_getSanitizedParam("o");



        $formsave = $this->_getSanitizedParam("formsave");



        $sign = $this->_getSanitizedParam("sign");



        if (strpos($url, "pdfcertificate") !== false) {



            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 230]]);



        }
        



        $mystring = $_SERVER['REQUEST_URI'];



        $findme   = '/page/formmar1pdf';



        $pos = strpos($mystring, $findme);



        $mystring = $_SERVER['REQUEST_URI'];



        $findme30   = '/page/emarpdf';



        $pos30 = strpos($mystring, $findme30);



        $findme4   = '/page/formmar2pdf';



        $pos4 = strpos($mystring, $findme4);



        $findme7   = '/page/emarpdf';



        $pos7 = strpos($mystring, $findme7);



        $findme15   = '/page/emarpdf';



        $pos15 = strpos($mystring, $findme15);



        $findme8   = '/page/formbehaviorpdf';



        $pos8 = strpos($mystring, $findme8);



        $mystring9 = $_SERVER['REQUEST_URI'];



        $findme9   = 'quaterly';



        $pos9 = strpos($mystring9, $findme9);



        $mystring90 = $_SERVER['REQUEST_URI'];



        $findme90   = 'emarpdfhistorical';



        $pos90 = strpos($mystring90, $findme90);



        $findme40   = '/page/formmar4pdf';



        $pos40 = strpos($mystring, $findme40);



        if (($pos9) && $orientacion != "P") {



            $mpdf->AddPage('L', '', '', '', '', 1, 1, 7, 1, 1, 1);



        } else if (($pos8 || $pos9) && $orientacion != "P") {



            $mpdf->AddPage('L', '', '', '', '', 1, 1, 8, 1, 1, 1);



        } else if (($pos4 || $pos7 || $pos15 || $pos || $pos90 || $pos40) && $orientacion != "P") {



            $mpdf->AddPage('L', '', '', '', '', 2.5, 2.5, 6.5, 1.5, 1.5, 1.5);



        } else if ($orientacion != "P") {



            $mpdf->AddPage('L', '', '', '', '', 8, 8, 7, 8, 8, 8);



        }



        $mpdf->SetFont('Helveltica', 'B', '10');



        $mpdf->setDisplayMode('fullpage');



        $mpdf->defaultheaderline = false;



        $mpdf->defaultfooterline = false;
        
        
        



        if ($orientacion == "P") {



            $mpdf->AddPage('P');



        }



        $residentes = new Page_Model_DbTable_Residentes();



        $locationModel = new Page_Model_DbTable_Locations();



        $clientsModel = new Page_Model_DbTable_Clients();



        $list = $residentes->getById($_GET['id']);



        $id = $this->_getSanitizedParam("id");



        $year = date('Y');



        $formPhysicianModel = new Page_Model_DbTable_Formphysicianreport;



        $locationData = $locationModel->getById($list->residente_house);



        $clientData = $clientsModel->getById($locationData->location_client);



        $formphysician = $formPhysicianModel->getList("form_physician_report_id='$id' AND form_version='$year'");



        $pdfheadernombre = $list->residente_first_name . " " . $list->residente_last_name;



        $namecompleteresident = $list->residente_first_name . " " . $list->residente_middle_name . " " . $list->residente_last_name;



        $imagen = $list->residente_profile_picture;



        $telephoneResident =  $list->residente_physician_telephone;



        $diagnosis = $formphysician[0]->form_physician_report_primary_diagnosis_description . '-' . $list->residente_primary_diagnostics;



        $roomModel = new Page_Model_DbTable_Rooms;



        $allergiesResident = $formphysician[0]->form_physician_report_allergies_description . '-' . $list->residente_allergies;



        $physicianName = $list->residente_physician_name . ' ' . $list->residente_physician_name_last;



        $dateOfBirth =  formatodmY($list->residente_DOB);



        $room = $roomModel->getById($list->residente_room);



        $roomName = $room->room_name;



        $day = date('d');



        $month = date('m');



        $year = date('Y');



        if ($list->residente_sex == 'femenine' || $list->residente_sex == 'female') {



            $sexResident = "Female";



        } else {



            $sexResident = "Male";



        }



        $datesort = $_GET['datesort'];



        if ($datesort) {



            $pdfheader = $clientData->client_name . ' - ' . $datesort . '';



        } else {



            $pdfheader = $clientData->client_name . ' - ' . $month . '/' . $day . '/' . $year . '';



        }



        if ($_GET['date']) {



            $arrayMonth = array();



            $arrayMonth["1"] = "January";



            $arrayMonth["2"] = "February";



            $arrayMonth["3"] = "March";



            $arrayMonth["4"] = "April";



            $arrayMonth["5"] = "May";



            $arrayMonth["6"] = "June";



            $arrayMonth["7"] = "July";



            $arrayMonth["8"] = "August";



            $arrayMonth["9"] = "September";



            $arrayMonth["10"] = "October";



            $arrayMonth["11"] = "November";



            $arrayMonth["12"] = "December";



            $arrDate = explode("__", $_GET['date']);



            $monthFilter = $arrDate[0];



            $yearFilter = $arrDate[1];



            $pdfheader = $clientData->client_name . "(" . $arrayMonth[$monthFilter] . " " . $yearFilter . ")";



        }



        $mystring5 = $_SERVER['REQUEST_URI'];



        $findme5   = 'formmar1pdf';



        $pos5 = strpos($mystring5, $findme5);



        $mystring20 = $_SERVER['REQUEST_URI'];



        $findme20   = 'formmar2pdf';



        $pos20 = strpos($mystring20, $findme20);



        $findme10   = 'skincheck';



        $pos10 = strpos($mystring5, $findme10);



        if ($pos5 == true || $pos4 == true || $pos30 == true || $pos15 == true || $pos40 == true) {



            $mpdf->SetHTMLHeader('<table style="font-family: Arial, Helvetica, sans-serif;text-align: left; font-weight: bold;"><tr><td width="60%">' . $pdfheadernombre . '</td><td>' . $pdfheader . '</td></tr></table>', 'O', true);



            $mpdf->SetHTMLFooter('



            <table class="tablemar2" style="width:100%">



                <tr class="text-center">



                    <th rowspan="4" width="8%" class=" pb">



                        <img src="/images/'.$imagen.'" alt="" height="82" width="82">



                    </th>



                    <th width="15%" style="text-align:center;border:1px solid #B6B3B3;" class=" pb">



                        <font size="2">Resident/Patient/Client</font><br>



                    </th>



                    <th width="35%" style="text-align:center;border:1px solid #B6B3B3;" class=" pb " colspan="2">



                        <font size="2">Diagnosis</font><br>



                    </th>



                    <th width="35%" style="text-align:center;border:1px solid #B6B3B3;" class=" pb " colspan="2">



                        <font size="2">Allergies</font><br>



                    </th>



                </tr>



                <tr class="text-center">



                    <td font size="2" style="text-align:center;border:1px solid #B6B3B3;font-size: 12px;" >' . $namecompleteresident . '</td>



                    <td font size="2" style="border:1px solid #B6B3B3;font-size: 12px;" colspan="2">' . $diagnosis . '</td>



                    <td font size="2" style="border:1px solid #B6B3B3;font-size: 12px;" colspan="2">' . $allergiesResident . '</td>



                </tr>



                <tr class="text-center">



                    <th width="15%" style="text-align:center;border:1px solid #B6B3B3;" class=" pb ">



                        <font size="2">Date of Birth</font><br>



                    </th>



                    <th style="text-align:center;border:1px solid #B6B3B3;" class=" pb ">



                        <font size="2">Physician&#39;s name</font><br>



                    </th>



                    <th style="text-align:center;border:1px solid #B6B3B3;" class=" pb ">



                        <font size="2">Physician&#39;s Telephone</font><br>



                    </th>



                    <th style="text-align:center;border:1px solid #B6B3B3;" class=" pb ">



                        <font size="2">Room</font><br>



                    </th>



                    <th style="text-align:center;border:1px solid #B6B3B3;" class=" pb ">



                        <font size="2">Sex</font><br>



                    </th>



                </tr>



                <tr class="text-center">



                    <td font size="2" style="text-align:center;border:1px solid #B6B3B3;font-size: 12px;">' . $dateOfBirth . '</td>



                    <td font size="2" style="text-align:center;border:1px solid #B6B3B3;font-size: 12px;" >' . $physicianName . '</td>



                    <td font size="2" style="text-align:center;border:1px solid #B6B3B3;font-size: 12px;" >' . $telephoneResident . '</td>



                    <td font size="2" style="text-align:center;border:1px solid #B6B3B3;font-size: 12px;">' . $roomName . '</td>



                    <td font size="2" style="text-align:center;border:1px solid #B6B3B3;font-size: 12px;">' . $sexResident . '</td> 



                </tr>



            </table>



        ', 'O', true);



        }



        $mystring6 = $_SERVER['REQUEST_URI'];



        $findme6   = 'formmar2pdf';



        $pos6 = strpos($mystring6, $findme6);



        if ($pos6 == true) {



            $mpdf->SetHTMLHeader('<table style="font-family: Arial, Helvetica, sans-serif;text-align: left; font-weight: bold;"><tr><td width="60%">' . $pdfheadernombre . '</td><td>' . $pdfheader . '</td></tr></table>', 'O', true);



        }



        $mystring7 = $_SERVER['REQUEST_URI'];



        $findme7   = 'emarpdf';



        $pos7 = strpos($mystring7, $findme7);



        if ($pos7 == true) {



            $mpdf->SetHTMLHeader('<table style="font-family: Arial, Helvetica, sans-serif;text-align: left; font-weight: bold;"><tr><td width="60%">' . $pdfheadernombre . '</td><td>' . $pdfheader . '</td></tr></table>', 'O', true);



        }


        

        /*Pages order*/
        $findme_pf2   = 'profilesheet2';

        $mystring_pf2 = $_SERVER['REQUEST_URI'];

        $pos_pf2 = strpos($mystring_pf2, $findme_pf2);

        if($pos_pf2!==false ){

            //echo "...";

            $mpdf->SetHTMLFooter('<table width="96%" style="border: 0px;"><tr><td width="90%" align="center" style="border: 0px; padding-left: 15%">As of '.date("m/d/Y").'</td><td width="10%" align="right" style="border: 0px;">{PAGENO} of {nbpg}</td></tr></table>','O', true);
            

        }



        /*=====================================
                 View room directory
         ======================================*/ 
         
        $find_roomdirectory  = 'roomdirectory';
        $request_url = $_SERVER['REQUEST_URI'];

        $view_room = strpos($request_url, $find_roomdirectory);

        if($view_room!==false){
            
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 230]]);

            $mpdf->SetHTMLFooter('
                <div style="margin-top:12px">
                <table width="100%" style="border: 0px; margin-top:10px; padding-top:10px">
                    <tr>    
                        <td style="width=25%;">
                           <div style="color:#333333; float:left; width:15%; font-weight:100; font-size:11px;">Powered by Caring Data</div> 
                          
                          
                        </td>
                        <td width="65%"  style="color:#333333; border:0; text-align:center; font-weight:100; font-size:11px; padding-right:10px">
                            As of '.date("m/d/Y").'
                        </td>
                        <td width="10%"  style="border: 0px; color:#333333;  text-align:center; font-weight:100; font-size:11px;">
                            {PAGENO} of {nbpg}
                        </td>
                    </tr>
                </table> </div>','O', true);
                
                /*Margin auto*/
                $mpdf->setAutoBottomMargin = 'stretch';
                
        }
        /*Fin view pdf rom-directory*/



        /*=====================================
            View 
         ======================================*/
         $find_formmorsefallscale  = 'formmorsefallscalepdf';
         $request_url = $_SERVER['REQUEST_URI'];
 
         $view_sefall = strpos($request_url, $find_formmorsefallscale);
 
         if($view_sefall!==false){
            //Obtener el los datos del cliente 
            $id_client = $this->_getSanitizedParam('client_id');
            if($id_client){
                $clientModel = new Page_Model_DbTable_Clients();
                $client = $clientModel->getById($id_client);
                //$this->_view->client_datas = $client;
            }
            

        }





        //$mpdf->SetHeader('Document Title|');

        //$pdf->SetHeaderData('Logo.png', 50,$codigo,$titulo);



        // Write some HTML code:



        //$mpdf->WriteHTML('Hello World');



        $url = $this->_getSanitizedParam("url");



        $orientacion = $this->_getSanitizedParam("o");



        $type = $this->_getSanitizedParam("type");



        $days = $this->_getSanitizedParam("days");



        $start_date = $this->_getSanitizedParam("start_date");



        $end_date = $this->_getSanitizedParam("end_date");



        $month1 = $this->_getSanitizedParam("month1");



        $month2 = $this->_getSanitizedParam("month2");



        $month3 = $this->_getSanitizedParam("month3");



        $year1 = $this->_getSanitizedParam("year1");



        $year2 = $this->_getSanitizedParam("year2");



        $year3 = $this->_getSanitizedParam("year3");



        $resident = $this->_getSanitizedParam("resident");



        $location = $this->_getSanitizedParam("location");



        $date = $this->_getSanitizedParam("date");



        $kt_client_id = $this->_getSanitizedParam("kt_client_id");



        $client_id = $this->_getSanitizedParam("client_id");



        $clientModel = new Page_Model_DbTable_Clients();



        $this->_view->client = $clientModel->getById($_GET['client_id']);



        



        $resident_id = $_GET["resident_id"];



        $version = $_GET["version"];



        //echo "http://auditorias_medicas.local".$url."&pdf=1";



        $signature_id = $this->_getSanitizedParam("signature");



        $profile = $this->_getSanitizedParam("profile");



        //$host = "http://localhost:8043";



        //$host = "http://www.zephyrapp.tk";



        $host = URL_COMPLETA;



        //$host=$_SERVER["HTTP_HOST"];



        $signature_id = $this->_getSanitizedParam("signature");



        $year = $this->_getSanitizedParam("year");



        $month = $this->_getSanitizedParam("month");



        $hash = $this->_getSanitizedParam("hash");



        $d = $this->_getSanitizedParam("d");



        $signatureModel = new Administracion_Model_DbTable_Signature();



        $signature = $signatureModel->getById($signature_id);



        $this->_view->signature = $signature;



        $prueba = $this->_getSanitizedParam("prueba");



        $bootstrap = $this->_getSanitizedParam("bootstrap");



        $quaterly = $this->_getSanitizedParam("quaterly");



        $savefinalpdf = $this->_getSanitizedParam("savefinalpdf");



        $signature_admin = $this->_getSanitizedParam("signature_admin");



        $anio = $this->_getSanitizedParam("anio");



        $note_emar = $this->_getSanitizedParam("note_emar");



        $staff_id = $this->_getSanitizedParam("staff_id");



        $fecha1 = $this->_getSanitizedParam("fecha1");



        $fecha2 = $this->_getSanitizedParam("fecha2");

        $staff = $this->_getSanitizedParam("staff");
        $shift = $this->_getSanitizedParam("shift");





        //variables para certificados

        $c = $this->_getSanitizedParam("c"); //titulo del certificado

        $n = $this->_getSanitizedParam("n"); //nombre del certificado

        $h1 = $this->_getSanitizedParam("h1"); //horas del certificado

        $d1 = $this->_getSanitizedParam("d1"); //fecha del certificado



        $c = $this->desencriptarssl($c);

        $n = $this->desencriptarssl($n);

        $h1 = $this->desencriptarssl($h1);

        $d1 = $this->desencriptarssl($d1);



        $c=urlencode($c);

        $n=urlencode($n);

        $h1=urlencode($h1);        

        $d1=urlencode($d1);





        $hidde_columns = $this->_getSanitizedParam("hiddeColumns");

        $contenido = file_get_contents($host . $url . "&quaterly=" . $quaterly . "&pdf=1&type=" . $type  ."&hiddeColumns=". $hidde_columns . "&profile="  . $profile . "&days=" . $days . "&resident=" . $resident . "&location=" . $location . "&date=" . $date . "&kt_client_id=" . $kt_client_id . "&client_id=" . $client_id . "&id=" . $id . "&resident_id=" . $resident_id . "&version=" . $version . "&signature=" . $signature_id . "&hash=" . $hash . "&d=" . $d . "&month=" . $month . "&year=" . $year . "&year1=" . $year1 . "&year2=" . $year2 . "&year3=" . $year3 . "&month1=" . $month1 . "&month2=" . $month2 . "&month3=" . $month3 . "&prueba=" . $prueba . "&savefinalpdf=" . $savefinalpdf . "&signature_admin=" . $signature_admin . "&formsave=" . $formsave . "&sign=" . $sign. "&anio=" . $anio. "&start_date=" . $start_date. "&end_date=" . $end_date. "&note_emar=" . $note_emar. "&staff_id=" . $staff_id."&fecha1=" . $fecha1."&fecha2=" . $fecha2."&c=" . $c."&n=" . $n."&h1=" . $h1."&d1=" . $d1."&datesort=".$datesort."&shift=".$shift."&staff=".$staff);



        //$contenido = str_replace("http://auditoria.construye.coop",$host,$contenido);



        $contenido = str_replace('src="/images/', 'src="' . $host . '/images/', $contenido);



        $contenido = str_replace('src="/corte/', 'src="' . $host . '/corte/', $contenido);



        $contenido = html_entity_decode($contenido);



        $html = $contenido;



        //$prueba=0;



        $prueba = $this->_getSanitizedParam("prueba");



        $codificado = $this->_getSanitizedParam("d");



        if ($prueba == "") {



            if ($bootstrap == 1) {



                $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');



                $customCss = '



                .table-affect td{



        border:none !important;



    }



                body { 



    font-family: Helvetica, Sans-Serif;



}



                table,



                th,



                td {



                    border: 1px solid black;



                    border-collapse: collapse;



                }



                .table-quaterly table, .table-quaterly th, .table-quaterly td{



                    border: 1px solid #004d80;



                }



                .row {



                    margin-left: 0; 



                    margin-right: 0; 



                }



                



                .row .col-xs-1, .row .col-xs-2, .row .col-xs-3, .row .col-xs-4, .row .col-xs-5, .row .col-xs-6, .row .col-xs-7, .row .col-xs-8, .row .col-xs-9, .row .col-xs-10, .row .col-xs-11, .row .col-xs-12 {



                    padding-left: 0;



                    padding-right: 0;



                }



                



                .user_redondo {



                    background: #66a3e0;



                    border: 0;



                    border-bottom-left-radius: 0px;



                    border-bottom-right-radius: 0px;



                    border-bottom: 2px #FFFFFF solid;



                }



                .page_break {



                  page-break-before: always;



                }



                



                .tabla_sin, .tabla_sin td, .tabla_sin tr{



                    border: 1px solid white !important;



                }



                



                ';



                $combinedCss = $stylesheet . $customCss;



                $mpdf->WriteHTML($combinedCss, 1);



                $mpdf->WriteHTML($html, 2);



            } else {



                $mpdf->WriteHTML($html);



            }



            if ($formsave == "") {



                $mpdf->Output();



            } else {



                $name_pdf = "Firma" . $signature_id . $signature->form_id . ".pdf";



                if ($signature->form_id == "quarterly") {



                    $quarterlypdfModel = new Page_Model_DbTable_Quarterlypdf();



                    $dataquearterly['quarterly_pdf_namepdf'] = "Firma" . $signature_id . $signature->form_id;



                    $dataquearterly['quarterly_pdf_resident'] = $signature->resident_id; 



                    $dataquearterly['quearterly_pdf_date'] = $signature->signature_date; 



                    $dataquearterly['quearterly_pdf_client'] = $signature->facility_id;



                    



                    $quarterlypdf_id = $quarterlypdfModel->insert($dataquearterly); 



                    //$mpdf->Output();



                    //echo "entro";



                    $mpdf->Output('/home/caringdata/public_html/quarterlypdf/' . $name_pdf, 'F');



                    $signatureModel->editField($signature_id, "document", $name_pdf);



                }



                header("Location:/page/signature/list");



            }



            if($savefinalpdf==1){



                $quarterlypdfModel = new Page_Model_DbTable_Quarterlypdf();



                $name_pdf = mktime(date("H"), date("m"), date("s"), date("m")  , date("d"), date("Y"));



                $mpdf->Output('/home/caringdata/public_html/quarterlypdf/'.$name_pdf.'.pdf', 'F');



                $dataquearterly['quarterly_pdf_namepdf'] = $name_pdf;



                    $dataquearterly['quarterly_pdf_resident'] = $resident;



                    $dataquearterly['quearterly_pdf_date'] = date("Y-m-d H:i:s");



                    $dataquearterly['quearterly_pdf_client'] = $client_id;



                    $quarterlypdf_id = $quarterlypdfModel->insert($dataquearterly); 



            }



        } else {



            echo $html;



        }



        // Output a PDF file directly to the browser
        
       



    }



    public function generar2Action()



    {



        $this->setLayout('blanco');



        ini_set("memory_limit", -1);



        $url = $this->_getSanitizedParam("url");



        $orientacion = $this->_getSanitizedParam("o");



        $type = $this->_getSanitizedParam("type");



        $days = $this->_getSanitizedParam("days");



        $start_date = $this->_getSanitizedParam("start_date");



        $end_date = $this->_getSanitizedParam("end_date");



        $resident = $this->_getSanitizedParam("resident");



        $location = $this->_getSanitizedParam("location");



        $date = $this->_getSanitizedParam("date");



        $id = $this->_getSanitizedParam("id");



        $kt_client_id = $this->_getSanitizedParam("kt_client_id");



        $client_id = $this->_getSanitizedParam("client_id");



        $clientModel = new Page_Model_DbTable_Clients();



        $this->_view->client = $clientModel->getById($_GET['client_id']);



        $resident_id = $_GET["resident_id"];



        $version = $_GET["version"];



        $savefinalpdf = $this->_getSanitizedParam("savefinalpdf");



        //echo "http://auditorias_medicas.local".$url."&pdf=1";



        $signature_id = $this->_getSanitizedParam("signature");



        $profile = $this->_getSanitizedParam("profile");



        //$host = "http://localhost:8043";



        //$host = "http://www.zephyrapp.tk";



        $host = URL_COMPLETA;



        //$host=$_SERVER["HTTP_HOST"];



        $signature_id = $this->_getSanitizedParam("signature");



        $hash = $this->_getSanitizedParam("hash");



        $d = $this->_getSanitizedParam("d");



        



        $signatureModel = new Administracion_Model_DbTable_Signature();



        $signature = $signatureModel->getById($signature_id);



        $this->_view->signature = $signature;



        $contenido = file_get_contents($host . $url . "&pdf=1&type=" . $type . "&profile=" . $profile . "&days=" . $days . "&resident=" . $resident . "&location=" . $location . "&date=" . $date . "&kt_client_id=" . $kt_client_id . "&client_id=" . $client_id . "&id=" . $id . "&resident_id=" . $resident_id . "&version=" . $version . "&signature=" . $signature_id . "&hash=" . $hash . "&d=" . $d . "&savefinalpdf=" . $savefinalpdf. "&start_date=" . $start_date. "&end_date=" . $end_date);



        //$contenido = str_replace("http://auditoria.construye.coop",$host,$contenido);



        $contenido = str_replace('src="/images/', 'src="' . $host . '/images/', $contenido);



        $contenido = str_replace('src="/corte/', 'src="' . $host . '/corte/', $contenido);



        $contenido = html_entity_decode($contenido);



        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);



        $pdf->setFontSubsetting(false);



        //$pdf->SetHeaderData('Logo.png', 50,$codigo,$titulo);



        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));



        $pdf->setPrintHeader(false);



        $pdf->setPrintFooter(false);



        // set default monospaced font



        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



        // set margins



        $pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);



        $pdf->SetHeaderMargin(10);



        // set auto page breaks



        $mystring = $_SERVER['REQUEST_URI'];



        $findme   = 'formmarpdf';



        $pos = strpos($mystring, $findme);



        $mystring1 = $_SERVER['REQUEST_URI'];



        $findme1   = 'formcentrallypdf';



        $pos1 = strpos($mystring1, $findme1);



        $mystring2 = $_SERVER['REQUEST_URI'];



        $findme2   = 'formlistpdf';



        $pos2 = strpos($mystring2, $findme2);



        $mystring7 = $_SERVER['REQUEST_URI'];



        $findme7   = 'emarpdf';



        $pos7 = strpos($mystring7, $findme7);



        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



        if ($pos == true) {



            $pdf->SetAutoPageBreak(TRUE, 0);



            $pdf->SetMargins(3, 3, 3, true);



        }



        if ($pos1 == true) {



            $pdf->SetAutoPageBreak(TRUE, 0);



            $pdf->SetMargins(3, 3, 3, true);



        }



        if ($pos2 == true) {



            $pdf->SetAutoPageBreak(TRUE, 1);



            $pdf->SetMargins(11, 9, 9, 3);



        }



        if ($pos7 == true) {



            $pdf->SetAutoPageBreak(TRUE, 0);



            $pdf->SetMargins(3, 3, 3, true);



        }



        // set image scale factor



        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



        // set some language-dependent strings (optional)



        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {



            require_once(dirname(__FILE__) . '/lang/eng.php');



            $pdf->setLanguageArray($l);



        }



        if ($orientacion == "L") {



            $pdf->AddPage('L');



        } else {



            if (strpos($url, "emergency") !== FALSE) {



                $width = $pdf->pixelsToUnits(816);



                $height = $pdf->pixelsToUnits(1200);



                $resolution = array($width, $height);



                $pdf->AddPage('P', $resolution);



            } else {



                $pdf->AddPage();



            }



        }



        $pdf->SetFont('', '', 11, '', true);



        //$html='<h1>HOLA MUNDO</h1>';



        $html = $contenido;



        //$prueba=0;



        $prueba = $this->_getSanitizedParam("prueba");



        $codificado = $this->_getSanitizedParam("d");



        if ($prueba == "") {



            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



            if ($codificado) {



                $decodificado = str_replace("_", "=", $codificado);



                $dat = base64_decode($decodificado);



                $hoy = date("Y-m-d H:i:s");



                $antier2 = date("Y-m-d H:i:s", strtotime($hoy . "- 3 days"));



                if ($antier2 > $dat) {



                    header('Location: /');



                } else {



                    $pdf->Output('reporte.pdf', 'I');



                }



            }



            if (!$codificado && ($this->_getSanitizedParam("hash")) != "") {



                header('Location: /page/home/logout');



            } else {



                $pdf->Output('reporte.pdf', 'I');



            }



            $pdf->Output('reporte.pdf', 'I');



        } else {



            echo $html;



        }



    }







    public function desencriptarssl($encriptado)



    {



        $this->setLayout('blanco');



        $pass = 'OMEGA';



        $method = 'aes256';



        return openssl_decrypt($encriptado, $method, $pass);



    }







}



