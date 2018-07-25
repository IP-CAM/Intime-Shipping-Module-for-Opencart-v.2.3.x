<?php
class ModelExtensionShippingIntime extends Model {
	function getQuote($address) {
		$this->load->language('extension/shipping/intime');
		$method_data = array();
		$status = $this->config->get('intime_status');
		$this->document->addScript("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js");
		$this->document->addStyle("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css");
		$this->document->addScript("/index.php?route=information/intime");


			$p_receiver_locality_id = end(explode(".", $this->config->get('intime_order_city')));
			$p_receiver_warehouse_id = end(explode(".", $this->config->get('intime_order_branch')));




				
					$products = $this->cart->getProducts();
			$total = 0;
			$seat = "";
			foreach ($products as $product) {
							$total += $product['total']; 
							$seat .= '<SEAT>
										<GOODS_TYPE_ID>1</GOODS_TYPE_ID>
										<WEIGHT_M>'.round($product['weight'],0).'</WEIGHT_M>
										<LENGTH_M>'.round($product['length'],0).'</LENGTH_M>
										<WIDTH_M>'.round($product['width'],0).'</WIDTH_M>
										<HEIGHT_M>'.round($product['height'],0).'</HEIGHT_M>
										<COUNT_M>1</COUNT_M>
										<GOODS_TYPE_DESCR_ID>'.$this->config->get('intime_goods').'</GOODS_TYPE_DESCR_ID>
										<BOX_ID></BOX_ID>
									</SEAT>';

			}


			 $data['p_api_key'] = $this->config->get('intime_api_key');
		     $data['p_sender_locality_id'] = $this->config->get('intime_LOCALITY');
		     $data['p_sender_warehouse_id'] = $this->config->get('intime_BRANCH');
		     $data['p_receiver_surname'] =  $address['lastname']==''?'Иванов':$address['lastname'];
		     $data['p_receiver_firstname'] = $address['firstname']==''?'Иван':$address['firstname'];
		     $data['p_receiver_patronymic'] = '';
		     $data['p_receiver_cellphone'] = '380999999999';
		     $data['p_receiver_locality_id'] = $address[$p_receiver_locality_id];
		     $data['p_receiver_warehouse_id'] = $address[$p_receiver_warehouse_id];
		     $data['p_payment_type_id'] = $this->config->get('intime_payment_type_id');
			 $data['p_payer_type_id'] = $this->config->get('intime_payer_type_id');
		     $data['p_cost_return'] = $total;










		       $data['p_clob_seats'] = '<SEATS>'.$seat.'</SEATS>';



				$cost = $this->send($data,'DECLARATION_CALCULATE')->Entry_declaration_calculate;

				// var_dump($cost);


		       if(isset($cost->sname)){

		       			       	$cost = 0;

		       }else{
		       	$cost = $cost[2]->amount_d;
		       }

				


		if ($status) {
			$quote_data = array();

			$quote_data['intime'] = array(
				'code'         => 'intime.intime',
				'title'        => "Интайм",
				'cost'         => (int)$cost,
				'tax_class_id' => $cost,

				'text'         => $this->currency->format($this->tax->calculate($this->config->get('flat_cost'), $this->config->get('flat_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
			);

			$method_data = array(
				'code'       => 'intime',
				'title'      => "Интайм",
				'quote'      => $quote_data,
				'sort_order' => 1,
				'error'      => false
			);
		}

		return $method_data;
	}

		protected function send($data,$type){
		$client = new SoapClient("http://esb.intime.ua:8080/services/intime_api_3.0?wsdl");
    	return $client->__soapCall($type,[$type=>$data]);
	}
}