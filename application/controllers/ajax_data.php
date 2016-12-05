<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ajax_data extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
    }

    public function get_day(){// set current date
        $date = '09/06/2015';
// parse about any English textual datetime description into a Unix timestamp
        $ts = strtotime($date);
// find the year (ISO-8601 year number) and the current week
        $year = date('o', $ts);
        $week = date('W', $ts);
// print week for the current date
        for($i = 1; $i <= 7; $i++) {
            // timestamp from ISO week date format
            $ts = strtotime($year.'W'.$week.$i);
            print date("m/d/Y l", $ts) . "\n";
        }
    }

    public function index()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method)
        {
            case 'PUT':
                break;
            case 'POST':
                $this->table_data($_POST);
                break;
            case 'GET':
                $this->table_data($_GET);
                break;
            case 'HEAD':
                break;
            case 'DELETE':
                break;
            case 'OPTIONS':
                break;
            default:
                break;
        }
    }


    private function table_data($var)
    {
        if(isset($var['p']))
        {
            $iWhere = "";
            $page = $var['p'];
            if(isset($var['c']) && isset($var['iC']) && isset($var['t']) && isset($var['imp']))
            {
                $aColumns = explode(baseEnDec($var['imp'], 1), baseEnDec($var['c'], 1));
                $sIndexColumn = baseEnDec($var['iC'], 1);
                $sTable = baseEnDec($var['t'], 1);
            }
            if(isset($var['w'])) $iWhere = baseEnDec($var['w'], 1);

        }else{
            echo "no isset";
        }


        /* PAGING */
        $sLimit = "";
        if ( isset( $var['iDisplayStart'] ) && $var['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $var['iDisplayStart'] ).", ".intval( $var['iDisplayLength'] );
        }

        /* ORDERING */
        $sOrder = "";
        if ( isset( $var['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $var['iSortingCols'] ) ; $i++ )
            {
                if ( $var[ 'bSortable_'.intval($var['iSortCol_'.$i]) ] == "true" )
                {
                    $myCols = preg_split("/ AS | | as /", $aColumns[ intval( $var['iSortCol_'.$i])]);
                    $myCols = $myCols[0];
                    $sOrder .= $myCols." ".($var['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
                }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }

        /* FILTERING */
        $sWhere = "";
        if ( isset($var['sSearch']) && $var['sSearch'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                if(!(strpos($aColumns[$i], 'img-') !== false) && (isset($var['bSearchable_'.$i]) && $var['bSearchable_'.$i] == "true"))
                {

                    $comColumns = preg_split("/ AS | | as /", $aColumns[$i]);
                    $sWhere .= $comColumns[0]." LIKE '%".htmlspecialchars( $var['sSearch'] )."%' OR ";
                }
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }

        /* MY FILTER WHERE */
        if(isset($iWhere))
        {

            if ( $sWhere == "" || $sWhere == NULL ) $sWhere = $iWhere;
            else $sWhere .= str_replace("WHERE ", " AND ", $iWhere);
        }

        /* QUERIES */
        $sQuery = "SELECT ";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if(strpos($aColumns[$i], 'img-') !== false)
            {
                $col = explode('-', $aColumns[$i]);
                $sQuery .= (isset($col[1])) ? "'{$col[1]}'" : "' '";
            }
            else
            {
                $sQuery .= $aColumns[$i];
            }
            if($i != intval(count($aColumns) - 1)) $sQuery .= ", ";
        }

        // EXPLODE GROUP BY
        $qTable = explode("GROUP BY", $sTable);
        $gbTable = (count($qTable) > 1) ? 'GROUP BY '.$qTable[1] : '';
        $sQuery .= "
            	FROM   {$qTable[0]}
            	{$sWhere}
                {$gbTable}
            	{$sOrder}
            	{$sLimit}
        	";
        //echo $sQuery.'<br><br>';
        $rResult = $this->db->query($sQuery);

        /* sTable REMOVE GROUP BY */
        // UNTUK NEWS DAN BLOG PERLU DI EXPLODE


        /* TOTAL ROW */
        // TAMBAHAN $gbTable untuk DOCTOR DAN USER
        $sQuery = "
        	SELECT ".$sIndexColumn."
        	FROM   $sTable
            {$iWhere}
        ";

        //echo $sQuery.'<br><br>';
        $iTotal = $this->db->query($sQuery)->num_rows();

        /* FILTERING ROW */
        if($sWhere)
        {
            $sQuery = "
            	SELECT ".$sIndexColumn."
            	FROM   {$qTable[0]}
            	{$sWhere}
                {$gbTable}
        	";
            //echo $sQuery.'<br><br>';
            $iFilteredTotal = $this->db->query($sQuery)->num_rows();
        }

        /* OUTPUT */
        $output = array(
            "sEcho" => intval($var['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => ($sWhere == "") ? $iTotal : $iFilteredTotal,
            "aaData" => array()
        );

        foreach($rResult->result() as $aRow)
        {
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $myCols = preg_split("/ AS | | as /", $aColumns[$i]);
                $myCols = $myCols[count($myCols) - 1];

                if(strpos($myCols, 'img-') !== false) {
                    $img = explode('-', $myCols);
                    $row[] = isset($img[1]) ? $img[1] : '';
                }
                else {
                    $column = explode('.', str_replace('`', '', $myCols));
                    $column = (isset($column[1])) ? $column[1] : $column[0];
                    if ( $column != ' ' ) $row[] = ($aRow->$column == " " || $aRow->$column == NULL || $aRow->$column == "") ? '-' : $aRow->$column;
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode( $output );
    }

    public function get_ajax_data_by_id(){
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method)
        {
            case 'PUT':
                break;
            case 'POST':
                $this->data_by_id($_POST);
                break;
            case 'GET':
                $this->data_by_id($_GET);
                break;
            case 'HEAD':
                break;
            case 'DELETE':
                break;
            case 'OPTIONS':
                break;
            default:
                break;
        }
    }
    public function data_by_id($var)
    {
        if(isset($var['p']))
        {
            if(isset($var['id']) && isset($var['iC']) && isset($var['t']))
            {
                $id = $var['id'];
                $fieldId = baseEnDec($var['iC'], 1);
                $table = baseEnDec($var['t'], 1);
                $whereArray = array($fieldId => $id);
                $data = $this->general_model->getByWhere($table,$whereArray);
                if ($data) {
                    $row = $data->row();
                    $json['data'] = $row;
                    $json['status'] = 1;
                } else {
                    $json['status'] = 0;
                    $json['message'] = 'data not found';
                }
            }

        }else {
            $json['status'] = 0;
            $json['message'] = 'id is empty';
        }

        echo json_encode($json);
    }

    public function get_data_multiple()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method)
        {
            case 'PUT':
                break;
            case 'POST':
                $this->data_multiple($_POST);
                break;
            case 'GET':
                $this->data_multiple($_GET);
                break;
            case 'HEAD':
                break;
            case 'DELETE':
                break;
            case 'OPTIONS':
                break;
            default:
                break;
        }
    }

    function data_multiple($var)
    {
        $json_status = 'failed';
        $json_message = 'Sorry cannot get this data.';
        $data = null;
        if(isset($var['id']) && isset($var['col']) && isset($var['table']) && isset($var['columns']) && isset($var['implode']) && $var['crudTable'])
        {
            $id = $var['id'];
            $col = baseEnDec($var['col'], 1);
            $table = baseEnDec($var['table'], 1);
            $columns = baseEnDec($var['columns'], 1);
            $implode = baseEnDec($var['implode'], 1);
            $sWhere = baseEnDec($var['where'], 1);
            $crudTable = baseEnDec($var['crudTable'], 1);

            $columns = explode($implode, $columns);

            if($sWhere != '') $sWhere .= " AND {$col} = {$id}";
            else $sWhere .= "WHERE {$col} = {$id}";

            $sQuery = "SELECT ";
            for ( $i = 0 ; $i<count($columns) ; $i++ )
            {
                if(!(strpos($columns[$i], 'img-') !== false)) $selectColumns[] = $columns[$i];
            }
            $sQuery .= implode(",", $selectColumns);
            $sQuery .= " FROM {$table} {$sWhere}";
            $this->db->cache_off();
            $sql = $this->db->query($sQuery);

            if($sql->num_rows() != 0)
            {
                $data = $sql->row_array();
                $json_status = 'success';
                $json_message = 'Success get data.';
            }
        }
        $json = array(
            'status' => $json_status
        ,'message' => $json_message
        ,'data' => $data);
        echo json_encode( $json );
    }

    public function get_data_order()
    {
        $id = $this->input->post('id');
        $whereId = array('id' => $id);
        $whereOrderId = array('order_id' => $id);
        $total_discount = 0;

        if ($id != '') {
            $data = $this->general_model->getByWhere('order',$whereId);
            $order_data = $this->general_model->getByWhere('order_data', $whereOrderId);
            $order_item = $this->general_model->get_order_item_by_id('', $id);
            $payment_method = $this->general_model->get_payment_method_by_order_id($id);
            // payment
            if ($data) {
                $row = $data->row();
                $row_data = $order_data->row();
                $row_payment = $payment_method->name;
                $iTotalRecords = $this->db->count_all('order_item');

                foreach($order_item->result() as $aRow)
                {
                    $total_discount = (($aRow->qty * $aRow->price) - (($aRow->qty * $aRow->price) * $aRow->discount / 100));

                    $row_item = array();
                    $row_item['id'] = $aRow->id;
                    $row_item['seat'] = $aRow->seat;
                    $row_item['qty'] = $aRow->qty;
                    $row_item['price'] = $aRow->price;
                    $row_item['discount'] = $aRow->discount;
                    $row_item['total'] = $total_discount;

                    $json['order_id'] = $id;
                    $json['payment_method'] = $row_payment;
                    $json['sEcho'] = 0;
                    $json['iTotalRecords'] = $iTotalRecords;
                    $json['iTotalDisplayRecords'] = $iTotalRecords;
                    $json['aaData'][] = $row_item;

                    $json['order_item'][] = $row_item;
                }

                $json['data'] = $row;
                $json['order_data'] = $row_data;
                $json['status'] = 1;
            } else {
                $json['status'] = 0;
                $json['message'] = 'data not found';
            }
        } else {
            $json['status'] = 0;
            $json['message'] = 'id is empty';
        }

        echo json_encode($json);

    }

    public function get_data_invoice()
    {
        $this->load->model('m_payment');
        $id = $this->input->post('id');
        $whereOrderId = array('order_id' => $id);
        if ($id != '') {
            $data = $this->m_payment->get_order_payment($id);
            $order_data = $this->general_model->getByWhere('order_data', $whereOrderId);
            $order_item = $this->general_model->get_order_item_by_id('', $id);
            if ($data) {
                $row = $data->row();
                $row_data = $order_data->row();
                $iTotalRecords = $this->db->count_all('order_item');

                foreach($order_item->result() as $aRow)
                {
                    $row_item = array();
                    $row_item[] = $aRow->id;
                    $row_item[] = $aRow->seat;
                    $row_item[] = 0;
                    $row_item[] = $aRow->qty;
                    $row_item[] = $aRow->price;

                    $json['order_id'] = $id;
                    $json['sEcho'] = 0;
                    $json['iTotalRecords'] = $iTotalRecords;
                    $json['iTotalDisplayRecords'] = $iTotalRecords;
                    $json['aaData'][] = $row_item;

                    $json['order_item'][] = $row_item;
                }

                $json['data'] = $row;
                $json['order_data'] = $row_data;
                $json['status'] = 1;
            } else {
                $json['status'] = 0;
                $json['message'] = 'data not found';
            }
        } else {
            $json['status'] = 0;
            $json['message'] = 'id is empty';
        }

        echo json_encode($json);

    }

    private function table_data_export($var)
    {


        if(isset($var['p']))
        {
            $iWhere = "";
            $page = $var['p'];
            if(isset($var['c']) && isset($var['iC']) && isset($var['t']) && isset($var['imp']))
            {
                $aColumns = explode(baseEnDec($var['imp'], 1), baseEnDec($var['c'], 1));
                $sIndexColumn = baseEnDec($var['iC'], 1);
                $sTable = baseEnDec($var['t'], 1);
            }
            if(isset($var['w'])) $iWhere = baseEnDec($var['w'], 1);

        }else{
            echo "no isset";
        }


        /* PAGING */
        $sLimit = "";
        if ( isset( $var['iDisplayStart'] ) && $var['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $var['iDisplayStart'] ).", ".intval( $var['iDisplayLength'] );
        }

        /* ORDERING */
        $sOrder = "";
        if ( isset( $var['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $var['iSortingCols'] ) ; $i++ )
            {
                if ( $var[ 'bSortable_'.intval($var['iSortCol_'.$i]) ] == "true" )
                {
                    $myCols = preg_split("/ AS | | as /", $aColumns[ intval( $var['iSortCol_'.$i])]);
                    $myCols = $myCols[0];
                    $sOrder .= $myCols." ".($var['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
                }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }

        /* FILTERING */
        $sWhere = "";
        if ( isset($var['sSearch']) && $var['sSearch'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                if(!(strpos($aColumns[$i], 'img-') !== false) && (isset($var['bSearchable_'.$i]) && $var['bSearchable_'.$i] == "true"))
                {

                    $comColumns = preg_split("/ AS | | as /", $aColumns[$i]);
                    $sWhere .= $comColumns[0]." LIKE '%".htmlspecialchars( $var['sSearch'] )."%' OR ";
                }
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }

        /* MY FILTER WHERE */
        if(isset($iWhere))
        {

            if ( $sWhere == "" || $sWhere == NULL ) $sWhere = $iWhere;
            else $sWhere .= str_replace("WHERE ", " AND ", $iWhere);
        }

        /* QUERIES */
        $sQuery = "SELECT ";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if(strpos($aColumns[$i], 'img-') !== false)
            {
                $col = explode('-', $aColumns[$i]);
                $sQuery .= (isset($col[1])) ? "'{$col[1]}'" : "' '";
            }
            else
            {
                $sQuery .= $aColumns[$i];
            }
            if($i != intval(count($aColumns) - 1)) $sQuery .= ", ";
        }

        // EXPLODE GROUP BY
        $qTable = explode("GROUP BY", $sTable);
        $gbTable = (count($qTable) > 1) ? 'GROUP BY '.$qTable[1] : '';
        $sQuery .= "
            	FROM   {$qTable[0]}
            	{$sWhere}
                {$gbTable}
            	{$sOrder}
            	{$sLimit}
        	";
        //echo $sQuery.'<br><br>';
        $rResult = $this->db->query($sQuery);

        /* sTable REMOVE GROUP BY */
        // UNTUK NEWS DAN BLOG PERLU DI EXPLODE


        /* TOTAL ROW */
        // TAMBAHAN $gbTable untuk DOCTOR DAN USER
        $sQuery = "
        	SELECT ".$sIndexColumn."
        	FROM   $sTable
            {$iWhere}
        ";

        //echo $sQuery.'<br><br>';
        $iTotal = $this->db->query($sQuery)->num_rows();

        /* FILTERING ROW */
        if($sWhere)
        {
            $sQuery = "
            	SELECT ".$sIndexColumn."
            	FROM   {$qTable[0]}
            	{$sWhere}
                {$gbTable}
        	";
            //echo $sQuery.'<br><br>';
            $iFilteredTotal = $this->db->query($sQuery)->num_rows();
        }

        /* OUTPUT */
        $output = array(
            "sEcho" => 0,
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => ($sWhere == "") ? $iTotal : $iFilteredTotal,
            "aaData" => array()
        );

        return $rResult;
    }

    public function exportExcel(){
        $search = $this->input->post('search');
        $table = $this->input->post('table');
        $column = $this->input->post('column');
        $indexColumn = $this->input->post('indexColumn');
        $join = $this->input->post('join');
        $where = $this->input->post('where');
        $implode = $this->input->post('implode');

        $data = array(
            'search' => $search,
            'p' => $table,
            'c' => $column,
            'iC' => $indexColumn,
            't' => $join,
            'w' => $where,
            'imp' => $implode
        );


        $query = $this->table_data_export($data);
        $this->general_model->to_excel($query, $table);
    }

    public function exportExcelAll($table = ""){


        $query = $this->general_model->getList($table, 'id');
        $this->general_model->to_excel($query, $table);
    }





}