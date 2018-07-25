<?php
class ControllerInformationIntime extends Controller {
	private $error = array();

	public function index() {

				header('Content-type: text/javascript');
				$data = [];

				$data['area']['name'] =  $this->config->get('intime_order_area');
				$data['city']['name'] =  $this->config->get('intime_order_city');
				$data['branch']['name'] =  $this->config->get('intime_order_branch');




				$this->response->setOutput($this->load->view('information/intime', $data));

			}




protected function array_to_xml( $data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_numeric($key) ){
            $key = 'item'.$key; //dealing with <0/>..<n/> issues
        }
        if( is_array($value) ) {
            $subnode = $xml_data->addChild($key);
            $this->array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
     }
}


	public function test(){


			header("Content-type: text/xml");

 			$array = [];



 			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>');
 
			// используем функцию преобразования
			echo $this->array_to_xml($array,$xml)->asXML();
			 
			




		//  $data['p_api_key'] = $this->config->get('intime_api_key');
		//      $data['p_sender_locality_id'] = $this->config->get('intime_LOCALITY');
		//      $data['p_sender_warehouse_id'] = $this->config->get('intime_BRANCH');
		//      $data['p_receiver_surname'] =  "Рибка";
		//      $data['p_receiver_firstname'] = 'Елена';
		//      $data['p_receiver_patronymic'] = 'Витальевна';
		//      $data['p_receiver_cellphone'] = '380669405202';
		//      $data['p_receiver_locality_id'] = '31234';
		//      $data['p_receiver_warehouse_id'] = '2279';
		//      $data['p_payment_type_id'] = '1';
		// 	 $data['p_payer_type_id'] = '2';
		//      $data['p_cost_return'] = '13000';
		//      $data['p_clob_seats'] = '<SEATS>
		// 		<SEAT>
		// 		<GOODS_TYPE_ID>1</GOODS_TYPE_ID>
		// 		<WEIGHT_M>2</WEIGHT_M>
		// 		<LENGTH_M>10</LENGTH_M>
		// 		<WIDTH_M>10</WIDTH_M>
		// 		<HEIGHT_M>10</HEIGHT_M>
		// 		<COUNT_M>1</COUNT_M>
		// 		<GOODS_TYPE_DESCR_ID>241</GOODS_TYPE_DESCR_ID>
		// 		<BOX_ID></BOX_ID>
		// 		</SEAT>
		// </SEATS>';


		// 		$AREA = $this->send($data,'DECLARATION_CALCULATE');

		// 		echo "<pre>";
		//      	var_dump($AREA);
		//      	echo "</pre>";


	}


	public function area(){
		$data = $this->send(['country_id'=>215],'GET_AREA_FILTERED');
		if(isset($data->Entry_get_area_filtered)){
			echo json_encode($data->Entry_get_area_filtered);
		}else{
			echo json_encode([]);

		}
	}


	public function city(){
		$data = $this->send(['country_id'=>'215','area_id'=>$_GET['area']],'GET_LOCALITY_FILTERED');
		if(isset($data->Entry_get_locality_filtered)){
			echo json_encode($data->Entry_get_locality_filtered);
		}else{
			echo json_encode([]);

		}
	}



	public function branch(){
		$data = $this->send(['country_id'=>'215','area_id'=>$_GET['intime_area'],'locality_id'=>$_GET['intime_LOCALITY']],'GET_BRANCH_FILTERED');

		if(isset($data->Entry_get_branch_filtered)){
			echo json_encode($data->Entry_get_branch_filtered);
		}else{
			echo json_encode([]);

		}
	}
		protected function toArray($var) {
		is_object($var) AND $var = (array) $var;
		if (is_array($var)) {
			foreach ($var as $key => $value) {
				is_object($value) AND $value = (array) $value;
				$var[$key] = $this->toArray($value);
			}
		}
		return $var;
	}
		protected function send($data,$type){
	    $data['api_key'] = $this->config->get('intime_api_key');
		$result = $this->cache->get($type.md5(implode(",", $data)));
		if($result){
			$result = json_decode(json_encode($result),false);
			return $result;
		}else{
		$client = new SoapClient("http://esb.intime.ua:8080/services/intime_api_3.0?wsdl");
		$result = $client->__soapCall($type,[$type=>$data]);
		$this->cache->set($type.md5(implode("", $data)),$result);
		return $result;
		}


	}
}
